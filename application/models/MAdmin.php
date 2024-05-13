<?php

class MAdmin extends CI_Model
{
    public function cek_login($uname, $pass)
    {
        $result = $this->db->get_where('tbl_admin', [
            'userName' => $uname,
            'password' => $pass
        ]);

        return $result;
    }

    public function get_all_data($tabel)
    {
        $q = $this->db->get($tabel);
        return $q;
    }

    public function insert($tabel, $data)
    {
        $this->db->insert($tabel, $data);
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
