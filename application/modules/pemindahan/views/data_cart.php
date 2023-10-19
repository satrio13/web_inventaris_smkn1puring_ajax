<?php
if($q->num_rows() > 0)
{
    $row = $q->row_array();
    foreach($q->result() as $r)
    {
        $hasil[] = [
            'id_baranginv' => $r->id_baranginv,
            'kode_inv' => $r->kode_inv,
            'barang' => $r->barang,
            'id_kondisi' => $r->id_kondisi,
            'kode_pindah' => $r->kode_pindah,
            'tgl_pindah' => $r->tgl_pindah
        ];
    }

    $hasil;	
}else
{			
    $hasil = $q->result();
}

if( ($row['tgl_pindah'] != '0000-00-00') AND (empty($row['kode_pindah'])) )
{
    $tgl_pindah = '';
}else
{
    $tgl_pindah = $row['tgl_pindah'];
}

if($hasil)
{
    $no = 1;
    foreach($hasil as $r):
        $cek_kondisi = $this->pemindahan_model->cek_kondisi_pindah($r['id_baranginv'], $r['kode_pindah']);
        if($cek_kondisi)
        {
            $id_kondisi = $cek_kondisi['id_kondisi'];
        }else
        {
            $id_kondisi = $r['id_kondisi'];
        }

        $cek_ruang = $this->pemindahan_model->cek_ruang_pindah($r['id_baranginv'], $r['kode_pindah']);
        if($cek_ruang)
        {
            $id_ruang = $cek_ruang['id_ruang'];
        }else
        {
            $id_ruang = $r['id_ruang'];
        }

        echo'<tr>
                <td class="text-center">'.$no++.'</td>
                <td><input type="hidden" name="id_baranginv[]" value="'.$r['id_baranginv'].'">'.$r['kode_inv'].'</td>
                <td>'.$r['barang'].'</td>
                <td>
                    <select name="id_kondisi[]" class="form-control">';
                        if($id_kondisi == '1')
                        {
                            echo'<option value="1" selected>Baik</option>
                                <option value="2">Rusak Ringan</option>
                                <option value="3">Rusak Sedang</option>
                                <option value="4">Rusak Berat</option>
                                <option value="5">Hilang</option>
                                <option value="6">Dihapus</option>';
                        }elseif($id_kondisi == '2')
                        {
                            echo'<option value="1">Baik</option>
                                <option value="2" selected>Rusak Ringan</option>
                                <option value="3">Rusak Sedang</option>
                                <option value="4">Rusak Berat</option>
                                <option value="5">Hilang</option>
                                <option value="6">Dihapus</option>';
                        }elseif($id_kondisi == '3')
                        {
                            echo'<option value="1">Baik</option>
                                <option value="2">Rusak Ringan</option>
                                <option value="3" selected>Rusak Sedang</option>
                                <option value="4">Rusak Berat</option>
                                <option value="5">Hilang</option>
                                <option value="6">Dihapus</option>';
                        }elseif($id_kondisi == '4')
                        {
                            echo'<option value="1">Baik</option>
                                <option value="2">Rusak Ringan</option>
                                <option value="3">Rusak Sedang</option>
                                <option value="4" selected>Rusak Berat</option>
                                <option value="5">Hilang</option>
                                <option value="6">Dihapus</option>';
                        }elseif($id_kondisi == '5')
                        {
                            echo'<option value="1">Baik</option>
                                <option value="2">Rusak Ringan</option>
                                <option value="3">Rusak Sedang</option>
                                <option value="4">Rusak Berat</option>
                                <option value="5" selected>Hilang</option>
                                <option value="6">Dihapus</option>';
                        }elseif($id_kondisi == '6')
                        {
                            echo'<option value="1">Baik</option>
                                <option value="2">Rusak Ringan</option>
                                <option value="3">Rusak Sedang</option>
                                <option value="4">Rusak Berat</option>
                                <option value="5">Hilang</option>
                                <option value="6" selected>Dihapus</option>';
                        }else
                        {
                            echo'';
                        }
                    echo'</select>
                </td>
                <td class="text-center">
                    <a href="javascript:void(0)" class="btn btn-danger btn-xs" onclick="delete_cart_pindah('.$r['id_baranginv'].')""><i class="fa fa-trash"></i></a>
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
        <td colspan="2"><div class="mt-2">Kode Pindah</div></td>
        <td colspan="3"><input type="text" name="kode_pindah" id="kode_pindah" value="'.$row['kode_pindah'].'" class="form-control" readonly=""></td>
    </tr>
    <tr class="bg-white">
        <td colspan="2"><div class="mt-2">Ke Ruang <span class="text-danger">*</span></div></td>
        <td colspan="3">
            <select name="id_ruang" id="id_ruang" class="form-control" required>';
                $ruang = $this->db->select('id_ruang,ruang')->from('tb_ruang')->order_by('ruang','asc')->get()->result_array();
                foreach($ruang as $g):
                    if($row['id_ruang'] == $g['id_ruang'])
                    {
                        echo'<option value="'.$g['id_ruang'].'" selected>'.$g['ruang'].'</option>';
                    }else
                    {
                        echo'<option value="'.$g['id_ruang'].'">'.$g['ruang'].'</option>';
                    }
                endforeach;
            echo'</select>
            <span class="help-block text-danger"></span>
        </td>
    </tr>
    <tr class="bg-white">
        <td colspan="2"><div class="mt-2">Tgl Pemindahan <span class="text-danger">*</span></div></td>
        <td colspan="3"><input type="date" name="tgl_pindah" id="tgl_pindah" value="'.$tgl_pindah.'" class="form-control" placeholder="Tgl Pemindahan" required><span class="help-block text-danger"></span></td>
    </tr>
        <td colspan="2">';
            if(!empty($row['kode_pindah']))
            {
                echo'<button type="button" id="btnEdit" class="btn bg-orange btn-sm"><span class="text-white"><i class="fa fa-check"></i> EDIT</span></button>';
            }else
            {
                echo'<button type="button" id="btnSave" class="btn bg-info btn-sm"><i class="fa fa-check"></i> SIMPAN</button>';
            }
        echo'</td>
        <td colspan="3" class="text-right">
            <button type="button" class="btn btn-danger btn-sm" id="btn_batal_pemindahan"><i class="fa fa-times"></i> BATAL</button>
        </td>
    </tr>';