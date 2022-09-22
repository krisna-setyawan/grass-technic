<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lihatbarang extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		is_logged_in();
	}

	public function index()
	{
		$data_session_username = $this->session->userdata('username');
		$data['user_login'] = $this->db->get_where('user', ['username' => $data_session_username])->row_array();

		$data['profil_toko'] = $this->db->get_where('profil_toko', ['id' => 1])->row_array();

		$data['barang'] = $this->db->get_where('barang', ['status_delete' => '0'])->result();

		$this->load->view('templates/header');
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('v_utama/lihatbarang', $data);
		$this->load->view('templates/footer');
	}






	public function getBarangById($id)
	{
		$q_barang = "SELECT barang.*, kategori.kategori FROM barang JOIN kategori ON barang.id_kategori = kategori.id WHERE barang.id = $id";
		$data = $this->db->query($q_barang)->row_array();

		echo json_encode($data);
	}
}
