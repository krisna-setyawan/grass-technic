<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Masterjasa extends CI_Controller
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

		$data['jasa'] = $this->db->get('jasa')->result();

		$this->load->view('templates/header');
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('v_master/masterjasa', $data);
		$this->load->view('templates/footer');
	}





	// CRUD JASA --------------------------------------------------------------------------------------- CRUD JASA   
	public function add_jasa_aksi()
	{
		$tarif = str_replace(".", "", $this->input->post('tarif'));

		$data = array(
			'kode_jasa' => $this->input->post('kode_jasa'),
			'nama_jasa' => $this->input->post('nama_jasa'),
			'tarif' => $tarif,
		);
		$this->db->insert('jasa', $data);

		$this->session->set_flashdata('pesan', '
        <div class="alert alert-success alert-dismissible" role="alert mb-3">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="alert-message">
                <strong>Berhasil!</strong> Menambah data jasa.
            </div>
        </div>
        ');
		redirect('masterjasa');
	}

	public function getJasaById($id)
	{
		$where = array(
			'id' => $id
		);
		$data = $this->db->get_where('jasa', $where)->row_array();

		echo json_encode($data);
	}

	public function edit_jasa_aksi()
	{
		$id =  $this->input->post('edit_id');

		$edit_tarif = str_replace(".", "", $this->input->post('edit_tarif'));

		$data = array(
			'kode_jasa' => $this->input->post('edit_kode_jasa'),
			'nama_jasa' => $this->input->post('edit_nama_jasa'),
			'tarif' => $edit_tarif,
		);

		$this->db->where('id', $id);
		$this->db->update('jasa', $data);

		$this->session->set_flashdata('pesan', '
        <div class="alert alert-primary alert-dismissible" role="alert mb-3">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="alert-message">
                <strong>Berhasil!</strong> Edit data jasa.
            </div>
        </div>
        ');
		redirect('masterjasa');
	}

	public function hapus_jasa($id)
	{
		$where = array('id' => $id);
		$this->db->where($where);
		$this->db->delete('jasa');
		$this->session->set_flashdata('pesan', '
        <div class="alert alert-danger alert-dismissible" role="alert mb-3">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="alert-message">
                <strong>Berhasil!</strong> Menghapus data jasa.
            </div>
        </div>
        ');
		redirect('masterjasa');
	}
	// CRUD JASA --------------------------------------------------------------------------------------- CRUD JASA   
}
