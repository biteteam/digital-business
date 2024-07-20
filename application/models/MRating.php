<?php

class MRating extends CI_Model
{
    public static $table = "tbl_rating";
    public static $ratingValues = ['buruk', 'cukup-buruk', 'cukup-bagus', 'bagus', 'sangat-bagus'];

    public function get_rating_by_product($productId)
    {
        $this->db->select('tbl_rating.*');
        $this->db->select('tbl_member.*');

        $this->db->from(MRating::$table);
        $this->db->join('tbl_order_items', "tbl_order_items.idOrderItem = tbl_rating.idOrderItem", "right");
        $this->db->join('tbl_order_detail', "tbl_order_detail.idOrderDetail = tbl_order_items.idOrderDetail", "right");
        $this->db->join('tbl_order', "tbl_order.idOrder = tbl_order_detail.idOrder", "right");
        $this->db->join('tbl_member', "tbl_member.idKonsumen = tbl_order.idKonsumen", "right");

        $this->db->where('tbl_order_items.idProduk', $productId);

        $rating = $this->db->get()->result();
        return $rating;
    }

    public function rating($rating, $review, $orderItemId)
    {
        $this->db->insert(MRating::$table, [
            'idOrderItem' => $orderItemId,
            'rating' => $rating,
            'review' => $review,
        ]);

        return $this->db->affected_rows();
    }
}
