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
        <br><center><b>REKAP INVENTARIS RUANG</b></center>
        <br>
        <table width="100%" cellspacing="0" cellpadding="2">
            <tr>
                <td width="17%">
                    NOMOR RUANG
                </td>
                <td>
                    : <?= $ruang->nomor; ?>
                </td>
                <td width="8%">
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
                    <th nowrap>KATEGORI BARANG</th>
                    <th nowrap>JUMLAH</th>
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
                        <td>'.$r->kategori.'</td>
                        <td>'.$r->jml.' '.$r->satuan.'</td>
                    </tr>';
                endforeach;
            }else
            {
                echo'<tr>
                        <td colspan="3" align="center">DATA KOSONG</td>
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
<script>
    window.print();
</script>