<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdminPanel extends CI_Controller
{
	public function index()
	{
		if (!empty($this->session->userdata('userName'))) {
			return redirect('adminpanel/dashboard');
		}
		$this->load->view('admin/login');
	}

	public function dashboard()
	{
		if (empty($this->session->userdata('userName'))) {
			return redirect('adminpanel/login');
		}
		$this->load->view('admin/layout/header');
		$this->load->view('admin/layout/menu');
		$this->load->view('admin/dashboard');
		$this->load->view('admin/layout/footer');
	}

	public function login()
	{
		if ($this->input->method() !== "post") {
			return redirect('adminpanel');
		}
		$this->load->model('MAdmin');
		$uname = $this->input->post('username');
		$pass  = $this->input->post('password');

		$cek = $this->MAdmin->cek_login($uname, $pass)->num_rows();

		if ($cek == 1) {
			$session = [
				'userName' => $uname,
				'password' => $pass
			];
			$this->session->set_userdata($session);
			return redirect('adminpanel/dashboard');
		}

		return redirect('adminpanel');
	}

	public function logout()
	{
		$this->session->sess_destroy();
		return redirect('adminpanel');
	}
}
