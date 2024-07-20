<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Shop extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('MAdmin', "adminModel");
    }

    public function index()
    {
        $filter = [];
        if ($this->input->get('search')) $filter['tbl_produk.namaProduk'] = $this->input->get('search');
        if ($this->input->get('category')) $filter['tbl_produk.idKat'] = explode(",", $this->input->get('category'));
        if ($this->input->get('store')) $filter['tbl_toko.idToko'] = explode(",", $this->input->get('store'));

        $data['categories'] = $this->adminModel->get_all_data('tbl_kategori')->result();
        $data['stores'] = $this->adminModel->get_all_data('tbl_toko')->result();
        $data['products'] = $this->adminModel->get_produk_filter($filter)->result();

        // dd($data['products'][0]->berat);
        $this->load->view("home/layout/header");
        $this->load->view("home/shop", $data);
        $this->load->view("home/layout/footer");
    }
}
