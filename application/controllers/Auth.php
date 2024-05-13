

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MUser', "userModel");
    }

    public function index()
    {
        return redirect('auth/login');
    }

    public function login()
    {
        // if ($this->input->method() == 'post') return $this->login_action();
        $this->load->view('home/layout/header');
        $this->load->view('home/login');
        $this->load->view('home/layout/footer');
    }

    public function register()
    {
        // if ($this->input->method() == 'post') return $this->register_action();
        $this->load->view('home/layout/header');
        $this->load->view('home/register');
        $this->load->view('home/layout/footer');
    }

    public function login_action()
    {
        if ($this->input->method() !== 'post') return $this->login();
        $uname = $this->input->post('username');
        $pass  = $this->input->post('password');

        $loginQuery = $this->userModel->cek_login($uname, $pass);
        $member = $loginQuery->row_object();
        $exists = $loginQuery->num_rows();
        if (!boolval($exists) || $member->statusAktif != "Y") return redirect('auth/login');


        $session = [
            'idKonsumen' => $member->idKonsumen,
            'member' => $member->username,
            'status' => 'login'
        ];
        $this->session->set_userdata($session);
        return redirect('/');
    }

    public function register_action()
    {
        if ($this->input->method() !== 'post') return $this->register();
        $data = $this->input->post();
        $data['statusAktif'] = "Y";

        if (empty($data) || empty($data['username'])) return redirect('auth/register');

        $exists = $this->userModel->cek_user($data['username'])->num_rows();
        if (!empty($exists)) return redirect('auth/register');

        $this->userModel->insert('tbl_member', $data);
        return redirect('auth/login');
    }
}
