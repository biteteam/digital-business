<?php

include_once("application/models/MUser.php");

class MOrder extends CI_Model
{
    public static $table = "tbl_order";
    public static $detailTable = "tbl_detail_order";

    public function add_order($cartOrder, $customer)
    {

        $couriers = [];
        $courier = "";
        foreach ($cartOrder->items as $index => $order) {
            if (!in_array($order->ongkir->selected->description, $couriers)) {
                array_push($couriers, $order->ongkir->selected->description);
                $courier  .= ($index == 0 ? "" : ", ") . $order->ongkir->selected->description;
            }
        }

        $this->db->trans_start();

        $this->db->insert(MOrder::$table, [
            "idKonsumen" => $customer->idKonsumen,
            "kurir" => $courier,
            "ongkir" => $cartOrder->total_ongkir,
            "amount" => $cartOrder->total,
            "tglOrder" => date('Y-m-d H:i:s'),
            "statusOrder" => "Belum Bayar",
        ]);

        if (!$this->db->affected_rows()) {
            $this->db->trans_rollback();
            return 'fail';
        }

        $orderId = $this->db->insert_id();
        $orderDetail = [];
        foreach ($cartOrder->items as $order) {
            $orderDetail = array_merge($orderDetail, array_map(function ($orderItem) use ($orderId) {
                return [
                    "idOrder" => $orderId,
                    "idProduk" => $orderItem->idProduk,
                    "jumlah" => $orderItem->qty,
                    "harga" => $orderItem->hargaProduk
                ];
            }, $order->produk));
        }

        $this->db->insert_batch(MOrder::$detailTable, $orderDetail);


        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return "fail";
        } else {
            $this->db->trans_commit();
            return $orderId;
        }
    }

    public function get_orders()
    {
    }
}
