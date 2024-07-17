<?php

use function PHPSTORM_META\map;

defined('BASEPATH') or exit('No direct script access allowed');

class Cart extends BaseController
{
    private $userId;
    public function __construct()
    {
        parent::__construct();
        $this->load->model("MAdmin", "adminModel");
        $this->load->model('MCart', 'cartModel');
        $this->load->library('user_agent');

        if (empty($this->session->userdata("idKonsumen"))) return redirect("/login");
        $this->userId = $this->session->userdata("idKonsumen");
        if (!$this->session->userdata("idKotaAsal")) $this->session->set_userdata("idKotaAsal", 154);
    }

    public function index()
    {
        $cartItem =  $this->cartModel->items();
        $data['carts'] = !empty($cartItem) ? $this->calculateCart($cartItem) : [];

        $this->load->view('home/layout/header');
        $this->load->view('home/cart', $data);
        $this->load->view('home/layout/footer');
    }


    public function add()
    {
        $idProduk = $this->input->post('id-produk');

        $qtyUpdated = $this->cartModel->updateQtyProductOnExist($idProduk, $this->userId);
        if ($qtyUpdated) {
            $this->session->set_flashdata('success', "Berhasil menambah kuantitas produk di keranjang!");
            return redirect('cart');
        }

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

    public function delete($id)
    {
        $deleted = $this->cartModel->delete_by_id($id);
        if (!$deleted) $this->session->set_flashdata('error', "Gagal menghapus cart!");

        return redirect('/cart');
    }


    public function increase_qty($cartId)
    {
        if ($this->input->method() !== "post") return redirect("/cart");
        $this->cartModel->updateQty($cartId, "increase");

        return redirect("/cart");
    }

    public function decrase_qty($cartId)
    {
        if ($this->input->method() !== "post") return redirect("/cart");
        $this->cartModel->updateQty($cartId, "decrase");

        return redirect("/cart");
    }

    private function calculateCart($carts)
    {
        $mappedCarts = [];
        foreach ($carts as $cart) {
            $tmpCart = $cart;
            $cart = $this->mapCartProduct((array) $cart);

            if (empty($mappedCarts[$tmpCart->idToko]['produk'])) {
                $mappedCarts[$tmpCart->idToko]['produk'] = [(array)$cart];
                $mappedCarts[$tmpCart->idToko]['total_berat'] = intval($cart['beratProdukTotal']);
                $mappedCarts[$tmpCart->idToko]['total_harga'] = intval($cart['hargaProdukTotal']);
                $mappedCarts[$tmpCart->idToko]['sub_total'] = intval($cart['hargaProdukTotal']);
            } else {
                $mappedCarts[$tmpCart->idToko]['produk'] = array_merge($mappedCarts[$tmpCart->idToko]['produk'], [(array)$cart]);
                $mappedCarts[$tmpCart->idToko]['total_berat'] += intval($cart['beratProdukTotal']);
                $mappedCarts[$tmpCart->idToko]['total_harga'] += intval($cart['hargaProdukTotal']);
                $mappedCarts[$tmpCart->idToko]['sub_total'] += intval($cart['hargaProdukTotal']);
            }

            $mappedCarts[$tmpCart->idToko]['toko']['id_toko'] = $tmpCart->idToko;
            $mappedCarts[$tmpCart->idToko]['toko']['nama_toko'] = $tmpCart->namaToko;
            $mappedCarts[$tmpCart->idToko]['toko']['deskripsi_toko'] = $tmpCart->deskripsiToko;
            $mappedCarts[$tmpCart->idToko]['toko']['logo_toko'] = $tmpCart->logoToko;
            $mappedCarts[$tmpCart->idToko]['toko']['idKota'] = $tmpCart->idKotaSeller;
            $mappedCarts[$tmpCart->idToko]['toko']['seller_toko'] = $tmpCart->namaSeller;
            $mappedCarts[$tmpCart->idToko]['toko']['username_seller_toko'] = $tmpCart->usernameSeller;
        }

        foreach ($mappedCarts as $key => $cart) {
            $mappedCarts['items'] = (empty($mappedCarts['items'])) ? [$cart] : array_merge($mappedCarts['items'], [$cart]);
            unset($mappedCarts[$key]);
        }

        $mappedCarts['total_berat'] = 0;
        $mappedCarts['total_ongkir'] = 0;
        $mappedCarts['sub_total'] = 0;
        $mappedCarts['total'] = 0;

        // Calculate ongkir
        foreach ($mappedCarts['items'] as $index => $cart) {
            $idKotaPengirim = intval($cart['toko']['idKota']);
            $idKotaPenerima = intval($this->session->userdata('idKotaTujuan'));

            $ongkir = getOngkir($idKotaPengirim, $idKotaPenerima, $cart['total_berat'], 'random');
            $cart['kota_asal'] = "{$ongkir['kota_asal']['city_name']}, {$ongkir['kota_asal']['province']}";
            $cart['kota_tujuan'] = "{$ongkir['kota_tujuan']['city_name']}, {$ongkir['kota_tujuan']['province']}";

            $ongkirResult = $ongkir['result'][rand(0, count($ongkir['result']) - 1)];
            $ongkirResultCosts = $ongkirResult['costs'][rand(0, count($ongkirResult['costs']) - 1)];
            $ongkirResultCost = $ongkirResultCosts['cost'][rand(0, count($ongkirResultCosts['cost']) - 1)];
            $cart['ongkir'] = [
                'selected_code' => $ongkirResult['code'],
                'selected_service' => $ongkirResultCosts['service'],
                'selected_etd' => $ongkirResultCost['etd'],
                'options' => $ongkir['result'],
            ];

            $cart['ongkir'] = array_merge($cart['ongkir'], [
                "selected" => getOngkirValueBySelected($cart['ongkir'])
            ]);

            $cart['total_harga'] = intval($cart['total_harga']) + intval($cart['ongkir']['selected']['value']);

            $mappedCarts['total_berat'] = intval($mappedCarts['total_berat']) + intval($cart['total_berat']);
            $mappedCarts['sub_total'] = intval($mappedCarts['sub_total']) + intval($cart['sub_total']);
            $mappedCarts['total_ongkir'] = intval($mappedCarts['total_ongkir']) + intval($cart['ongkir']['selected']['value']);
            $mappedCarts['total'] = intval($mappedCarts['total']) + intval($cart['total_harga']);
            $mappedCarts['items'][$index] = $cart;
        }


        // dd($mappedCarts);
        return $mappedCarts;
    }

    private function mapCartProduct($cart)
    {
        unset($cart["idToko"]);
        unset($cart["idSeller"]);
        unset($cart["namaToko"]);
        unset($cart["logoToko"]);
        unset($cart["deskripsiToko"]);
        unset($cart["usernameSeller"]);
        unset($cart["namaSeller"]);
        unset($cart["idKotaSeller"]);
        unset($cart["alamatSeller"]);
        unset($cart["emailSeller"]);
        unset($cart["tlpnSeller"]);

        $cart['hargaProdukTotal'] = $cart['hargaProduk'] * $cart['qty'];
        $cart['beratProdukTotal'] = $cart['beratProduk'] * $cart['qty'];

        return $cart;
    }
}
