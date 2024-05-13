<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Member extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MAdmin');
        if (empty($this->session->userdata('userName'))) return redirect('adminpanel');
    }

    public function index()
    {
        $data['member'] = $this->MAdmin->get_all_data('tbl_member')->result();
        $this->load->view('admin/layout/header');
        $this->load->view('admin/layout/menu');
        $this->load->view('admin/member/tampil', $data);
        $this->load->view('admin/layout/footer');
    }

    public function ubah_status($id)
    {
        $where = ['idKonsumen' => $id];
        $result = $this->MAdmin->get_by_id('tbl_member', $where)->row_object();
        $status = $result->statusAktif;
        $dataUpdate = ($status == "Y")
            ? ['statusAktif' => 'N']
            : ['statusAktif' => 'Y'];

        $this->MAdmin->update('tbl_member', $dataUpdate, 'idKonsumen', $id);
        return redirect('member');
    }

    public function delete($id)
    {
        $this->MAdmin->delete('tbl_member', 'idKonsumen', $id);
        return redirect('member');
    }
}
