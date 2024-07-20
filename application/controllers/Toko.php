<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Toko extends BaseController
{
    private $uploadConfig = [
        'upload_path'   => 'assets/logo_toko/',
        'allowed_types' => 'jpg|jpeg|png|gif|ico|svg|webp',
        'overwrite'     => true
    ];

    private $addOrSaveRules = [
        [
            'field'  => 'namaToko',
            'label'  => 'Nama Toko',
            'rules'  => 'required|min_length[5]|max_length[32]',
            'errors' => [
                'required' => "%s tidak boleh kosong.",
                'min_length' => "Panjang %s minimal 5 karakter.",
                'max_length' => "Panjang %s maksimal 32 karakter."
            ]
        ],
        [
            'field'  => 'deskripsi',
            'label'  => 'Deskripsi',
            'rules'  => 'required|min_length[6]|max_length[200]',
            'errors' => [
                'required' => "%s tidak boleh kosong.",
                'min_length' => "Panjang %s minimal 6 karakter.",
                'max_length' => "Panjang %s maksimal 200 karakter."
            ]
        ]
    ];

    public function __construct()
    {
        parent::__construct();
        $this->load->model('MAdmin', 'adminModel');
        $this->load->helper(['form', 'url']);
        $this->load->library('form_validation');
    }

    public function index()
    {
        $toko = $this->adminModel->get_all_data('tbl_toko')->result();
        $data['toko'] = $toko;

        $this->load->view('home/layout/header');
        $this->load->view('home/toko/index', $data);
        $this->load->view('home/layout/footer');
    }

    public function add()
    {
        $this->load->view('home/layout/header');
        $this->load->view('home/toko/form-add');
        $this->load->view('home/layout/footer');
    }

    public function save()
    {
        $this->form_validation->set_rules($this->addOrSaveRules);
        if (!$this->form_validation->run()) return $this->add();

        $id = $this->session->userdata("idKonsumen");
        $nama_toko = $this->input->post('namaToko');
        $deskripsi = $this->input->post('deskripsi');

        $this->load->library('upload', $this->uploadConfig);
        if ($this->upload->do_upload('logo')) {
            $data_file = $this->upload->data();
            $data_insert = [
                'idKonsumen' => $id,
                'namaToko' => $nama_toko,
                'logo' => $data_file['file_name'],
                'deskripsi' => $deskripsi,
                'statusAktif' => 'Y'
            ];

            $this->adminModel->insert('tbl_toko', $data_insert);
            $this->session->set_flashdata('success', "Berhasil menambahkan toko");
            return redirect('toko');
        } else {
            $error = $this->upload->display_errors();
            log_message('error', 'Upload logo toko error: ' . $error);
        }

        $this->session->set_flashdata('error', "Gagal menambahkan toko");
        return $this->add();
    }

    public function get_by_id($id)
    {
        $where = ['idToko' => $id];
        $data['toko'] = $this->adminModel->get_by_id('tbl_toko', $where)->row_object();
        if (empty($data['toko'])) {
            $this->session->set_flashdata('error', "Toko tidak ditemukan");
            return redirect('toko');
        }

        $this->load->view('home/layout/header');
        $this->load->view('home/toko/form-edit', $data);
        $this->load->view('home/layout/footer');
    }

    public function edit()
    {
        $this->form_validation->set_rules($this->addOrSaveRules);
        if (!$this->form_validation->run()) return $this->add();

        $idToko = $this->input->post('idToko');
        $idKonsumen = $this->session->userdata("idKonsumen");
        $toko = $this->adminModel->get_by_id('tbl_toko', ['idToko' => $idToko, 'idKonsumen' => $idKonsumen])->row_array();

        if (!$toko) {
            $this->session->set_flashdata('error', "Gagal mengedit toko, Toko tidak ditemukan");
            return redirect('toko/get-by-id/' . $idToko);
        }

        $toko['namaToko'] = $this->input->post('namaToko');
        $toko['deskripsi'] = $this->input->post('deskripsi');
        $toko['logo'] = $this->input->post('logo_filename');

        $this->load->library('upload', $this->uploadConfig);
        if ($this->upload->do_upload('logo')) {
            $data_file = $this->upload->data();
            $toko['logo'] = $data_file['file_name'];
        }

        $updated = $this->adminModel->update('tbl_toko', $toko, 'idToko', $idToko);
        if (!$updated) {
            $this->session->set_flashdata('error', "Gagal mengedit toko {$toko['namaToko']}");
            return redirect('toko/get-by-id/' . $idToko);
        }

        $this->session->set_flashdata('success', "Berhasil mengedit toko {$toko['namaToko']}");
        return redirect('toko');
    }

    public function delete($id)
    {
        $this->adminModel->delete('tbl_toko', 'idToko', $id);
        $this->session->set_flashdata('success', "Berhasil menghapus data!");
        return redirect('toko');
    }

    public function order($tokoId = null)
    {
        $userNow = $this->getUserAuth();
        $this->load->model('MOrder', 'orderModel');

        if ($this->input->method(true) == "POST" && $this->input->post('action') == "update-resi") {
            $this->update_resi($this->input->post('orderDetailId'), $this->input->post('resi'), true);
        }

        if (!empty($tokoId)) $data['toko'] = $this->adminModel->get_by_id('tbl_toko', ['idToko' => $tokoId])->row_object();
        $orders = (empty($tokoId)) ? $this->orderModel->shopOrder($userNow->idKonsumen) :  $this->orderModel->shopOrder($userNow->idKonsumen, $tokoId);
        $data['orders'] = $this->mapOrderToko($orders);

        $this->load->view('home/layout/header');
        $this->load->view('home/toko/order', $data);
        $this->load->view('home/layout/footer');
    }

    public function update_resi($orderDetailId, $resi, $isInternalCalled = false)
    {
        if (empty($resi) || $resi == "") return;
        if (!$isInternalCalled) $this->load->model('MOrder', 'orderModel');

        $isUpdated = $this->orderModel->change_resi($orderDetailId, $resi);
        $this->session->set_flashdata(($isUpdated) ? 'success' : "error", "Resi " . $isUpdated ? "berhasil" : "gagal" . " di update!");
    }

    public function mapOrderToko($raw_orders)
    {
        $orders = [];
        foreach (to_array($raw_orders) as $raw) {
            if (empty($orders[$raw['idOrder']])) $orders[$raw['idOrder']] = [];
            if (empty($orders[$raw['idOrder']]['items'])) $orders[$raw['idOrder']]['items'] = [];

            $itemProp = ['idProduk' => 'id', 'namaProduk' => 'nama', 'foto' => 'foto', 'harga' => 'harga', 'berat' => 'berat', 'jumlah' => 'qty'];
            foreach ($itemProp as $dbProp => $editedKeyProp) {
                $orders[$raw['idOrder']]['items'][$raw['idProduk']][$editedKeyProp] = $raw[$dbProp];
            }

            $storeProp = ['idToko' => 'id', 'namaToko' => 'nama', 'logo' => 'logo', 'deskripsi' => 'deskripsi'];
            foreach ($storeProp as $dbProp => $editedKeyProp) {
                $orders[$raw['idOrder']]['toko'][$editedKeyProp] = $raw[$dbProp];
            }

            $shippingProp = ['resi' => 'resi', 'ongkir' => 'ongkir', 'kurir' => 'kurir', 'etd' => 'etd', 'fromIdKota' => 'fromIdKota', 'toIdKota' => 'toIdKota', 'fromAddress' => 'fromAddress', 'toAddress' => 'toAddress'];
            foreach ($shippingProp as $dbProp => $editedKeyProp) {
                $orders[$raw['idOrder']]['shipping'][$editedKeyProp] = $raw[$dbProp];
            }

            $detailProp = ['tanggalDipesan' => 'tanggalDipesan', 'tanggalDiperbarui' => 'tanggalDiperbarui', 'statusOrder' => 'status'];
            foreach ($detailProp as $dbProp => $editedKeyProp) {
                $orders[$raw['idOrder']][$editedKeyProp] = $raw[$dbProp];
            }

            $orders[$raw['idOrder']]['orderId'] = $raw['idOrder'];
            $orders[$raw['idOrder']]['orderDetailId'] = $raw['idOrderDetail'];
        }


        $orders = array_values(array_map(function ($order) {
            $order['items'] = array_values($order['items']);
            $order['total'] = array_sum(array_map(fn ($item) => ($item['harga'] * $item['qty']), $order['items']));
            return $order;
        }, $orders));

        return to_object($orders);
    }
}
