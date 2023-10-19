<script>
    var site_url = '<?= site_url() ?>';
    $(document).ready(function () {
        handle_validate(); 
        $('.item_detail_pengambilan').on('click',function()
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
                    $('#modal_detail_pengambilan').modal('show');
                    $('#kode_trans_detail').html(': ' + data[0].kode_trans); 
                    $('#nama_pengambil_detail').html(': ' + data[0].nama_pengambil); 
                    $('#tgl_keluar_detail').html(': ' + date.toLocaleDateString('id-ID', data[0].tgl_keluar)); 
                    $('#jam_keluar_detail').html(': ' + data[0].jam_keluar+' WIB'); 
                    $('#login_pengambil_detail').html(': ' + data[0].nama); 
                    $('#show_detail_pengambilan').html('');
                    $('#link_cetak_pengambilan').html(`<a href="`+ site_url+ '/backend/cetak-pengambilan-pdf/'+ data[0].kode_trans +`" target="_blank" class="btn btn-danger btn-sm"><i class="fa fa-print"></i> CETAK PDF</a> <a href="`+ site_url+ '/backend/cetak-pengambilan/'+ data[0].kode_trans +`" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> CETAK</a>`);

                    let no = 1;
                    $.each(data, function(i){
                        $('#show_detail_pengambilan').append(`
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
                    alert_gagal('An error occurred during your request: ' +  request.status + ' ' + request.statusText);
                }
            });
        });

        $('.item_detail_pemindahan').on('click',function()
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
                    $('#modal_detail_pemindahan').modal('show');
                    $('#kode_pindah_detail').html(': ' + data[0].kode_pindah);
                    $('#tgl_pindah_detail').html(': ' + date.toLocaleDateString('id-ID', data[0].tgl_pindah)); 
                    $('#ruang_detail').html(': ' + data[0].ruang);
                    $('#show_detail_pemindahan').html('');
                    $('#link_cetak_pemindahan').html(`<a href="`+ site_url+ '/backend/cetak-pemindahan-pdf/'+ data[0].kode_pindah +`" target="_blank" class="btn btn-danger btn-sm"><i class="fa fa-print"></i> CETAK PDF</a> <a href="`+ site_url+ '/backend/cetak-pemindahan/'+ data[0].kode_pindah +`" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> CETAK</a>`);

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

                        $('#show_detail_pemindahan').append(`
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
                    alert_gagal('An error occurred during your request: ' +  request.status + ' ' + request.statusText);
                }
            });
        });
    });

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