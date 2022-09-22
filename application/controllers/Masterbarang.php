<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Masterbarang extends CI_Controller
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
		$data['kategori'] = $this->db->get_where('kategori', ['status_delete' => '0'])->result();

		$this->load->view('templates/header');
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('v_master/masterbarang', $data);
		$this->load->view('templates/footer');
	}





	// CRUD BARANG --------------------------------------------------------------------------------------- CRUD BARANG   
	public function no_barang_auto()
	{
		$quer = "SELECT max(right(kode_barang, 3)) AS kode FROM barang";
		$dt = $this->db->query($quer)->row_array();

		if ($dt) {
			$no = ((int)$dt['kode']) + 1;
			$kd = sprintf("%03s", $no);
		} else {
			$kd = "001";
		}
		date_default_timezone_set('Asia/Jakarta');
		$kode = 'BR-' . $kd;

		echo json_encode($kode);
	}

	public function add_barang_aksi()
	{
		$harga_beli = str_replace(".", "", $this->input->post('harga_beli'));
		$harga_jual = str_replace(".", "", $this->input->post('harga_jual'));

		$data = array(
			'id_kategori' => $this->input->post('id_kategori'),
			'kode_barang' => $this->input->post('kode_barang'),
			'nama_barang' => $this->input->post('nama_barang'),
			'harga_beli' => $harga_beli,
			'harga_jual' => $harga_jual,
			'stok' => $this->input->post('stok'),
		);
		$this->db->insert('barang', $data);

		$this->session->set_flashdata('pesan', '
        <div class="alert alert-success alert-dismissible" role="alert mb-3">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="alert-message">
                <strong>Berhasil!</strong> Menambah data barang.
            </div>
        </div>
        ');
		redirect('masterbarang');
	}

	public function getBarangById($id)
	{
		$q_barang = "SELECT barang.*, kategori.kategori FROM barang JOIN kategori ON barang.id_kategori = kategori.id WHERE barang.id = $id";
		$data = $this->db->query($q_barang)->row_array();

		echo json_encode($data);
	}

	public function edit_barang_aksi()
	{
		$id =  $this->input->post('edit_id');

		$edit_harga_beli = str_replace(".", "", $this->input->post('edit_harga_beli'));
		$edit_harga_jual = str_replace(".", "", $this->input->post('edit_harga_jual'));

		$data = array(
			'id_kategori' => $this->input->post('edit_id_kategori'),
			'kode_barang' => $this->input->post('edit_kode_barang'),
			'nama_barang' => $this->input->post('edit_nama_barang'),
			'harga_beli' => $edit_harga_beli,
			'harga_jual' => $edit_harga_jual,
		);

		$this->db->where('id', $id);
		$this->db->update('barang', $data);

		$this->session->set_flashdata('pesan', '
        <div class="alert alert-primary alert-dismissible" role="alert mb-3">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="alert-message">
                <strong>Berhasil!</strong> Edit data barang.
            </div>
        </div>
        ');
		redirect('masterbarang');
	}

	public function hapus_barang($id)
	{
		date_default_timezone_set('Asia/Jakarta');
		$barang = $this->db->get_where('barang', ['id' => $id])->row_array();

		$where = array('id' => $id);
		$dt = [
			'kode_barang' => 'deleted' . $barang['kode_barang'],
			'status_delete' => '1',
			'delete_at' => date('Y-m-d H:i:s'),
		];
		$this->db->where($where);
		$this->db->update('barang', $dt);

		$this->session->set_flashdata('pesan', '
        <div class="alert alert-danger alert-dismissible" role="alert mb-3">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="alert-message">
                <strong>Berhasil!</strong> Menghapus data barang.
            </div>
        </div>
        ');
		redirect('masterbarang');
	}
	// CRUD BARANG --------------------------------------------------------------------------------------- CRUD BARANG   
}
