<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdminPanel extends BaseController
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(['form', 'url']);
		$this->load->model("MAdmin", 'adminModel');
	}

	public function index()
	{
		if (empty($this->session->userdata('userName'))) {
			return redirect('admin/login');
		}
		$this->load->view('admin/layout/header');
		$this->load->view('admin/layout/menu');
		$this->load->view('admin/dashboard');
		$this->load->view('admin/layout/footer');
	}

	public function login()
	{
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
			if (!$this->form_validation->run()) return $this->load->view('admin/login');

			$uname = $this->input->post('username');
			$pass  = $this->input->post('password');

			$adminAuthData = $this->adminModel->cek_login($uname, $pass);
			if ($adminAuthData !== null && count($adminAuthData)) {
				$session = $adminAuthData;
				$this->session->set_userdata($session);
				$this->session->set_flashdata('success', "Selamat datang kembali $uname!");
				return redirect('admin');
			}

			$this->session->set_flashdata('error', "Username atau Password Salah!");
		}

		return $this->load->view('admin/login');
	}

	public function ganti_password()
	{
		if (empty($this->session->userdata('userName'))) return redirect('admin/login');

		if ($this->input->method() == "post") {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('password', 'password', 'required', ['required' => '%s harus di isi.']);
			$this->form_validation->set_rules('new_password', 'Password Baru', 'required', ['required' => '%s harus di isi.']);
			$this->form_validation->set_rules('retype_new_password', 'Ulangi Password Baru', 'required|matches[new_password]', [
				'required' => '%s harus di isi.',
				'matches' => "'%s' harus sama dengan 'Password Baru'."
			]);
			if (!$this->form_validation->run()) return $this->load->view('admin/ganti-password');

			$currentPassword = $this->input->post('password');
			$newPassword = $this->input->post('new_password');

			$adminData = $this->adminModel->get_admin_by_username($this->session->userdata('userName'));
			$currentPasswordValid = password_verify($currentPassword, $adminData->password);
			if ($currentPasswordValid) {
				$passhash = password_hash($newPassword, PASSWORD_DEFAULT);
				$updatedPassword = $this->adminModel->update('tbl_admin', [
					'password' => $passhash,
				], 'idAdmin', $adminData->idAdmin);

				if ($updatedPassword) {
					$this->session->set_flashdata('success', "Berhasil mengganti password");
					return redirect('admin');
				}

				$this->session->set_flashdata('error', "Gagal mengganti password!");
			} else {
				$this->session->set_flashdata('error', "Password yang anda masukan tidak sama dengan password akun anda saat ini!");
			}
		}

		return $this->load->view('admin/ganti-password');
	}

	public function logout()
	{
		$this->session->sess_destroy();
		return redirect('admin');
	}
}
