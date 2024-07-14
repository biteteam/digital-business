<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori extends BaseController
{
    public $addOrSaveRules = [
        [
            'field'  => 'namaKat',
            'label'  => 'Nama Kategori',
            'rules'  => 'required|min_length[3]',
            'errors' => [
                'required' => "%s tidak boleh kosong.",
                'min_length' => "Panjang %s minimal 3 karakter."
            ]
        ]
    ];

    public function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata('userName'))) return redirect('adminpanel');
        $this->load->model('MAdmin');
        $this->load->helper(['form', 'url']);
    }

    public function index()
    {
        $data['kategori'] = $this->MAdmin->get_all_data('tbl_kategori')->result();
        $this->load->view('admin/layout/header');
        $this->load->view('admin/layout/menu');
        $this->load->view('admin/kategori/tampil', $data);
        $this->load->view('admin/layout/footer');
    }

    public function add()
    {
        $this->load->view('admin/layout/header');
        $this->load->view('admin/layout/menu');
        $this->load->view('admin/kategori/form-add');
        $this->load->view('admin/layout/footer');
    }

    public function save()
    {
        // Validation
        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->addOrSaveRules);
        if (!$this->form_validation->run()) return $this->add();

        $namaKat = $this->input->post('namaKat');
        $data = ['namaKat' => $namaKat];
        $added = $this->MAdmin->insert('tbl_kategori', $data);
        if (!$added) {
            $this->session->set_flashdata('error', "Gagal menambahkan kategori $namaKat");
            return $this->add();
        }


        $this->session->set_flashdata('success', "Berhasil menambahkan kategori $namaKat!");
        return redirect('kategori');
    }

    public function get_by_id($id)
    {
        $data = ['idKat' => $id];
        $data['kategori'] = $this->MAdmin->get_by_id('tbl_kategori', $data)->row_object();
        if (empty($data['kategori'])) {
            $this->session->set_flashdata('error', "Tidak ditemukan kategori dengan id $id!");
            return redirect("kategori");
        }

        $this->load->view('admin/layout/header');
        $this->load->view('admin/layout/menu');
        $this->load->view('admin/kategori/form-edit', $data);
        $this->load->view('admin/layout/footer');
    }

    public function edit()
    {
        // Serialize Form Data
        $id = $this->input->post('idKat');
        $namaKategori = $this->input->post('namaKat');
        $data = ['namaKat' => $namaKategori];

        // Validation
        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->addOrSaveRules);
        if (!$this->form_validation->run()) return $this->get_by_id($id);

        // Updating
        $updated = $this->MAdmin->update('tbl_kategori', $data, 'idKat', $id);
        if (!$updated) {
            // !updated  ->  redirect/return back & give err msg
            $this->session->set_flashdata('error', "Gagal mengedit kategori $namaKategori");
            return $this->get_by_id($id);
        }

        // Redirect to home category page if success

        $this->session->set_flashdata('success', "Berhasil mengedit kategori $namaKategori!");
        return redirect('kategori');
    }

    public function delete($id)
    {
        $this->MAdmin->delete('tbl_kategori', 'idKat', $id);
        $this->session->set_flashdata('success', "Berhasil menghapus data!");
        return redirect('kategori');
    }
}
