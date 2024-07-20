<?php

class MAdmin extends CI_Model
{
    public function cek_login($uname, $pass)
    {
        $adminData = $this->get_admin_by_username($uname);
        if (!$adminData || !password_verify($pass, $adminData->password))
            return null;

        $sessionData = [
            'userName' => $adminData->userName,
            'password' => $adminData->password,
        ];

        return $sessionData;
    }

    public function get_produk()
    {
        $this->db->select("
        tbl_produk.idKat,
        tbl_produk.idProduk,
        tbl_produk.idToko,
        tbl_produk.namaProduk,
        tbl_produk.berat AS beratProduk,
        tbl_produk.foto AS fotoProduk,
        tbl_produk.harga AS hargaProduk,
        tbl_produk.deskripsiProduk,
        
        tbl_toko.idKonsumen AS idSeller,
        tbl_toko.namaToko,
        tbl_toko.logo as logoToko,
        tbl_toko.deskripsi AS deskripsiToko,
        tbl_toko.statusAktif AS statusToko,
        
        tbl_member.idKonsumen AS idSeller,
        tbl_member.username as usernameSeller,
        tbl_member.namaKonsumen AS namaSeller,
        tbl_member.alamat AS alamatToko,
        tbl_member.idKota AS idKotaToko,
        ");
        $this->db->from("tbl_produk");
        $this->db->join("tbl_toko", "tbl_toko.idToko = tbl_produk.idToko");
        $this->db->join("tbl_member", "tbl_member.idKonsumen = tbl_toko.idKonsumen");
        $query = $this->db->get();
        return $query;
    }

    public function get_kota_penjual($idToko)
    {
        $this->db->select("*");
        $this->db->from("tbl_toko");
        $this->db->join("tbl_member", "tbl_member.idKonsumen = tbl_toko.idKonsumen");
        $this->db->where("tbl_toko.idToko", $idToko);
        $query = $this->db->get();
        return $query;
    }

    public function get_admin_by_username($username)
    {
        return $this->db->get_where('tbl_admin', [
            'userName' => $username
        ])->row_object();
    }

    public function get_all_data($tabel)
    {
        $q = $this->db->get($tabel);
        return $q;
    }

    public function get_produk_filter($filter = null)
    {
        if ($filter) {
            foreach ($filter as $fieldKey => $fieldValue) {
                if ($fieldKey == 'tbl_produk.namaProduk') {
                    $this->db->like($fieldKey, $fieldValue);
                } else if (is_array($fieldValue)) {
                    $this->db->where_in($fieldKey, $fieldValue);
                } else {
                    $this->db->where($fieldKey, $fieldValue);
                }
            }
        }

        $q = $this->get_produk();
        return $q;
    }

    public function get_all_by($table, $whereKey, $whereVal)
    {
        $this->db->where($whereKey, $whereVal);
        return $this->db->get($table);
    }

    public function insert($tabel, $data)
    {
        $this->db->insert($tabel, $data);
        return $this->db->affected_rows();
    }

    public function get_by_id($tabel, $id)
    {
        return $this->db->get_where($tabel, $id);
    }

    public function update($tabel, $data, $pk, $id)
    {
        $this->db->where($pk, $id);
        $this->db->update($tabel, $data);
        return $this->db->affected_rows();
    }

    public function delete($tabel, $id, $val)
    {
        $this->db->delete($tabel, array($id => $val));
    }
}
