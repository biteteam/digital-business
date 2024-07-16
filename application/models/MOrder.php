<?php

include_once("application/models/MUser.php");

class MOrder extends CI_Model
{
    public static $table = "tbl_order";
    public static $detailTable = "tbl_order_detail";
    public static $itemsTable = "tbl_order_items";

    public function summary($userId)
    {
        $orderT = MOrder::$table;
        $detailT = MOrder::$detailTable;
        $itemsT = MOrder::$itemsTable;
        $tokoT = "tbl_toko";
        $produkT = "tbl_produk";

        $this->db->select("$orderT.idOrder AS idOrder");
        $this->db->select("$orderT.statusOrder AS statusOrder");
        $this->db->select("$orderT.idKonsumen AS idKonsumen");
        $this->db->select("$orderT.tanggalDibuat AS tanggalOrder");
        $this->db->select("$orderT.tanggalDiubah AS tanggalDiubah");
        // Detail Order
        $this->db->select("$detailT.idOrderDetail AS idOrderDetail");
        $this->db->select("$detailT.idToko AS idToko");
        $this->db->select("$detailT.resi AS resi");
        $this->db->select("$detailT.kurir AS kurir");
        $this->db->select("$detailT.ongkir AS ongkir");
        $this->db->select("$detailT.etd AS etd");
        $this->db->select("$detailT.fromIdKota AS fromIdKota");
        $this->db->select("$detailT.toIdKota AS toIdKota");
        $this->db->select("$detailT.fromAddress AS fromAddress");
        $this->db->select("$detailT.toAddress AS toAddress");
        // Produk
        $this->db->select("$produkT.idKat AS idKategori");
        $this->db->select("$produkT.idProduk");
        $this->db->select("$produkT.namaProduk");
        $this->db->select("$produkT.foto AS fotoProduk");
        $this->db->select("$produkT.harga as hargaProduk");
        $this->db->select("$produkT.berat as beratProduk");
        // // Toko
        $this->db->select("$tokoT.idToko AS idToko");
        $this->db->select("$tokoT.namaToko AS namaToko");
        $this->db->select("$tokoT.deskripsi AS deskripsiToko");
        $this->db->select("$tokoT.logo AS logoToko");
        // 
        $this->db->select("$itemsT.harga AS hargaOrder");
        $this->db->select("$itemsT.jumlah AS qtyOrder");

        $this->db->from($orderT);
        $this->db->join($detailT, "$detailT.idOrder = $orderT.idOrder", "right");
        $this->db->join($itemsT, "$itemsT.idOrderDetail = $detailT.idOrderDetail", "right");
        $this->db->join($tokoT, "$tokoT.idToko = $detailT.idToko", "right");
        $this->db->join($produkT, "$produkT.idProduk = $itemsT.idProduk", "right");

        $this->db->where("$orderT.idKonsumen", $userId);
        $this->db->order_by("$orderT.tanggalDibuat", "DESC");


        $query = $this->db->get();
        return $query->result();
    }

    public function add_order($cartOrder, $customer)
    {
        $orderTimeCreated = new DateTime('now', new DateTimeZone('+0700'));
        $this->db->trans_start();

        // Create order
        $orderId = $orderTimeCreated->getTimestamp();
        $this->db->insert(MOrder::$table, [
            'idOrder' => $orderId,
            "idKonsumen" => $customer->idKonsumen,
            "tanggalDibuat" => $orderTimeCreated->format('Y-m-d H:i:s'),
            "tanggalDiubah" => $orderTimeCreated->format('Y-m-d H:i:s'),
            "statusOrder" => "Belum Dibayar",
        ]);

        foreach ($cartOrder->items as $detail) {
            // Create order detail
            $this->db->insert(MOrder::$detailTable, [
                "idOrder" => $orderId,
                "idToko" => $detail->toko->id_toko,
                "kurir" => $detail->ongkir->selected->description,
                "ongkir" => $detail->ongkir->selected->value,
                "etd" => $detail->ongkir->selected->estimation,
                "fromIdKota" => $detail->toko->idKota,
                "toIdKota" => $customer->idKota,
                "fromAddress" => $detail->kota_asal,
                "toAddress" => $detail->kota_tujuan,
            ]);
            $orderDetailId = $this->db->insert_id();

            $orderItems = array_map(function ($item) use ($orderDetailId) {
                return [
                    "idOrderDetail" => $orderDetailId,
                    "idProduk" => $item->idProduk,
                    "jumlah" => $item->qty,
                    "harga" => $item->hargaProduk
                ];
            }, $detail->produk);
            $this->db->insert_batch(MOrder::$itemsTable, $orderItems);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return "fail";
        }

        $this->db->trans_commit();
        return  [
            'id' => $orderId,
            'time' => $orderTimeCreated->format('Y-m-d H:i:s O')
        ];
    }

    public function change_state($orderId, $state)
    {
        $orderTimeUpdated = new DateTime('now', new DateTimeZone('+0700'));
        $this->db->where('idOrder', $orderId);
        $this->db->update(MOrder::$table, [
            'statusOrder' => $state,
            'tanggalDiubah' => $orderTimeUpdated
        ]);

        log_message('info', "Order ID: $orderId, State: $state, Affected Rows: " . $this->db->affected_rows());
        return $this->db->affected_rows();
    }

    public function get_orders()
    {
    }
}
