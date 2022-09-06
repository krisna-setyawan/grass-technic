<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

	public function index()
	{
		$data['profil_toko'] = $this->db->get_where('profil_toko', ['id' => 1])->row_array();
		if ($this->session->userdata('grass')) {
			redirect('dashboard');
		}

		$this->form_validation->set_rules('username', 'username', 'required|trim', [
			'required' => 'Username Belum Diisi!',
		]);
		$this->form_validation->set_rules('password', 'Password', 'required|trim', [
			'required' => 'Password Belum Diisi!',
		]);

		if ($this->form_validation->run() == false) {
			$this->load->view('templates/auth_header');
			$this->load->view('auth/login', $data);
			$this->load->view('templates/auth_footer');
		} else {
			$this->_login();
		}
	}

	private function _login()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$user = $this->db->get_where('user', ['username' => $username])->row_array();

		//jika username ada
		if ($user) {
			//cek password
			if ($password == $user['password']) {
				$data = [
					'username' => $user['username'],
					'nama_user' => $user['nama_user'],
					'id_user' => $user['id'],
					'grass' => 'ok'
				];
				$this->session->set_userdata($data);
				redirect('dashboard');
			} else {
				$this->session->set_flashdata('Pesan', '
                <center>
					<div class="alert alert-danger alert-dismissible" role="alert mb-3">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<div class="alert-message">
							<strong>Maaf!</strong> Password Salah!
						</div>
					</div>
                </center>');
				redirect('auth');
			}
		} else {
			$this->session->set_flashdata('Pesan', '
            <center>
				<div class="alert alert-danger alert-dismissible" role="alert mb-3">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="alert-message">
						<strong>Maaf!</strong> Username tidak ditemukan!
					</div>
				</div>
            </center>');
			redirect('auth');
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('grass');

		redirect('auth');
	}


	public function blocked()
	{
		$this->load->view('auth/blocked');
	}
}
