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

        $this->load->library('session');
        $this->load->library('user_agent');
        $this->load->driver('cache', [
            'adapter' => 'apc',
            'backup' => 'file'
        ]);


        if ($this->session->userdata("idKonsumen")) {
            $userId = $this->session->userdata("idKonsumen");
            $this->isAuthenticated = true;

            $this->load->model('MCart', "cartModel");
            $this->header['cartCount'] = $this->cartModel->cartCount($userId);

            $this->load->model('MOrder', "orderModel");
            $this->header['shopOrderActionCount'] = $this->orderModel->shopOrderActionCount($userId);
        }
    }

    // Method ini akan memuat view header dengan data global
    public function load_view($view, $data = array())
    {
        $data = array_merge($data, $this->header);
        $this->load->view($view, $data);
    }

    public function redirectError($message, $path = null)
    {
        $this->session->set_flashdata("error", $message);
        return redirect($path ?? $this->agent->referrer());
    }

    public function redirectSuccess($message, $path = null)
    {
        $this->session->set_flashdata("success", $message);
        return redirect($path ?? $this->agent->referrer());
    }

    public function isAuthenticated()
    {
        return !empty($this->session->userdata("idKonsumen"));
    }

    public function getUserAuth()
    {
        $userId = $this->session->userdata("idKonsumen");
        if (empty($userId)) return null;

        $user = $this->adminModel->get_by_id("tbl_member", ["idKonsumen" => $userId]);
        return $user->result()[0];
    }
}
