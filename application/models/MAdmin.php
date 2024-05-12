<?php

class MAdmin extends CI_Model {

    public function cek_login($uname, $pass) {
        $result = $this->db->get_where('tbl_admin', [
            'userName' => $uname,
            'password' => $pass
        ]);

        return $result;
    }
}   