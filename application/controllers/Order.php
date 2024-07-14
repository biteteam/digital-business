<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata("idKonsumen"))
            return redirect("/login");
    }

    public function index()
    {
        // TODO: transaction/order history (success|fail included)
        $this->load->view('welcome_message');
    }

    public function rating()
    {
        // TODO: rating product by order success
    }

    public function payment()
    {
        // Pay an order
        $midtransConfig = [
            "server_key" => config('midtrans_server_apikey'), "production" => false
        ];

        $this->load->library('midtrans');
        $this->midtrans->config($midtransConfig);
        $this->load->helper('url');
    }

    public function tracking()
    {
        // TODO: tracking an order
    }
}
