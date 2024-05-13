<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Toko extends CI_Controller
{
    private $uploadConfig = [
        'upload_path'   => './assets/logo_toko/',
        'allowed_types' => 'jpg|png|jpeg',
        'overwrite'     => true
    ];

    public function __construct()
    {
        parent::__construct();
        $this->load->model('MAdmin', 'adminModel');
    }

    public function index()
    {
        $data['toko'] = $this->adminModel->get_all_data('tbl_toko')->result();
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
            return redirect('toko');
        }

        return redirect('toko/add');
    }


    public function get_by_id($id)
    {
        $where = ['idToko' => $id];
        $data['toko'] = $this->adminModel->get_by_id('tbl_toko', $where)->row_object();
        if (empty($data['toko'])) return redirect('toko');
        $this->load->view('home/layout/header');
        $this->load->view('home/toko/form-edit', $data);
        $this->load->view('home/layout/footer');
    }

    public function edit()
    {
        $idToko = $this->input->post('idToko');
        $idKonsumen = $this->session->userdata("idKonsumen");
        $toko = $this->adminModel->get_by_id('tbl_toko', ['idToko' => $idToko, 'idKonsumen' => $idKonsumen])->row_array();
        if (!$toko) return redirect('toko/get-by-id/' . $idToko);

        $toko['namaToko'] = $this->input->post('namaToko');
        $toko['deskripsi'] = $this->input->post('deskripsi');
        $toko['logo'] = $this->input->post('logo_filename');

        $this->load->library('upload', $this->uploadConfig);
        if ($this->upload->do_upload('logo')) {
            $data_file = $this->upload->data();
            $toko['logo'] = $data_file['file_name'];
        }

        $updated = $this->adminModel->update('tbl_toko', $toko, 'idToko', $idToko);
        if (!$updated) return redirect('toko/get-by-id/' . $idToko);

        return redirect('toko');
    }

    public function delete($id)
    {
        $this->adminModel->delete('tbl_toko', 'idToko', $id);
        return redirect('toko');
    }
}
