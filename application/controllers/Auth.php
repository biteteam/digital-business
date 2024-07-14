

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends BaseController
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

        $memberAuthData = $this->userModel->cek_login($uname, $pass);
        if (!$memberAuthData || !count($memberAuthData)) {
            $this->session->set_flashdata('error', "Username atau Password salah!");
            return redirect('auth/login');
        }


        $session = $memberAuthData;
        $this->session->set_userdata($session);
        $this->session->set_flashdata('success', "Hallo $uname!");
        return redirect('/');
    }

    public function register_action()
    {
        if ($this->input->method() !== 'post') return $this->register();
        $data = $this->input->post();
        $data['statusAktif'] = "Y";
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        if (empty($data) || empty($data['username'])) return redirect('auth/register');

        $exists = $this->userModel->cek_user($data['username'])->num_rows();
        if (!empty($exists)) return redirect('auth/register');

        $this->userModel->insert('tbl_member', $data);
        $this->session->set_flashdata('success', "Berhasil register, Silahkan login!");
        return redirect('auth/login');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        return redirect('auth/login');
    }
}
