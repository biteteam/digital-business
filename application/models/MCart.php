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
        $kategoriT = "tbl_kategori";
        $tokoT = "tbl_toko";
        $sellerT = "tbl_member";

        // Cart
        $this->db->select("$cartT.id AS idCart");
        $this->db->select("$cartT.idProduk as idProduk",);
        $this->db->select("$cartT.qty AS qty");
        // Produk
        $this->db->select("$produkT.idKat AS idKategori");
        $this->db->select("$produkT.idToko");
        $this->db->select("$produkT.namaProduk");
        $this->db->select("$produkT.foto AS fotoProduk");
        $this->db->select("$produkT.harga as hargaProduk");
        $this->db->select("$produkT.berat as beratProduk");
        $this->db->select("$produkT.stok as stokProduk");
        // Kategori
        $this->db->select("$kategoriT.namaKat AS namaKategori");
        // Toko
        $this->db->select("$tokoT.idToko AS idToko");
        $this->db->select("$tokoT.idKonsumen AS idSeller");
        $this->db->select("$tokoT.namaToko AS namaToko");
        $this->db->select("$tokoT.logo AS logoToko");
        $this->db->select("$tokoT.deskripsi AS deskripsiToko");
        // Seller
        $this->db->select("$sellerT.username AS usernameSeller");
        $this->db->select("$sellerT.namaKonsumen AS namaSeller");
        $this->db->select("$sellerT.idKota AS idKotaSeller");
        $this->db->select("$sellerT.alamat AS alamatSeller");
        $this->db->select("$sellerT.email AS emailSeller");
        $this->db->select("$sellerT.tlpn AS tlpnSeller");

        $this->db->from($cartT);
        $this->db->join($produkT, "$produkT.idProduk = $cartT.idProduk", "right");
        $this->db->join($tokoT, "$tokoT.idToko = $produkT.idToko", "left");
        $this->db->join($sellerT, "$sellerT.idKonsumen = $tokoT.idKonsumen", "left");
        $this->db->join($kategoriT, "$kategoriT.idKat = $produkT.idKat", "left");

        $this->db->where("$cartT.idKonsumen", $memberId);
        $this->db->order_by("$tokoT.idToko", "ASC");

        $query = $this->db->get();
        return $query->result();
    }

    public function itemsById()
    {
    }

    public function cartCount()
    {
        if (!$this->session->userdata("idKonsumen")) return 0;
        $this->db->where('idKonsumen', $this->session->userdata("idKonsumen"));
        $query = $this->db->get(MCart::$table);
        $count = $query->num_rows();

        return $count;
    }

    public function updateQtyProductOnExist($idProduk, $idKonsumen)
    {
        $this->db->where('idProduk', $idProduk);
        $this->db->where('idKonsumen', $idKonsumen);
        $cart = $this->db->get(MCart::$table)->row_object();
        if (!$cart) return false;

        $this->db->update(MCart::$table, [
            "qty" => intval($cart->qty) + 1
        ]);
        return $this->db->affected_rows();
    }

    public function updateQty($cartId, $action)
    {

        $this->db->where('id', $cartId);
        $cart = $this->db->get(MCart::$table)->row_object();
        if (!$cart) return false;

        $qty =  intval($cart->qty);

        if ($action == 'increase') {
            $qty = $qty + 1;
        } elseif ($action == "decrase" && $qty > 0) {
            $qty = $qty - 1;
        } else {
            return false;
        }

        $this->db->where('id', $cartId);
        $this->db->update(MCart::$table, [
            "qty" => intval($qty)
        ]);
        return $this->db->affected_rows();
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

    public function delete_by_id($id)
    {
        $this->db->delete(MCart::$table, ["id" => $id]);
        return $this->db->affected_rows();
    }

    public function delete($id, $val)
    {
        $this->db->delete(MCart::$table, [$id => $val]);
    }
}
