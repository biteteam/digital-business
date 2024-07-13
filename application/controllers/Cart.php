<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cart extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("MAdmin", "adminModel");
        $this->load->model('MCart', 'cartModel');
        $this->load->library('user_agent');
    }

    public function index()
    {
        $idKotaAsal = $this->session->userdata("idKotaAsal");
        $idKotaTujuan = $this->session->userdata("idKotaTujuan");

        $data['cart'] = $this->cartModel->items();
        // dd($data['cart']);
        $kategori = $this->adminModel->get_all_data('tbl_kategori')->result();

        $data['sub_total'] = sub_total($data['cart']);
        $data['ongkir'] = getOngkir($idKotaAsal, $idKotaTujuan, sum_weight($data['cart']));

        $data['kota_asal'] = "{$data['ongkir']['kota_asal']['city_name']}, {$data['ongkir']['kota_asal']['province']}";
        $data['kota_tujuan'] = "{$data['ongkir']['kota_tujuan']['city_name']}, {$data['ongkir']['kota_tujuan']['province']}";

        $data['courier_value'] = $data['ongkir']['result'][0]['costs'][0]['cost'][0]['value'];
        $data['courier_description'] = $data['ongkir']['result'][0]['costs'][0]['description'];
        $data['total'] = $data['sub_total'] + $data['courier_value'];


        $this->load->view('home/layout/header', ['kategori' => $kategori]);
        $this->load->view('home/cart', $data);
        $this->load->view('home/layout/footer');
    }


    public function add()
    {
        $idProduk = $this->input->post('id-produk');
        $qty = intval($this->input->post('qty')) > 0 ? intval($this->input->post('qty')) : 1;
        $produk = $this->adminModel->get_by_id('tbl_produk', ['idProduk' => $idProduk])->row_object();
        if (!$produk) {
            $this->session->set_flashdata('error', "Produk tidak ditemukan");
            return redirect($this->agent->referrer());
        }

        $kota = $this->adminModel->get_kota_penjual($produk->idToko)->row_object();
        $this->session->set_userdata("idKotaAsal", $kota->idKota);

        $isAddedToCart = $this->cartModel->insert_by_product($produk, $qty);
        if (!$isAddedToCart && $this->agent->referrer()) {
            $this->session->set_flashdata('error', "Gagal menambahkan produk ke keranjang!");
            return redirect($this->agent->referrer());
        }

        return redirect('cart');
    }
}
