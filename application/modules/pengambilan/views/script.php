<script>
    var site_url = '<?= site_url() ?>';
    var table_daftar_barang;
    var table_cart;
    $(document).ready(function () {
        table_daftar_barang = $("#table-pengambilan").DataTable({
            processing: true,
            serverSide: true,
            order: [],

            ajax: {
                url: base_url + "backend/get_data_pengambilan",
                type: "POST",
            },

            columnDefs: [
                {
                    targets: [0],
                    orderable: false,
                },
            ],
        });

        table_cart = $("#table-ambil").DataTable({
            processing: true,
            serverSide: true,
            order: [],

            ajax: {
                url: base_url + "backend/get_data_ambil",
                type: "POST",
            },

            columnDefs: [
                {
                    targets: [0],
                    orderable: false,
                },
            ],
        });

        tampil_data_cart()
        function tampil_data_cart()
        {
            $('#show_cart').load(base_url + "backend/data_cart");
        }

        $('#table-pengambilan').on('click','.item_add',function()
        {
            let id = $(this).attr('data');
            $.ajax({
                type : "GET",
                url: base_url + "backend/get_pengambilan",
                dataType : "JSON",
                data : {id:id},
                beforeSend: function()
                {
                    $("#load_add").html('<img src="<?= base_url('assets/img/loading-bar.gif'); ?>">');
                },
                success: function(data)
                {
                    if(data.status == true)
                    {
                        $("#load_add").html('');
                        tampil_data_cart();
                    }else
                    {
                        $("#load_add").html('');
                        sweetAlert(data.message, "", "error");
                    }
                },
                error: function (request)
                {
                    sweetAlert("An error occurred during your request: " +  request.status + ' ' + request.statusText, "", "error");
                }
            });
        });

        $('#table-ambil').on('click','.item_edit',function()
        {
            let id = $(this).attr('data');
            $.ajax({
                type : "GET",
                url: base_url + "backend/get_terambil",
                dataType : "JSON",
                data : {id:id},
                beforeSend: function()
                {
                    $("#load_edit").html('<img src="<?= base_url('assets/img/loading-bar.gif'); ?>">');
                },
                success: function(data)
                {
                    if(data.status == true)
                    {
                        $("#load_edit").html('');
                        tampil_data_cart();
                    }else
                    {
                        $("#load_edit").html('');
                        sweetAlert(data.message, "", "error");
                    }
                },
                error: function (request)
                {
                    sweetAlert("An error occurred during your request: " +  request.status + ' ' + request.statusText, "", "error");
                }
            });
        });

        $('#show_cart').on('click','#btn_batal',function()
        {
            let kode = $('#kode_trans').val();
            $.ajax({
                type : "POST",
                url: base_url + "backend/hapus_batal",
                dataType : "JSON",
                data : {kode: kode},
                success: function(data)
                {
                    tampil_data_cart();
                },
                error: function (request)
                {
                    sweetAlert("An error occurred during your request: " +  request.status + ' ' + request.statusText, "", "error");
                }
            });
        });

        $('#table-ambil').on('click','.item_detail',function()
        {
            let kode_trans = $(this).attr('data');
            $.ajax({
                type : "GET",
                url: base_url + "backend/detail-pengambilan",
                dataType : "JSON",
                data : {kode_trans:kode_trans},
                success: function(data)
                {
                    const date = new Date(data[0].tgl_keluar);
                    $('#modal_detail').modal('show');
                    $('#kode_trans_detail').html(': ' + data[0].kode_trans); 
                    $('#nama_pengambil_detail').html(': ' + data[0].nama_pengambil); 
                    $('#tgl_keluar_detail').html(': ' + date.toLocaleDateString('id-ID', data[0].tgl_keluar)); 
                    $('#jam_keluar_detail').html(': ' + data[0].jam_keluar+' WIB'); 
                    $('#login_pengambil_detail').html(': ' + data[0].nama); 
                    $('#show_detail').html('');
                    $('#link_cetak').html(`<a href="`+ site_url+ 'backend/cetak-pengambilan-pdf/'+ data[0].kode_trans +`" target="_blank" class="btn btn-danger btn-sm"><i class="fa fa-print"></i> CETAK PDF</a> <a href="`+ site_url+ 'backend/cetak-pengambilan/'+ data[0].kode_trans +`" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> CETAK</a>`);

                    let no = 1;
                    $.each(data, function(i){
                        $('#show_detail').append(`
                            <tr>
                                <td class="text-center">`+ no +`</td>
                                <td>`+ data[i].kode_hp +`</td>
                                <td>`+ data[i].barang +`</td>
                                <td>`+ data[i].jml_keluar +` `+ data[i].satuan +`</td>
                            </tr>
                        `);

                        no++;
                    });
                },
                error: function (request)
                {
                    sweetAlert("An error occurred during your request: " +  request.status + ' ' + request.statusText, "", "error");
                }
            });
        });

        $('#table-ambil').on('click','.item_hapus_pengambilan',function()
        {
            swal({
                title: "Anda yakin menghapus data ini ?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if(willDelete)
                {
                    let kode_trans = $(this).attr('data');
                    $.ajax({
                        url : base_url + "backend/hapus-pengambilan/"+kode_trans,
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
        });

        $('#show_cart').on('click','#btnSave',function()
        {
            $('#btnSave').text('saving...'); //change button text
            $('#btnSave').attr('disabled',true); //set button disable 
            
            $.ajax({
                url : base_url + "backend/simpan_pengambilan",
                type: "POST",
                data: $('#form_cart').serialize(),
                dataType: "JSON",
                success: function(data)
                {
                    if(data.error_string)
                    {
                        for (let i = 0; i < data.inputerror.length; i++) 
                        {
                            $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                            $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                        }
                    }else
                    {
                        if(data.status == true) 
                        {
                            alert_sukses(data.message);
                            tampil_data_cart();
                            reload_table();
                        }else if(data.status == false)
                        {
                            alert_gagal(data.message);
                        }
                    }
                    $('#btnSave').html('<i class="fa fa-check"></i> Save'); //change button text
                    $('#btnSave').attr('disabled',false); //set button enable 
                },
                error: function (request)
                {
                    alert_gagal('Data Gagal Disimpan!' +  request.status + ' ' + request.statusText);
                    $('#btnSave').html('<i class="fa fa-check"></i> Save'); //change button text
                    $('#btnSave').attr('disabled',false); //set button enable 
                }
            });
        });

        $('#show_cart').on('click','#btnEdit',function()
        {
            $('#btnEdit').text('saving...'); //change button text
            $('#btnEdit').attr('disabled',true); //set button disable 

            $.ajax({
                url : base_url + "backend/simpan_pengambilan",
                type: "POST",
                data: $('#form_cart').serialize(),
                dataType: "JSON",
                success: function(data)
                {
                    if(data.error_string)
                    {
                        for (let i = 0; i < data.inputerror.length; i++) 
                        {
                            $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                            $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                        }
                    }else
                    {
                        if(data.status == true) 
                        {
                            alert_sukses(data.message);
                            tampil_data_cart();
                            reload_table();
                        }else if(data.status == false)
                        {
                            alert_gagal(data.message);
                        }
                    }
                    $('#btnEdit').html('<i class="fa fa-check"></i> Save'); //change button text
                    $('#btnEdit').attr('disabled',false); //set button enable 
                },
                error: function (request)
                {
                    alert_gagal('Data Gagal Diupdate!' +  request.status + ' ' + request.statusText);
                    $('#btnEdit').html('<i class="fa fa-check"></i> Save'); //change button text
                    $('#btnEdit').attr('disabled',false); //set button enable 
                }
            });
        });
    });

    function delete_cart(id_baranghp)
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
                    url : base_url + "backend/hapus_cart/"+id_baranghp,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data)
                    {
                        if(data.status == true)
                        {
                            $('#show_cart').load(base_url + "backend/data_cart");
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
        table_daftar_barang.ajax.reload(); 
        table_cart.ajax.reload(); 
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