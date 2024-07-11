<?php

include_once("application/models/MUser.php");

class MCart extends CI_Model
{
    public static $table = "tbl_cart";

    public function items()
    {
        $memberId = $this->session->userdata("idKonsumen");
        $cartT = MCart::$table;
        $produkT = "tbl_produk";

        $this->db->select("$cartT.id",);
        $this->db->select("$cartT.idProduk",);
        $this->db->select("$cartT.qty");

        $this->db->select("$produkT.idKat");
        $this->db->select("$produkT.idToko");
        $this->db->select("$produkT.namaProduk");
        $this->db->select("$produkT.foto");
        $this->db->select("$produkT.harga");

        $this->db->from($cartT);
        $this->db->join($produkT, "$produkT.idProduk = $cartT.idProduk", "right");
        $this->db->where("$cartT.idKonsumen", $memberId);

        $query = $this->db->get();
        return $query->result();
    }

    public function insert_by_product($produk, $qty)
    {
        $cardData = [
            'idProduk' => intval($produk->idProduk),
            'idKonsumen' => intval($this->session->userdata("idKonsumen")),
            'qty' => (intval($qty) > 0) ? intval($qty) : 1,
            // 'price' => intval($produk->harga),
            // 'name' => $produk->namaProduk,
            // 'image' => $produk->foto,
        ];

        return $this->insert($cardData);
    }

    public function insert($data)
    {
        $this->db->insert(MCart::$table, $data);
        return $this->db->affected_rows();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where(MCart::$table, $id);
    }

    public function update($data, $pk, $id)
    {
        $this->db->where($pk, $id);
        $this->db->update(MCart::$table, $data);
        return $this->db->affected_rows();
    }

    public function delete($id, $val)
    {
        $this->db->delete(MCart::$table, [$id => $val]);
    }
}
