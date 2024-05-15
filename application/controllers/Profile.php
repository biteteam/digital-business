<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MUser', "memberModel");
        if (empty($this->session->userdata('status')) || $this->session->userdata('status') !== "login")
            return redirect('login');
    }

    public function edit()
    {
        $memberId = $this->session->userdata('idKonsumen');
        $member = $this->memberModel->get_by_id('tbl_member', $memberId)->row_object();

        if ($this->input->method() == 'post') {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('namaKonsumen', 'Nama', 'required', ['required' => '%s harus di isi']);
            $this->form_validation->set_rules('username', 'Username', 'required', ['required' => '%s harus di isi']);
            $this->form_validation->set_rules('email', 'Email', 'required', ['required' => '%s harus di isi']);
            $this->form_validation->set_rules('tlpn', 'Telepon', 'required', ['required' => '%s harus di isi']);
            $this->form_validation->set_rules('idKota', 'Id Kota', 'required', ['required' => '%s harus di isi']);
            $this->form_validation->set_rules('alamat', 'Alamat', 'required', ['required' => '%s harus di isi']);
            if ($this->form_validation->run() && $member) {
                $data = [
                    "username" => $this->input->post('username'),
                    "namaKonsumen" => $this->input->post('namaKonsumen'),
                    "email" => $this->input->post('email'),
                    "tlpn" => $this->input->post('tlpn'),
                    "idKota" => $this->input->post('idKota'),
                    "alamat" => $this->input->post('alamat'),
                ];

                $updated = $this->memberModel->update('tbl_member', $data, 'idKonsumen', $member->idKonsumen);
                if ($updated) {
                    $this->session->set_flashdata('success', "Berhasil mengedit profil.");
                    return redirect('/');
                }

                $this->session->set_flashdata('error', "Gagal mengedit profil, mungkin karena tidak ada data yang berubah.");
            }
        }

        $this->load->helper('form');
        $data['member'] = $member;
        $this->load->view('home/layout/header');
        $this->load->view('home/layanan');
        $this->load->view('home/profile/edit', $data);
        $this->load->view('home/layout/footer');
    }
}
