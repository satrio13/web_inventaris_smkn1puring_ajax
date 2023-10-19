<script>
    var site_url = '<?= site_url() ?>';
    var table_daftar_barang;
    var table_cart;
    $(document).ready(function () {
        table_daftar_barang = $("#table-pemindahan").DataTable({
            processing: true,
            serverSide: true,
            order: [],

            ajax: {
                url: base_url + "backend/get_data_pemindahan",
                type: "POST",
            },

            columnDefs: [
                {
                    targets: [0],
                    orderable: false,
                },
            ],
        });

        table_cart = $("#table-pindah").DataTable({
            processing: true,
            serverSide: true,
            order: [],

            ajax: {
                url: base_url + "backend/get_data_pindah",
                type: "POST",
            },

            columnDefs: [
                {
                    targets: [0],
                    orderable: false,
                },
            ],
        });

        tampil_data_cart_pemindahan()
        function tampil_data_cart_pemindahan()
        {
            $('#show_cart_pemindahan').load(base_url + "backend/data_cart_pemindahan");
        }

        $('#table-pemindahan').on('click','.item_addinv',function()
        {
            let id = $(this).attr('data');
            $.ajax({
                type : "GET",
                url: base_url + "backend/get_pemindahan",
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
                        tampil_data_cart_pemindahan();
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

        $('#show_cart_pemindahan').on('click','#btn_batal_pemindahan',function()
        {
            let kode = $('#id_ruang').val();
            $.ajax({
                type : "POST",
                url: base_url + "backend/hapus_batal_pemindahan",
                dataType : "JSON",
                data : {kode: kode},
                success: function(data)
                {
                    tampil_data_cart_pemindahan();
                },
                error: function (request)
                {
                    sweetAlert("An error occurred during your request: " +  request.status + ' ' + request.statusText, "", "error");
                }
            });
        });

        $('#table-pindah').on('click','.item_edit_pemindahan',function()
        {
            let id = $(this).attr('data');
            $.ajax({
                type : "GET",
                url: base_url + "backend/get_terpindah",
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
                        tampil_data_cart_pemindahan();
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

        $('#table-pindah').on('click','.item_detail',function()
        {
            let kode_pindah = $(this).attr('data');
            $.ajax({
                type : "GET",
                url: base_url + "backend/detail-pemindahan",
                dataType : "JSON",
                data : {kode_pindah:kode_pindah},
                success: function(data)
                {
                    const date = new Date(data[0].tgl_pindah);
                    $('#modal_detail').modal('show');
                    $('#kode_pindah_detail').html(': ' + data[0].kode_pindah);
                    $('#tgl_pindah_detail').html(': ' + date.toLocaleDateString('id-ID', data[0].tgl_pindah)); 
                    $('#ruang_detail').html(': ' + data[0].ruang);
                    $('#show_detail').html('');
                    $('#link_cetak').html(`<a href="`+ site_url+ 'backend/cetak-pemindahan-pdf/'+ data[0].kode_pindah +`" target="_blank" class="btn btn-danger btn-sm"><i class="fa fa-print"></i> CETAK PDF</a> <a href="`+ site_url+ 'backend/cetak-pemindahan/'+ data[0].kode_pindah +`" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> CETAK</a>`);

                    let no = 1;
                    let kondisi;
                    $.each(data, function(i){
                        if(data[i].id_kondisi == 1)
                        {
                            kondisi = '<label class="badge badge-primary">Baik</label>';
                        }else if(data[i].id_kondisi == 2)
                        {
                            kondisi = '<label class="badge bg-warning"><span class="text-white">Rusak Ringan</span></label>';
                        }else if(data[i].id_kondisi == 3)
                        {
                            kondisi = '<label class="badge bg-orange"><span class="text-white">Rusak Sedang</span></label>';
                        }else if(data[i].id_kondisi == 4)
                        {
                            kondisi = '<label class="badge badge-danger">Rusak Berat</label>';
                        }else if(data[i].id_kondisi == 5)
                        {
                            kondisi = '<label class="badge bg-maroon">Hilang</label>';
                        }else if(data[i].id_kondisi == 6)
                        {
                            kondisi = '<label class="badge bg-navy">Dihapus</label>';
                        }else
                        {
                            kondisi = '';
                        }

                        $('#show_detail').append(`
                            <tr>
                                <td class="text-center">`+ no +`</td>
                                <td>`+ data[i].kode_inv +`</td>
                                <td>`+ data[i].barang +`</td>
                                <td class="text-center">`+ kondisi +`</td>
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

        $('#table-pindah').on('click','.item_hapus_pemindahan',function()
        {
            swal({
                title: "Anda yakin menghapus data ini ?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if(willDelete)
                {
                    let kode_pindah = $(this).attr('data');
                    $.ajax({
                        url : base_url + "backend/hapus-pemindahan/"+kode_pindah,
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

        $('#show_cart_pemindahan').on('click','#btnSave',function()
        {
            $('#btnSave').text('saving...'); //change button text
            $('#btnSave').attr('disabled',true); //set button disable 

            $.ajax({
                url : base_url + "backend/simpan_pemindahan",
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
                            tampil_data_cart_pemindahan();
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
                    alert_gagal('Data Gagal Disimpan! ' +  request.status + ' ' + request.statusText);
                    $('#btnSave').html('<i class="fa fa-check"></i> Save'); //change button text
                    $('#btnSave').attr('disabled',false); //set button enable 
                }
            });
        });
        
        $('#show_cart_pemindahan').on('click','#btnEdit',function()
        {
            $('#btnEdit').text('saving...'); //change button text
            $('#btnEdit').attr('disabled',true); //set button disable 

            $.ajax({
                url : base_url + "backend/simpan_pemindahan",
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
                            tampil_data_cart_pemindahan();
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
                    alert_gagal('Data Gagal Diupdate! ' +  request.status + ' ' + request.statusText);
                    $('#btnEdit').html('<i class="fa fa-check"></i> Save'); //change button text
                    $('#btnEdit').attr('disabled',false); //set button enable 
                }
            });
        });

        $(".alert-message").alert().delay(10000).slideUp("slow");        
    });

    function delete_cart_pindah(id_baranginv)
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
                    url : base_url + "backend/hapus_cart_pemindahan/"+id_baranginv,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data)
                    {
                        if(data.status == true)
                        {
                            $('#show_cart_pemindahan').load(base_url + "backend/data_cart_pemindahan");
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