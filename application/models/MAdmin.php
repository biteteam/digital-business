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
        $this->db->select("*");
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
