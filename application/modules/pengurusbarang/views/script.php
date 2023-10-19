<script>
    var table;
    $(document).ready(function () {
        handle_datatable();
        handle_validate();  
    });

    function handle_datatable()
    {
        table = $("#table-pengurus").DataTable({
            processing: true,
            serverSide: true,
            order: [],

            ajax: {
                url: base_url + "backend/get_data_pengurusbarang",
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

    function save_pengurusbarang()
    {
        $('#btnSave').text('saving...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable 

        $.ajax({
            url : base_url + 'backend/edit-pengurusbarang',
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
                alert_gagal('Data Gagal Diupdate! ' +  request.status + ' ' + request.statusText);
                $('#btnSave').html('<i class="fa fa-check"></i> Save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable 
            }
        });
    }

    function edit_pengurusbarang()
    {   
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        $.ajax({
            url : base_url + "backend/get_pengurusbarang_by_id/",
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('[name="id"]').val(data.id);
                $('[name="id_user"]').val(data.id_user);                
                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Form Edit Pengurus Barang'); 
            },
            error: function (request)
            {
               alert_gagal('An error occurred during your request: ' +  request.status + ' ' + request.statusText);
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