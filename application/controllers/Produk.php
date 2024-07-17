<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produk extends BaseController
{
    private $uploadConfig = [
        'upload_path'   => './assets/foto_produk/',
        'allowed_types' => 'jpg|png|jpeg',
        'overwrite'     => true
    ];

    public function __construct()
    {
        parent::__construct();
        $this->load->model("MAdmin", 'adminModel');
    }

    public function index(int | null $idToko = null)
    {
        if ($idToko == null) return redirect('toko');
        $data['idToko'] = $idToko;
        $data['toko'] = $this->adminModel->get_by_id('tbl_toko', ['idToko' => $data['idToko']])->result()[0];
        $data['produk'] = $this->adminModel->get_by_id('tbl_produk', ['idToko' => $data['idToko']])->result();

        $this->load->view('home/layout/header');
        $this->load->view('home/produk/index', $data);
        $this->load->view('home/layout/footer');
    }

    public function add(int | null $idToko = null)
    {
        $this->load->library('form_validation');
        if ($this->input->method() == "post") {
            $dataProduk = [
                'idKat' => $this->input->post("id-kategori"),
                'idToko' => $this->input->post("id-toko"),
                'namaProduk' => $this->input->post("nama"),
                'harga' => $this->input->post("harga"),
                'stok' => $this->input->post("stok"),
                'berat' => $this->input->post("berat"),
                'deskripsiProduk' => $this->input->post("deskripsi"),
            ];
            $idToko = $dataProduk['idToko'];

            $this->load->library('upload', $this->uploadConfig);
            if ($this->upload->do_upload('foto')) {
                $fotoUploaded = $this->upload->data();
                $data = array_merge($dataProduk, [
                    'foto' => $fotoUploaded['file_name']
                ]);

                $this->adminModel->insert('tbl_produk', $data);
                $this->session->set_flashdata('success', "Berhasil menambah produk");
                return redirect("produk/{$idToko}");
            }

            $uploadErr = $this->upload->display_errors('', '');
            $this->session->set_flashdata('error', $uploadErr);
        } else {
            if ($idToko == null) return redirect('toko');
        }

        $data['idToko'] = $idToko;
        $this->load->view('home/layout/header');
        $this->load->view('home/produk/form-add');
        $this->load->view('home/layout/footer');
    }

    public function edit(
        int | null $idToko = null,
        int | null $idProduk = null
    ) {

        $this->load->library('form_validation');
        $this->load->library('upload', $this->uploadConfig);

        $produk = $this->adminModel->get_by_id('tbl_produk', ['idProduk' => $idProduk ?? $this->input->post('id-produk')])->row_object();

        if ($this->input->method() == "post") {
            $idToko = $this->input->post('id-toko');
            $idProduk = $this->input->post('id-produk');
            $produk = [
                'idKat' => $this->input->post("id-kategori"),
                'idToko' => $this->input->post("id-toko"),
                'namaProduk' => $this->input->post("nama"),
                'harga' => $this->input->post("harga"),
                'stok' => $this->input->post("stok"),
                'berat' => $this->input->post("berat"),
                'deskripsiProduk' => $this->input->post("deskripsi"),
                'foto' => $produk->foto
            ];

            if ($this->upload->do_upload('foto')) {
                $fotoUploaded = $this->upload->data();
                $produk = array_merge($produk, [
                    'foto' => $fotoUploaded['file_name']
                ]);
            }

            $updated = $this->adminModel->update('tbl_produk', $produk, 'idProduk', $idProduk);
            if ($updated) {
                $this->session->set_flashdata('success', "Berhasil mengedit produk {$produk['namaProduk']}");
                return redirect('produk/' . $idToko);
            }

            $this->session->set_flashdata('error', "Gagal mengedit produk {$produk['namaProduk']}");
        }


        $data['idToko'] = $idToko;
        $data['produk'] = $produk;

        $this->load->view('home/layout/header');
        $this->load->view('home/produk/form-edit', $data);
        $this->load->view('home/layout/footer');
    }

    public function delete($idProduk, $idToko)
    {
        $this->adminModel->delete('tbl_produk', 'idProduk', $idProduk);
        $this->session->set_flashdata('success', "Berhasil menghapus produk!");
        return redirect('produk/' . $idToko);
    }
}
