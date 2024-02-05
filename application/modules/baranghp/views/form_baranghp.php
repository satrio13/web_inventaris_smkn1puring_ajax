<div class="container">
  <div class="content-wrapper bg-white">
      <div class="content-header">
          <div class="row mb-2">
              <div class="col-sm-12">
                  <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
                      <li class="breadcrumb-item"><a href="<?= base_url('backend/baranghp'); ?>">Barang Habis Pakai</a></li>
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
                  <div class="card card-info border border-secondary">
                    <div class="card-header">
                      <a href="<?= base_url('excel/baranghp/format-import-data-barang-habis-pakai.xlsx'); ?>" class="btn bg-maroon btn-sm" target="_blank"><i class="fa fa-download"></i> Download Format</a>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                  <?php echo form_open_multipart('backend/form-baranghp'); ?>
                      <div class="card-body">
                        <div class="callout callout-danger">
                          <h5>CARA MELAKUKAN IMPORT DATA BARANG HABIS PAKAI :</h5>
                          <b>1.</b> Klik tombol <b>Download Format</b> untuk mengunduh file template excel yg dibutuhkan <b>( format-import-data-barang-habis-pakai.xlsx )</b>.<br>
                          <b>2.</b> Setelah file  <b>( format-import-data-barang-habis-pakai.xlsx )</b> berhasil diunduh, kemudian buka file tersebut dan mulailah untuk mengisi datanya mulai dari <b>baris/row 2</b> !! <br>
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
                        <a href="<?= base_url('backend/baranghp'); ?>" class="btn btn-danger float-right btn-sm"><i class="fa fa-arrow-left"></i> BATAL</a>
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
          echo form_open('backend/import-baranghp');
          echo'<div class="col-md-12 col-xs-12 mt-3">
                <div class="alert alert-danger text-white" role="alert">
                  KOLOM YANG DIBERI WARNA MERAH HARAP DIISI !
                </div>
              </div>'; 
          ?>
          <div class="card-body">
            <div class="table table-responsive">
              <table class="table table-bordered table-striped table-sm">
                <thead class="text-center bg-dark">
                  <tr>
                    <th nowrap width="5%">NO</th>
                    <th nowrap>KODE BARANG</th>
                    <th nowrap>NAMA BARANG</th>
                    <th nowrap>KATEGORI</th>
                    <th nowrap>SATUAN</th>
                    <th nowrap>HARGA</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $numrow = 1;
                  $kosong = 0;
                  $no = 1;
                  $cek_id = 0;

                  // Array baru untuk menyimpan data unik berdasarkan 'kode_hp'
                  $uniqueData = [];
                  // Loop melalui data yang diberikan
                  foreach($sheet as $item)
                  {
                    // Gunakan 'kode_hp' sebagai kunci array
                    $kode_hp = $item['A'];
                    // Jika 'kode_hp' belum ada dalam array $uniqueData, tambahkan data tersebut
                    if(!isset($uniqueData[$kode_hp]))
                    {
                      $uniqueData[$kode_hp] = $item;
                    }
                  }

                  // Ubah kembali array asosiatif menjadi indeks numerik
                  $uniqueData = array_values($uniqueData);
                  foreach($uniqueData as $row)
                  {
                    $kode_hp = $row['A'];
                    $barang = $row['B'];
                    $id_kategori = $row['C'];
                    $satuan = $row['D'];
                    $harga = $row['E'];

                    if($kode_hp == "" && $barang == "" && $id_kategori == "" && $satuan == "" && $harga == "")
                      continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)
                    if($numrow > 1)
                    {
                        // Validasi apakah semua data telah diisi
                        $kode_hp_td = ( ! empty($kode_hp))? "" : " style='background: crimson;'";
                        $barang_td = ( ! empty($barang))? "" : " style='background: crimson;'";
                        $id_kategori_td = ( ! empty($id_kategori))? "" : " style='background: crimson;'";
                        $satuan_td = ( ! empty($satuan))? "" : " style='background: crimson;'";
                        $harga_td = ( ! empty($harga))? "" : " style='background: crimson;'";

                        $cek_kode_hp = $this->baranghp_model->cek_kode_hp($kode_hp);
                        if($cek_kode_hp)
                        {
                          $msg_kode_hp = '<br><div class="badge badge-danger">KODE SUDAH DIGUNAKAN</div>';
                        }else
                        {
                          $msg_kode_hp = '';
                        }

                        $cek_id_kategori = $this->baranghp_model->cek_id_kategori($id_kategori);
                        if(!$cek_id_kategori)
                        {
                          $msg_id_kategori = '<br><div class="badge badge-danger">ID KATEGORI TIDAK VALID</div>';
                          $kategori = '';
                        }else
                        {
                          $msg_id_kategori = '';
                          $kategori = '<span class="badge badge-success">'.kategori($id_kategori).'</span>';
                        }

                        if($kode_hp == "" OR $barang == "" OR $id_kategori == "" OR $satuan == "" OR $harga == "")
                        {
                          $kosong++; // Tambah 1 variabel $kosong
                        }

                        if(!$cek_id_kategori OR $cek_kode_hp)
                        {
                          $cek_id++; 
                        }

                          echo "<tr>";
                              echo "<td class='text-center' nowrap>".$no++."</td>";
                              if(!empty($kode_hp))
                              {
                                  echo "<td nowrap>".$kode_hp.$msg_kode_hp."</td>";
                              }else
                              {
                                  echo "<td".$kode_hp." nowrap>".$kode_hp."</td>";
                              } 
                              echo "<td".$barang_td." nowrap>".$barang."</td>";
                              if(!empty($id_kategori))
                              {
                                  echo "<td class='text-center' nowrap>".$id_kategori.$msg_id_kategori.'<br>'.$kategori."</td>";
                              }else
                              {
                                  echo "<td".$id_kategori_td." nowrap>".$id_kategori."</td>";
                              }  
                              echo "<td".$satuan_td." nowrap>".$satuan."</td>";
                              echo "<td".$harga_td." nowrap>".$harga."</td>";
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
