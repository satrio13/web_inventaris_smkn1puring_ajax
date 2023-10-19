<?php
if($data->num_rows() > 0)
{
    $cek = $data->row();
    if(!empty($cek->kode_trans))
    {
        $get = $this->db->select('*')->from('tb_detailkeluarhp')->where('kode_trans',$cek->kode_trans)->get()->row();
    }

    if(empty($get->nama_pengambil))
    {
        $nama_pengambil = '';
    }else
    {
        $nama_pengambil = $get->nama_pengambil;
    }

    if(empty($get->kode_trans))
    {
        $kode_trans = '';
    }else
    {
        $kode_trans = $get->kode_trans;
    }

    if(empty($get->tgl_keluar))
    {
        $tgl_keluar = '';
    }else
    {
        $tgl_keluar = $get->tgl_keluar;
    }

    if(empty($get->jam_keluar))
    {
        $jam_keluar = '';
    }else
    {
        $jam_keluar = $get->jam_keluar;
    }

    foreach($data->result() as $r)
    {   
        $hasil[] = [
            'id_baranghp' => $r->id_baranghp,
            'kode_hp' => $r->kode_hp,
            'barang' => $r->barang,
            'stok' => $r->stok,
            'qty' => $r->qty,
            'nama_pengambil' => $nama_pengambil,
            'kode_trans' => $kode_trans,
            'tgl_keluar' => $tgl_keluar,
            'jam_keluar' => $jam_keluar
        ];
    }
    
    $hasil;	
}else
{
    $hasil = $data->result();
}

if($hasil)
{
    $no = 1;
    foreach($hasil as $r):
        echo'<tr>
                <td class="text-center">'.$no++.'</td>
                <td><input type="hidden" name="id_baranghp[]" value="'.$r['id_baranghp'].'">'.$r['kode_hp'].'</td>
                <td>'.$r['barang'].'</td>
                <td>
                    <select name="qty[]" class="form-control">';
                        for($i=1; $i <= $r['stok']; $i++)
                        { 
                            if($i == $r['qty'])
                            {
                                echo'<option value="'.$i.'" selected>'.$i.'</option>';
                            }else
                            {
                                echo'<option value="'.$i.'">'.$i.'</option>';
                            }
                        }
                    echo'</select>
                </td>
                <td class="text-center">
                    <a href="javascript:void(0)" class="btn btn-danger btn-xs" onclick="delete_cart('.$r['id_baranghp'].')""><i class="fa fa-trash"></i></a>
                </td>
            </tr>';
    endforeach; 
}else
{
    echo'<tr>
            <td colspan="5" class="text-center">Keranjang Kosong</td> 
        </tr>';
}

echo'<tr class="bg-white">
        <td colspan="2"><div class="mt-2">Kode Ambil</div></td>
        <td colspan="3"><input type="text" name="kode_trans" value="'.$r['kode_trans'].'" id="kode_trans" class="form-control" readonly=""></td>
    </tr>
    <tr class="bg-white">
        <td colspan="2"><div class="mt-2">Nama Pengambil <span class="text-danger">*</span></div></td>
        <td colspan="3"><input type="text" name="nama_pengambil" value="'.$r['nama_pengambil'].'" id="nama_pengambil" class="form-control" placeholder="Nama Pengambil" required><span class="help-block text-danger"></span></td>
    </tr>
    <tr class="bg-white">
        <td colspan="2"><div class="mt-2">Tgl Pengambilan <span class="text-danger">*</span></div></td>
        <td colspan="3"><input type="date" name="tgl_keluar" value="'.$r['tgl_keluar'].'" id="tgl_keluar" class="form-control" placeholder="Tgl Keluar" required><span class="help-block text-danger"></span></td>
    </tr>
    <tr class="bg-white">
        <td colspan="2"><div class="mt-2">Jam Pengambilan <span class="text-danger">*</span></div></td>
        <td colspan="3"><input type="time" name="jam_keluar" value="'.$r['jam_keluar'].'" id="jam_keluar" class="form-control" placeholder="Jam Keluar" required><span class="help-block text-danger"></span></td>
    </tr>
    <tr class="bg-white">
        <td colspan="2">';
            if(!empty($r['kode_trans']))
            {
                echo'<button type="button" id="btnEdit" class="btn bg-orange btn-sm"><span class="text-white"><i class="fa fa-check"></i> EDIT</span></button>';
            }else
            {
                echo'<button type="button" id="btnSave" class="btn bg-info btn-sm"><i class="fa fa-check"></i> SIMPAN</button>'; 
            }
        echo'</td>
        <td colspan="3" class="text-right">
            <button type="button" class="btn btn-danger btn-sm" id="btn_batal"><i class="fa fa-times"></i> BATAL</button>
        </td>
    </tr>';