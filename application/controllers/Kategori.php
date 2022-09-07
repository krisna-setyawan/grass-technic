<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori extends CI_Controller
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

		$data['kategori'] = $this->db->get_where('kategori', ['status_delete' => '0'])->result();

		$this->load->view('templates/header');
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('v_master/kategori', $data);
		$this->load->view('templates/footer');
	}





	// CRUD KATEGORI --------------------------------------------------------------------------------------- CRUD KATEGORI   
	public function add_kategori_aksi()
	{
		$data = array(
			'kategori' => $this->input->post('nama'),
		);
		$this->db->insert('kategori', $data);

		$this->session->set_flashdata('pesan', '
        <div class="alert alert-success alert-dismissible" role="alert mb-3">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="alert-message">
                <strong>Berhasil!</strong> Menambah data kategori.
            </div>
        </div>
        ');
		redirect('kategori');
	}

	public function getKategoriById($id)
	{
		$where = array(
			'id' => $id
		);
		$data = $this->db->get_where('kategori', $where)->row_array();

		echo json_encode($data);
	}

	public function edit_kategori_aksi()
	{
		$id =  $this->input->post('edit_id');

		$data = array(
			'kategori' => $this->input->post('edit_nama'),
		);

		$this->db->where('id', $id);
		$this->db->update('kategori', $data);

		$this->session->set_flashdata('pesan', '
        <div class="alert alert-primary alert-dismissible" role="alert mb-3">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="alert-message">
                <strong>Berhasil!</strong> Edit data kategori.
            </div>
        </div>
        ');
		redirect('kategori');
	}

	public function hapus_kategori($id)
	{
		date_default_timezone_set('Asia/Jakarta');

		$where = array('id' => $id);
		$dt = [
			'status_delete' => '1',
			'delete_at' => date('Y-m-d H:i:s'),
		];
		$this->db->where($where);
		$this->db->update('kategori', $dt);

		$this->session->set_flashdata('pesan', '
        <div class="alert alert-danger alert-dismissible" role="alert mb-3">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="alert-message">
                <strong>Berhasil!</strong> Menghapus data kategori.
            </div>
        </div>
        ');
		redirect('kategori');
	}
	// CRUD KATEGORI --------------------------------------------------------------------------------------- CRUD KATEGORI   
}
