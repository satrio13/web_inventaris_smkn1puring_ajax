<html>
    <head>
        <title>Laporan Daftar Barang Inventaris Ruang - Aplikasi Manajemen Barang SMK N 1 Puring</title>
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
        <br><center><b>DAFTAR INVENTARIS RUANG</b></center>
        <br>
        <table width="100%" cellspacing="0" cellpadding="2">
            <tr>
                <td width="12%">
                    NOMOR RUANG
                </td>
                <td>
                    : <?= $ruang->nomor; ?>
                </td>
                <td width="6%">
                    RUANG
                </td>
                <td>
                    : <?= $ruang->ruang; ?>
                </td>
            </tr>
        </table>
        <table cellspacing="0" cellpadding="3" width="100%" border="1">
            <thead style="background-color: #ccc" align="center">
                <tr>
                    <th width="5%" nowrap>NO</th>
                    <th nowrap>KODE BARANG</th>
                    <th nowrap>NAMA BARANG</th>
                    <th nowrap>MERK</th>
                    <th nowrap>TAHUN BELI</th>
                    <th nowrap>KONDISI</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            if($data->num_rows() > 0)
            {
                $no = 1;
                foreach($data->result() as $r):
                    if($r->id_kondisi == 1)
                    {
                        $kondisi = 'Baik';
                    }elseif($r->id_kondisi == 2)
                    {
                        $kondisi = 'Rusak Ringan';
                    }elseif($r->id_kondisi == 3)
                    {
                        $kondisi = 'Rusak Sedang';
                    }elseif($r->id_kondisi == 4)
                    {
                        $kondisi = 'Rusak Berat';
                    }elseif($r->id_kondisi == 5)
                    {
                        $kondisi = 'Hilang';
                    }elseif($r->id_kondisi == 6)
                    {
                        $kondisi = 'Dihapus';
                    }else
                    {
                        $kondisi = '';
                    }

                    echo'<tr>
                            <td align="center">'.$no++.'</td>
                            <td>'.$r->kode_inv.'</td>
                            <td>'.$r->barang.'</td>
                            <td>'.$r->merk.'</td>
                            <td>'.$r->th_beli.'</td>
                            <td>'.$kondisi.'</td>
                        </tr>';
                endforeach;
            }else
            {
                echo'<tr>
                        <td colspan="6" align="center">DATA KOSONG</td>
                    </tr>';
            }
            ?>
            </tbody>
        </table>
        <br>
        <table cellspacing="0" cellpadding="3" width="100%">
            <tr>
                <td width="50%"><br>Kepala SMK N 1 Puring</td>
                <td width="20%"></td>
                <td width="30%">Puring, <?php echo tgl_indo(date('Y-m-d')); ?><br>Pengurus Barang</td>
            </tr>
            <tr>
                <td width="50%"><?php echo'<br><br><br><b><u>'.nama_ks().'</u></b><br>NIP. '.nip_ks(); ?></td>
                <td width="20%"></td>
                <td width="30%"><?php
                                echo'<br><br><br><b><u>'.$ruang->nama_pj.'</u></b>';
                                if( !empty($ruang->nip_pj) )
                                {
                                    echo '<br>NIP. '.$ruang->nip_pj;
                                }  
                                ?>
                </td>
            </tr>
        </table>
    </body>
</html>