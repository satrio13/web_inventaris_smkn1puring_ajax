<div class="container">
  <div class="content-wrapper bg-white">
      <div class="content-header">
          <div class="row mb-2">
              <div class="col-sm-12">
                  <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
                      <li class="breadcrumb-item"><a href="<?= base_url('backend/baranginv'); ?>">Barang Inventaris</a></li>
                      <li class="breadcrumb-item active"><?= $title; ?></li>
                  </ol>
              </div>
          </div>
          <div class="row mb-2">
              <div class="col-sm-12">
                  <h1 class="text-dark"><?= $title; ?></h1>
              </div>
          </div>
      </div>

    <section class="content bg-white">
      <div class="row">
        <div class="col-md-12">
          <!-- Horizontal Form -->
                <div class="alert alert-primary alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-info"></i> PEMBERITAHUAN !</h5>
                  LAKUKAN DOWNLOAD FORMAT EXCEL TERLEBIH DAHULU KARENA SUDAH DIUPDATE TERBARU (18 Des 2022) !! 
                </div>
                <div class="card card-info border border-secondary">
                  <div class="card-header">
                    <a href="<?= base_url('excel/baranginv/format-import-data-barang-inventaris.xlsx'); ?>" class="btn bg-maroon btn-sm" target="_blank"><i class="fa fa-download"></i> Download Format</a>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                <?php echo form_open_multipart('backend/form-baranginv'); ?>
                    <div class="card-body">
                      <div class="callout callout-danger">
                        <h5>CARA MELAKUKAN IMPORT DATA BARANG INVENTARIS :</h5>
                        <b>1.</b> Klik tombol <b>Download Format</b> untuk mengunduh file template excel yg dibutuhkan <b>( format-import-data-barang-inventaris.xlsx )</b>.<br>
                        <b>2.</b> Setelah file  <b>( format-import-data-barang-inventaris.xlsx )</b> berhasil diunduh, kemudian buka file tersebut dan mulailah untuk mengisi datanya mulai dari <b>baris/row 2</b> !! <br>
                        <b>3.</b> Setelah semua data dirasa sudah benar, kemudian simpan <b>( ctrl+s )</b> file tersebut. Langkah selanjutnya adalah melakukan upload file tersebut ke dalam Aplikasi ini. Caranya Klik <b>Choose File / Browse</b> untuk mencari file tersebut kemudian klik <b>Preview</b> untuk divalidasi lebih lanjut oleh sistem.<br>
                        <b>4.</b> Setelah klik Preview dan data telah lolos verifikasi sistem maka <b>Tombol Import</b> akan muncul, dan selanjutnya <b>klik Import</b> untuk melakukan import data ke database.
                      </div>
                      <div class="form-group row">
                        <div class="col-sm-7">
                        <?php
                        if(isset($_POST['preview']))
                        { 
                          if($upload_error)
                          { 
                            echo'<div class="alert alert-danger alert-message">'.$upload_error.'</div>';
                          }
                        } 
                        ?>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-sm-5">
                          <input type="file" name="file" class="form-control" accept=".xlsx" required>
                          <p style="color: red">*) ukuran file max 5 MB</p>
                        </div>
                      </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <button type='submit' name="preview" value="Preview" class='btn btn-info btn-sm'><i class="fa fa-check"></i> Preview</button>
                      <a href="<?= base_url(); ?>backend/baranginv" class="btn btn-danger btn-sm float-right"><i class="fa fa-arrow-left"></i> BATAL</a>
                    </div>
                    <!-- /.card-footer -->
                    <!-- /.card-footer -->
                  <?php echo form_close() ?>
    <?php
    if(isset($_POST['preview']))
    { // Jika user menekan tombol Preview pada form
      if(isset($upload_error))
      { // Jika proses upload gagal
      }else
      {
        echo form_open('backend/import-baranginv');
        echo'<div class="col-md-12 col-xs-12 mt-2">
              <div class="alert alert-danger text-white" role="alert">
                KOLOM YANG DIBERI WARNA MERAH HARAP DIISI !
              </div>
            </div>'; 
        ?>
        <div class="card-body">
          <div class="table table-responsive">
            <table id="example1" class="table table-bordered table-striped table-sm">
              <thead class="text-center bg-dark">
                <tr>
                  <th nowrap width="5%">NO</th>
                  <th nowrap>KODE BARANG</th>
                  <th nowrap>NAMA BARANG</th>
                  <th nowrap>KATEGORI</th>
                  <th nowrap>MERK</th>
                  <th nowrap>SATUAN</th>
                  <th nowrap>TAHUN BELI</th>
                  <th nowrap>KONDISI BARANG</th>
                  <th nowrap>KETERANGAN</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $numrow = 1;
                $kosong = 0;
                $no = 1;
                $cek_id = 0;
                foreach($sheet as $row)
                {
                  $kode_inv = $row['A'];
                  $barang = $row['B'];
                  $id_kategori = $row['C'];
                  $merk = $row['D'];
                  $satuan = $row['E'];
                  $th_beli = $row['F'];
                  $id_kondisi = $row['G'];
                  $keterangan = $row['H'];

                  if($kode_inv == "" && $barang == "" && $id_kategori == "" && $satuan == "" && $id_kondisi == "")
                    continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)
                  if($numrow > 1)
                  {
                      // Validasi apakah semua data telah diisi
                      $kode_inv_td = ( ! empty($kode_inv))? "" : " style='background: crimson;'";
                      $barang_td = ( ! empty($barang))? "" : " style='background: crimson;'";
                      $id_kategori_td = ( ! empty($id_kategori))? "" : " style='background: crimson;'";
                      $satuan_td = ( ! empty($satuan))? "" : " style='background: crimson;'";
                      $id_kondisi_td = ( ! empty($id_kondisi))? "" : " style='background: crimson;'";

                      $cek_kode_inv = $this->baranginv_model->cek_kode_inv($kode_inv);
                      if($cek_kode_inv)
                      {
                        $msg_kode_inv = '<br><div class="badge badge-danger">KODE SUDAH DIGUNAKAN</div>';
                      }else
                      {
                        $msg_kode_inv = '';
                      }

                      $cek_id_kategori = $this->baranginv_model->cek_id_kategori($id_kategori);
                      if(!$cek_id_kategori)
                      {
                        $msg_id_kategori = '<br><div class="badge badge-danger">ID KATEGORI TIDAK VALID</div>';
                        $kategori = '';
                      }else
                      {
                        $msg_id_kategori = '';
                        $kategori = '<span class="badge badge-success">'.kategori($id_kategori).'</span>';
                      }

                      $cek_id_kondisi = $this->baranginv_model->cek_id_kondisi($id_kondisi);
                      if(!$cek_id_kondisi)
                      {
                        $msg_id_kondisi = '<br><div class="badge badge-danger">ID KONDISI TIDAK VALID</div>';
                        $kondisi = '';
                      }else
                      {
                        $msg_id_kondisi = '';

                        if($id_kondisi == 1)
                        {
                          $kondisi = '<span class="badge badge-primary">Baik</span>';
                        }elseif($id_kondisi == 2)
                        {
                          $kondisi = '<span class="badge bg-warning"><span class="text-white">Rusak Ringan</span></span>';
                        }elseif($id_kondisi == 3)
                        {
                          $kondisi = '<span class="badge bg-orange"><span class="text-white">Rusak Sedang</span></span>';
                        }elseif($id_kondisi == 4)
                        {
                          $kondisi = '<span class="badge badge-danger">Rusak Berat</span>';
                        }elseif($id_kondisi == 5)
                        {
                          $kondisi = '<span class="badge bg-maroon">Hilang</span>';
                        
                        }elseif($id_kondisi == 6)
                        {
                          $kondisi = '<span class="badge bg-navy">Dihapus</span>';
                        }else
                        {
                          $kondisi = '';
                        }
                      }

                      if($kode_inv == "" OR $barang == "" OR $id_kategori == "" OR $satuan == "" OR $id_kondisi == "")
                      {
                        $kosong++; // Tambah 1 variabel $kosong
                      }

                      if(!$cek_id_kategori OR $cek_kode_inv OR !$cek_id_kondisi)
                      {
                        $cek_id++; 
                      }

                        echo "<tr>";
                            echo "<td class='text-center' nowrap>".$no++."</td>";
                            if(!empty($kode_inv))
                            {
                                echo "<td nowrap>".$kode_inv.$msg_kode_inv."</td>";
                            }else
                            {
                                echo "<td".$kode_inv." nowrap>".$kode_inv."</td>";
                            } 
                            echo "<td".$barang_td." nowrap>".$barang."</td>";
                            if(!empty($id_kategori))
                            {
                                echo "<td class='text-center' nowrap>".$id_kategori.$msg_id_kategori.'<br>'.$kategori."</td>";
                            }else
                            {
                                echo "<td".$id_kategori_td." nowrap>".$id_kategori."</td>";
                            }  
                            echo "<td nowrap>".$merk."</td>";
                            echo "<td".$satuan_td." nowrap>".$satuan."</td>";
                            echo "<td nowrap>".$th_beli."</td>";
                            if(!empty($id_kondisi))
                            {
                                echo "<td class='text-center' nowrap>".$id_kondisi.$msg_id_kondisi.'<br>'.$kondisi."</td>";
                            }else
                            {
                                echo "<td".$id_kondisi_td." nowrap>".$id_kondisi."</td>";
                            }
                            echo "<td nowrap>".$keterangan."</td>";
                        echo "</tr>";
                  }
                  $numrow++;
              } ?>
            </tbody>
          </table>
        </div>
      </div>
        <?php 
        if($kosong > 0 OR $cek_id > 0)
        { 
          
        }else
        {
          echo'<button type="submit" name="import" value="Import" class="btn btn-primary btn-sm ml-4 mb-2"><i class="fa fa-upload"></i> Import</button>';
        }
        echo form_close(); 
      }
    }?>
    </section>
  </div>     