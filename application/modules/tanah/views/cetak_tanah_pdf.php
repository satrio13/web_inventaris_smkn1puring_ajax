<html>
    <head>
        <title>Tanah - Aplikasi Manajemen Barang SMK N 1 Puring</title>
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
        <br><center><b>DATA TANAH</b></center>
        <br>
        <table cellspacing="0" cellpadding="3" width="100%" border="1">
            <thead style="background-color: #ccc" align="center">
                <tr>
                    <th width="5%" nowrap>NO</th>
                    <th nowrap>TANAH</th>
                    <th nowrap>LUAS</th>
                    <th nowrap>SELATAN</th>
                    <th nowrap>TIMUR</th>
                    <th nowrap>BARAT</th>
                    <th nowrap>UTARA</th>
                    <th nowrap>TAHUN</th>
                    <th nowrap>SUMBERDANA</th>
                </tr>
            </thead>
            <tbody>
            <?php $no = 1; foreach($data as $r): ?>
                <tr>
                    <td align="center"><?= $no++; ?></td>
                    <td><?= $r->tanah; ?></td>
                    <td><?= $r->luas; ?></td>
                    <td><?= $r->selatan; ?></td>
                    <td><?= $r->timur; ?></td>
                    <td><?= $r->barat; ?></td>
                    <td><?= $r->utara; ?></td>
                    <td><?= $r->tahun_p; ?></td>
                    <td><?= $r->sumberdana; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </body>
</html>