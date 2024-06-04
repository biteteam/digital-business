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
        $data['kategori'] = $this->adminModel->get_all_data('tbl_kategori')->result();
        $data['produk'] = $this->adminModel->get_all_data('tbl_produk')->result();

        $this->load->view('home/layout/header', $data);
        $this->load->view('home/layanan');
        $this->load->view('home/home');
        $this->load->view('home/layout/footer');
    }
}
