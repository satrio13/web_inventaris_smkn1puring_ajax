<html>
    <head>
        <title>Laporan Pemindahan Barang Inventaris - Aplikasi Manajemen Barang SMK N 1 Puring</title>
        <style type="text/css">
            * { font-size: 11pt; font-family: arial; }
        </style>
    </head>
    <body>
        <table width="100%" cellspacing="0" cellpadding="2"> 
            <tr>
                <td width="10%"><img src="assets/img/logo_smkn1puring.png" width="70"></td>
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
        <br><center><b>LAPORAN PEMINDAHAN</b></center><br>
        <table width="100%" cellspacing="0" cellpadding="2">
            <tr>
                <td width="10%">
                    Periode Awal
                </td>
                <td>
                    : <?= tgl_indo($tgl_awal); ?>
                </td>
                <td width="10%">
                    Periode Akhir
                </td>
                <td>
                    : <?= tgl_indo($tgl_akhir); ?>
                </td>
            </tr>
        </table>
        <table cellspacing="0" cellpadding="3" width="100%" border="1">
            <thead style="background-color: #ccc" align="center">
                <tr>
                    <th width="5%" nowrap>NO</th>
                    <th nowrap>KODE PEMINDAHAN</th>
                    <th nowrap>TGL PINDAH</th>
                    <th nowrap>KE RUANG</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            if($data->num_rows() > 0)
            {
                $no = 1;
                foreach($data->result() as $r):
                echo'<tr>
                        <td align="center">'.$no++.'</td>
                        <td>'.$r->kode_pindah.'</td>
                        <td>'.date('d-m-Y', strtotime($r->tgl_pindah)).'</td>
                        <td>'.$r->ruang.'</td>
                    </tr>';
                endforeach;
            }else
            {
                echo'<tr>
                        <td colspan="4" align="center">DATA KOSONG</td>
                    </tr>';
            }
            ?>
            </tbody>
        </table>
        <br>
        <table cellspacing="0" cellpadding="3" width="100%">
            <tr>
                <td width="40%"><br>Kepala SMK N 1 Puring</td>
                <td width="30%"></td>
                <td width="30%">Puring, <?php echo tgl_indo(date('Y-m-d')); ?><br>Pengurus Barang</td>
            </tr>
            <tr>
                <td width="40%"><?php echo'<br><br><br><b><u>'.nama_ks().'</u></b><br>NIP. '.nip_ks(); ?></td>
                <td width="30%"></td>
                <td width="30%">
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