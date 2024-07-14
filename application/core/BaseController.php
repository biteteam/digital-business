<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BaseController extends CI_Controller
{
    public $isAuthenticated = false;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('MAdmin', "adminModel");
        $this->header['kategori'] = $this->adminModel->get_all_data('tbl_kategori')->result();
        $this->load->driver('cache', [
            'adapter' => 'apc',
            'backup' => 'file'
        ]);

        if ($this->session->userdata("idKonsumen")) {
            $this->isAuthenticated = true;
            $this->load->model('MCart', "cartModel");
            $this->header['cartCount'] = $this->cartModel->cartCount();
        }
    }

    // Method ini akan memuat view header dengan data global
    public function load_view($view, $data = array())
    {
        $data = array_merge($data, $this->header);
        $this->load->view($view, $data);
    }
}
