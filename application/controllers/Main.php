<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MAdmin', 'adminModel');
        $this->load->model('MOrder', 'orderModel');
        $this->load->model('MRating', 'ratingModel');
    }

    public function index()
    {
        $data['produk'] = $this->adminModel->get_produk()->result();

        $this->load->view('home/layout/header', $data);
        $this->load->view('home/layanan');
        $this->load->view('home/home');
        $this->load->view('home/layout/footer');
    }

    public function detail_produk(int | null $idProduk = null)
    {
        if (empty($idProduk)) return redirect("/");
        if (!empty($this->input->post('order-item-id'))) $data['orderItemId'] = $this->input->post('order-item-id');
        $data['produk'] = $this->adminModel->get_by_id('tbl_produk', ['idProduk' => $idProduk])->row_object();
        $data['ratings'] = $this->ratingModel->get_rating_by_product($idProduk);

        $this->load->view('home/layout/header');
        $this->load->view('home/detail-produk', $data);
        $this->load->view('home/layout/footer');
    }


    public function province($idProvince = null)
    {
        $province = getProvince($idProvince);

        header('Content-type: application/json');
        echo json_encode($province);
    }

    public function city($idProvince = null, $idCity = null)
    {
        $city = getCity($idCity, $idProvince);

        header('Content-type: application/json');
        echo json_encode($city);
    }
}
