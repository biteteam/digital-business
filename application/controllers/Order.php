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
        $userNow = $this->getUserAuth();
        $orders = $this->orderModel->summary($userNow->idKonsumen);

        $data['orders'] = empty($orders) ? $orders : $this->mapOrders($orders);


        // dd($data['orders']);

        $this->load->view('home/layout/header');
        $this->load->view('home/order/index', $data);
        $this->load->view('home/layout/footer');
    }

    public function orderDetail()
    {
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

        $order = $this->orderModel->add_order($cartToCheckout, $customer);
        if ($order == "fail") {
            $this->session->set_flashdata("error", "Gagal checkout, Silahkan ulangi!");
            return redirect("/cart");
        }

        $transaction_details = array(
            'order_id' => $order['id'],
            'gross_amount' => $cartToCheckout->total,
        );

        $expiration = [
            "start_time" => $order['time'],
            "unit" => "hours",
            "duration" => 6
        ];

        $params = [
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
            'item_details' => $item_details,
            'credit_card' => [
                'secure' => true
            ],
            'expiry' => $expiration
        ];


        $result = [];
        try {
            $this->load->library('midtrans');
            $this->midtrans->config($this->midtransConfig);
            $this->load->helper('url');

            $snapToken = $this->midtrans->getSnapToken($params);
            $result = ['snapToken' => $snapToken];
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function payment_state()
    {
        $result = json_decode($this->input->post('payment-result'));
        log_message('info', $this->input->post('payment-result'));

        $idOrder = $result->order_id;
        log_message('info', $idOrder);

        if ($result->transaction_status == 'settlement') {
            $this->orderModel->change_state($idOrder, "Dikemas");
            // TODO: remove some cart by checkouted items
        } else if ($result->transaction_status == 'deny') {
            $this->orderModel->change_state($idOrder, "Pembayaran Gagal");
        } else if ($result->transaction_status == 'expire') {
            $this->orderModel->change_state($idOrder, "Pembayaran Kadaluarsa");
        } else if ($result->transaction_status == 'cancel') {
            $this->orderModel->change_state($idOrder, "Pembayaran Dibatalkan");
        }

        return redirect('/order');
    }



    public function tracking()
    {
        // TODO: tracking an order
    }


    private function mapOrders($rawOrders)
    {
        $orders = [];

        foreach (json_decode(json_encode($rawOrders)) as $rawOrder) {
            $raw = (array)$rawOrder;
            if (empty($orders[$raw['idOrder']])) $orders[$raw['idOrder']] = [];
            if (empty($orders[$raw['idOrder']]['detail'][$raw['idToko']])) $orders[$raw['idOrder']]['detail'][$raw['idToko']] = [];
            if (empty($orders[$raw['idOrder']]['detail'][$raw['idToko']]['items'])) $orders[$raw['idOrder']]['detail'][$raw['idToko']]['items'] = [];

            $orders[$raw['idOrder']]['totalOngkir'] = 0;
            $orders[$raw['idOrder']]['totalBerat'] = 0;
            $orders[$raw['idOrder']]['subTotal'] = 0;
            $orders[$raw['idOrder']]['total'] = 0;

            $itemProp = ['idProduk' => 'id', 'idKategori' => 'idKategori', 'namaProduk' => 'nama', 'fotoProduk' => 'foto', 'hargaOrder' => 'harga', 'beratProduk' => 'berat', 'qtyOrder' => 'qty'];
            foreach ($itemProp as $dbProp => $editedKeyProp) {
                $orders[$raw['idOrder']]['detail'][$raw['idToko']]['items'][$raw['idProduk']][$editedKeyProp] = $raw[$dbProp];
            }

            $storeProp = ['idToko' => 'idToko', 'namaToko' => 'namaToko', 'logoToko' => 'logoToko', 'deskripsiToko' => 'deskripsiToko', 'tanggalOrder' => 'tanggalOrder', 'tanggalDiubah' => 'tanggalDiubah', 'statusOrder' => 'status', 'resi' => 'resi', 'ongkir' => 'ongkir', 'kurir' => 'kurir', 'etd' => 'etd', 'fromIdKota' => 'fromIdKota', 'toIdKota' => 'toIdKota', 'fromAddress' => 'fromAddress', 'toAddress' => 'toAddress'];
            foreach ($storeProp as $dbProp => $editedKeyProp) {
                $orders[$raw['idOrder']]['detail'][$raw['idToko']][$editedKeyProp] = $raw[$dbProp];
            }

            $orders[$raw['idOrder']]['detail'][$raw['idToko']]['totalBerat'] = 0;
            $orders[$raw['idOrder']]['detail'][$raw['idToko']]['subTotal'] = 0;
            $orders[$raw['idOrder']]['detail'][$raw['idToko']]['total'] = 0;
        }

        $orders = array_values(array_map(function ($order) {
            $items = [];
            foreach ($order['detail'] as $index => $item) {
                $item['totalBerat'] = array_sum(array_values(array_map(fn ($itm) => ($itm['berat'] * $itm['qty']), $item['items'])));
                $item['subTotal'] = array_sum(array_values(array_map(fn ($itm) => ($itm['harga'] * $itm['qty']), $item['items'])));
                $item['total'] = $item['subTotal'] + $item['ongkir'];

                $order['tanggalOrder'] = $item['tanggalOrder'];
                $order['totalOngkir'] += $item['ongkir'];
                $order['totalBerat'] += $item['totalBerat'];
                $order['subTotal'] += $item['subTotal'];
                $order['total'] += $item['total'];

                $item['items'] = array_values($item['items']);
                array_push($items, $item);
            }

            $order['detail'] = $items;
            return $order;
        }, $orders));

        // dd($orders);
        return $orders;
    }
}
