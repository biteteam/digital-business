<?php

use function PHPSTORM_META\type;

defined('BASEPATH') or exit('No direct script access allowed');

class Order extends BaseController
{
    private $midtransConfig =  [
        "server_key" => "",
        "client_key" => "",
        "production" => false
    ];

    public function __construct()
    {
        parent::__construct();
        if (!$this->isAuthenticated()) return $this->redirectError("Anda harus login!", "/login");
        $this->midtransConfig['server_key'] = config('midtrans_server_apikey');
        $this->midtransConfig['client_key'] = config('midtrans_client_apikey');
        $this->load->model("MOrder", "orderModel");
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

    public function pay()
    {
        if ($this->input->method(true) !== "POST") return $this->redirectError("Ada yang salah!");

        $cartToCheckout = json_decode(base64_decode($this->input->post("checkout")));
        $customer = $this->getUserAuth();

        $this->load->library('midtrans');
        $this->midtrans->config($this->midtransConfig);
        $this->load->helper('url');

        $item_details = [];
        foreach ($cartToCheckout->items as $items) {
            $item_details = array_merge($item_details, array_map(function ($item) use ($items) {
                return [
                    'id' => $item->idProduk,
                    'price' => intval($item->hargaProduk),
                    'quantity' => intval($item->qty),
                    'name' => substr($item->namaProduk, 0, 32),
                    "category" => $item->namaKategori,
                    "merchant_name" => $items->toko->nama_toko,
                    "url" => base_url("/produk/{$items->toko->id_toko}")
                ];
            }, $items->produk));
        }


        foreach ($cartToCheckout->items as $items) {
            array_push(
                $item_details,
                [
                    'price' => intval($items->ongkir->selected->value),
                    'quantity' => 1,
                    'name' => "Shipping ({$items->toko->nama_toko}) | {$items->ongkir->selected->description}",
                    "category" => "Shipping",
                ]
            );
        }


        // Populate customer's billing address
        $billing_address = [
            'first_name'   => explode(" ", $customer->namaKonsumen)[0],
            'last_name'    => explode(" ", $customer->namaKonsumen)[1],
            'address'      => $customer->alamat,
            'city'         => explode(",", $customer->alamat)[0],
            'postal_code'  => explode(")", explode("(", $customer->alamat)[1])[0],
            'phone'        => $customer->tlpn,
            'country_code' => 'IDN'
        ];

        // Populate customer's shipping address
        $shipping_address = [
            'first_name'   => $billing_address['first_name'],
            'last_name'    => $billing_address['last_name'],
            'address'      => $billing_address['address'],
            'city'         => $billing_address['city'],
            'postal_code'  => $billing_address['postal_code'],
            'phone'        => $billing_address['phone'],
            'country_code' => $billing_address['country_code']
        ];


        // Populate customer's info
        $customer_details = [
            'first_name'       => $billing_address['first_name'],
            'last_name'        => $billing_address['last_name'],
            'email'            => $customer->email,
            'phone'            => $customer->tlpn,
            'billing_address'  => $billing_address,
            'shipping_address' => $shipping_address
        ];


        $seller_details = [
            'id' => 'sellerId-01',
            'name' => 'John Seller',
            'email' => 'seller@email.com',
            'url' => 'https://tokojohn.com',
            'address' => [
                'first_name' => 'John',
                'last_name' => 'Seller',
                'phone' => '081234567890',
                'address' => 'Kemanggisan',
                'city' => 'Jakarta',
                'postal_code' => '12190',
                'country_code' => 'IDN',
            ],
        ];

        $orderId = $this->orderModel->add_order($cartToCheckout, $customer);
        if ($orderId == "fail") {
            $this->session->set_flashdata("error", "Gagal checkout, Silahkan ulangi!");
            return redirect("/cart");
        }

        $transaction_details = array(
            'order_id' => $orderId,
            'gross_amount' => $cartToCheckout->total,
        );

        $expiration = [
            "start_time" => date("Y-m-d H:i:s O", time()),
            "unit" => "hours",
            "duration" => 6
        ];

        $params = [
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
            'item_details' => $item_details,
            'expiry' => $expiration
        ];

        try {
            $snapToken = $this->midtrans->getSnapToken($params);
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'snapToken' => $snapToken
                ]));
        } catch (\Exception $e) {
            echo $e->getMessage();
            var_dump($e);
        }
    }


    public function tracking()
    {
        // TODO: tracking an order
    }
}
