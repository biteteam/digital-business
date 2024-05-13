<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MAdmin');
        if (empty($this->session->userdata('userName'))) return redirect('adminpanel');
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
        $namaKat = $this->input->post('namaKat');
        $data = ['namaKat' => $namaKat];
        $this->MAdmin->insert('tbl_kategori', $data);
        return redirect('kategori');
    }

    public function get_by_id($id)
    {
        $data = ['idKat' => $id];
        $data['kategori'] = $this->MAdmin->get_by_id('tbl_kategori', $data)->row_object();
        $this->load->view('admin/layout/header');
        $this->load->view('admin/layout/menu');
        $this->load->view('admin/kategori/form-edit', $data);
        $this->load->view('admin/layout/footer');
    }

    public function edit()
    {
        $id = $this->input->post('namaKat');
        $namaKategori = $this->input->post('namaKat');
        $data = ['namaKat' => $namaKategori];

        $this->MAdmin->update('tbl_kategori', $data, 'idKat', $id);
        redirect('kategori');
    }

    public function delete($id)
    {
        $this->MAdmin->delete('tbl_kategori', 'idKat', $id);
        return redirect('kategori');
    }
}
