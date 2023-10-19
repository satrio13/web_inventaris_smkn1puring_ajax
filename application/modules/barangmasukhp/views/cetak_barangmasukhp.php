<html>
    <head>
        <title>Barang Masuk Habis - Aplikasi Manajemen Barang SMK N 1 Puring</title>
        <style type="text/css">
            * { font-size: 11pt; font-family: arial; }
        </style>
    </head>
    <body>
        <table width="100%" cellspacing="0" cellpadding="2"> 
            <tr>
                <td width="10%"><img src="<?= base_url('assets/img/logo_smkn1puring.png'); ?>" width="70"></td>
                <td align="center" width="80%">DINAS PENDIDIKAN KABUPATEN KEBUMEN<br>
                                                        <b>SEKOLAH MENENGAH KEJURUAN NEGERI 1 PURING</b><br>
                                                        Jl. Selatan-Selatan Kilometer 04 Puring - Kebumen, Kode Pos 54383<br>
                                                        Email : smknegeri1puring@gmail.com - Telp : 0811-2635-864
                </td>
                <td width="10%"></td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td>
                    <div style="border-bottom:3px solid black;"></div>
                </td>
            </tr>
        </table>
        <br><center><b>DATA BARANG MASUK HABIS PAKAI</b></center>
        <br>
        <table cellspacing="0" cellpadding="3" width="100%" border="1">
            <thead style="background-color: #ccc" align="center">
                <tr>
                    <th width="5%" nowrap>NO</th>
                    <th nowrap>KODE BARANG</th>
                    <th nowrap>NAMA BARANG</th>
                    <th nowrap>KATEGORI</th>
                    <th nowrap>TGL MASUK</th>
                    <th nowrap>JML MASUK</th>
                    <th nowrap>SATUAN</th>
                </tr>
            </thead>
            <tbody>
            <?php $no = 1; foreach($data as $r): ?>
                <tr>
                    <td align="center"><?= $no++; ?></td>
                    <td><?= $r->kode_hp; ?></td>
                    <td><?= $r->barang; ?></td>
                    <td><?= $r->kategori; ?></td>
                    <td><?= date('d-m-Y', strtotime($r->tgl_masuk)); ?></td>
                    <td align="right"><?= $r->jml_masuk; ?></td>
                    <td><?= $r->satuan; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <br>
        <table cellspacing="0" cellpadding="3" width="100%">
            <tr>
                <td width="70%"></td>
                <td>Puring, <?php echo tgl_indo(date('Y-m-d')); ?><br>Pengurus Barang</td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <?php
                    echo'<br><br><br><b><u>'.nama_pengurus_barang().'</u></b>';
                    if(!empty(nip_pengurus_barang()))
                    {
                        echo'<br>NIP. '.nip_pengurus_barang();
                    } 
                    ?>
                </td>
            </tr>
        </table>
    </body>
</html>
<script>
    window.print(); 
</script>