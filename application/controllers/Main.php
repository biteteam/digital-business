<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MAdmin', 'adminModel');
    }

    public function index()
    {
        $data['produk'] = $this->adminModel->get_produk()->result();
        $data['kategori'] = $this->adminModel->get_all_data('tbl_kategori')->result();

        $this->load->view('home/layout/header', $data);
        $this->load->view('home/layanan');
        $this->load->view('home/home');
        $this->load->view('home/layout/footer');
    }

    public function detail_produk(int | null $idProduk = null)
    {
        if (empty($idProduk)) return redirect("/");

        $kategori = $this->adminModel->get_all_data('tbl_kategori')->result();
        $produk = $this->adminModel->get_by_id('tbl_produk', ['idProduk' => $idProduk])->row_object();
        $this->load->view('home/layout/header', ['kategori' => $kategori]);
        $this->load->view('home/detail-produk', ['produk' => $produk]);
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
