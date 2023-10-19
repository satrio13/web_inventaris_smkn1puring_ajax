<script>
    var save_method;
    var table;
    $(document).ready(function () {
        handle_datatable();
        handle_validate();
    });

    function handle_datatable()
    { 
        table = $("#table-baranghp").DataTable({
            processing: true,
            serverSide: true,
            order: [],

            ajax: {
                url: base_url + "backend/get_data_baranghp",
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

    function add_baranghp()
    {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Form Tambah Barang Habis Pakai'); 
    }

    function save_baranghp()
    {
        $('#btnSave').text('saving...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable 
        
        let url;
        let pesan_sukses;
        let pesan_gagal;
        if(save_method == 'add')
        {
            url = base_url + "backend/tambah-baranghp";
            pesan_gagal = 'Data Gagal Disimpan! ';
        }else
        {
            url = base_url + "backend/edit-baranghp";
            pesan_gagal = 'Data Gagal Diupdate! ';
        }

        $.ajax({
            url : url,
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
                alert_gagal(pesan_gagal + request.status + ' ' + request.statusText);
                $('#btnSave').html('<i class="fa fa-check"></i> Save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable 
            }
        });
    }

    function edit_baranghp(id_baranghp)
    {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        $.ajax({
            url : base_url + "backend/get_baranghp_by_id/"+id_baranghp,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('[name="id_baranghp"]').val(data.id_baranghp);
                $('[name="kode_hp"]').val(data.kode_hp); 
                $('[name="barang"]').val(data.barang); 
                $('[name="id_kategori"]').val(data.id_kategori);                
                $('[name="satuan"]').val(data.satuan); 
                $('[name="harga"]').val(data.harga); 
                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Form Edit Barang Habis Pakai'); 
            },
            error: function (request)
            {
                alert_gagal('An error occurred during your request: ' +  request.status + ' ' + request.statusText);
            }
        });
    }

    function delete_baranghp(id_baranghp)
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
                    url : base_url + "backend/hapus-baranghp/"+id_baranghp,
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

    function handle_validate()
    {
        $("input").change(function(){
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });
        $("textarea").change(function(){
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });
        $("select").change(function(){
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
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