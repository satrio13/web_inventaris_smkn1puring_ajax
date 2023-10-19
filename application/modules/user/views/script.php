<script>
    var table;
    $(document).ready(function () {
        handle_datatable();
        handle_sepasi();
    });

    function handle_datatable()
    {
        table = $("#table-users").DataTable({
            processing: true,
            serverSide: true,
            order: [],

            ajax: {
                url: base_url + "backend/get_data_users",
                type: "POST",
            },

            columnDefs: [
                {
                    targets: [0],
                    orderable: false,
                },
            ],
        });
    }

    function add_user()
    {
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Form Tambah User'); 
    }

    function save_user()
    {
        $('#btnSave').text('saving...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable 

        $.ajax({
            url : base_url + "backend/tambah-user",
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function(data)
            {
                if(data.status == true) 
                {
                    $('#modal_form').modal('hide');
                    alert_sukses(data.message);
                    reload_table();
                }else
                {
                    for (let i = 0; i < data.inputerror.length; i++) 
                    {
                        $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                        $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                    }
                }
                $('#btnSave').html('<i class="fa fa-check"></i> Save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable 
            },
            error: function (request)
            {
                alert_gagal('Data Gagal Disimpan! ' +  request.status + ' ' + request.statusText);
                $('#btnSave').html('<i class="fa fa-check"></i> Save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable 
            }
        });
    }

    function edit_user(id_user)
    {
        $('#form_edit')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        $.ajax({
            url : base_url + "backend/get_user_by_id/"+id_user,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('[name="id_user"]').val(data.id_user);
                $('[name="nama"]').val(data.nama);
                $('[name="nip"]').val(data.nip);
                $('[name="username"]').val(data.username);
                $('[name="email"]').val(data.email);
                $('[name="level"]').val(data.level);                
                $('[name="is_active"]').val(data.is_active);  
                $('#modal_form_edit').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Form Edit User'); 
            },
            error: function (request)
            {
                alert_gagal('An error occurred during your request: ' +  request.status + ' ' + request.statusText);
            }
        });
    }

    function save_user_edit()
    {
        $('#btnSaveEdit').text('saving...'); //change button text
        $('#btnSaveEdit').attr('disabled',true); //set button disable 

        $.ajax({
            url : base_url + "backend/edit-user",
            type: "POST",
            data: $('#form_edit').serialize(),
            dataType: "JSON",
            success: function(data)
            {
                if(data.status == true) 
                {
                    $('#modal_form_edit').modal('hide');
                    alert_sukses(data.message);
                    reload_table();
                }else
                {
                    for (let i = 0; i < data.inputerror.length; i++) 
                    {
                        $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                        $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                    }
                }
                $('#btnSaveEdit').html('<i class="fa fa-check"></i> Save'); //change button text
                $('#btnSaveEdit').attr('disabled',false); //set button enable 
            },
            error: function (request)
            {
                alert_gagal('Data Gagal Diupdate! ' +  request.status + ' ' + request.statusText);
                $('#btnSaveEdit').html('<i class="fa fa-check"></i> Save'); //change button text
                $('#btnSaveEdit').attr('disabled',false); //set button enable 
            }
        });
    }

    function delete_user(id_user)
    {
        swal({
            title: "Anda yakin menghapus data ini ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if(willDelete)
            {
                $.ajax({
                    url : base_url + "backend/hapus-user/"+id_user,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data)
                    {
                        if(data.status == true)
                        {
                            alert_sukses(data.message);
                            reload_table();
                        }else
                        {
                            alert_gagal(data.message);
                        }
                    },
                    error: function (request)
                    {
                        alert_gagal('Data Gagal Dihapus! ' +  request.status + ' ' + request.statusText);
                    }
                });
            }
        });
    }

    function reload_table()
    {
        table.ajax.reload(); 
    }

    function handle_sepasi()
    {
        $(".sepasi").on({
            keydown: function (e) {
                if (e.which === 32) return false;
            },
            change: function () {
                this.value = this.value.replace(/\s/g, "");
            },
	    });
    }

    function alert_sukses(str)
    {
        setTimeout(function () { 
            swal({
                position: 'top-end',
                icon: 'success',
                title: str,
                timer: 1500
            });
        },2000); 
    }

    function alert_gagal(str)
    {
        setTimeout(function () { 
            swal({
                position: 'top-end',
                icon: 'error',
                title: str,
                timer: 5000
            });
        },2000); 
    }
</script>