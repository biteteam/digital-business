<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdminPanel extends CI_Controller
{
	public function index()
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
		$this->load->helper(['form', 'url']);

		if ($this->input->method() == "post") {
			/** Validation */
			$this->load->library('form_validation');
			$this->form_validation->set_rules('password', 'password', 'required', ['required' => '%s Harus di isi.']);
			$this->form_validation->set_rules(
				'username',
				'username',
				'required|min_length[4]|max_length[16]',
				[
					'required'   => '%s Harus di isi.',
					'min_length' => 'Panjang %s minimal harus 4 karakter.',
					'max_length' => 'Panjang %s maksimal 16 karakter.'
				]
			);

			if ($this->form_validation->run() == FALSE) {
				return $this->load->view('admin/login');
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
				$this->session->set_flashdata('success', "Selamat datang kembali $uname!");
				return redirect('adminpanel');
			}

			$this->session->set_flashdata('error', "Username atau Password Salah!");
		}

		return $this->load->view('admin/login');
	}

	public function logout()
	{
		$this->session->sess_destroy();
		return redirect('adminpanel');
	}
}
