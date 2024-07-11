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
        $cart = $this->cartModel->items();
        $kategori = $this->adminModel->get_all_data('tbl_kategori')->result();

        $this->load->view('home/layout/header', ['kategori' => $kategori]);
        $this->load->view('home/cart', ['cart' => $cart]);
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

        $isAddedToCart = $this->cartModel->insert_by_product($produk, $qty);
        if (!$isAddedToCart && $this->agent->referrer()) {
            $this->session->set_flashdata('error', "Gagal menambahkan produk ke keranjang!");
            return redirect($this->agent->referrer());
        }

        return redirect('cart');
    }
}
