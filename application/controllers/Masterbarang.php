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

        $data['barang'] = $this->db->get('barang')->result();

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('v_master/masterbarang', $data);
        $this->load->view('templates/footer');
    }





    // CRUD BARANG --------------------------------------------------------------------------------------- CRUD BARANG   
    public function add_barang_aksi()
    {
        $harga_beli = str_replace(".", "", $this->input->post('harga_beli'));
        $harga_jual = str_replace(".", "", $this->input->post('harga_jual'));
        $hg_reseller1 = str_replace(".", "", $this->input->post('hg_reseller1'));
        $hg_reseller2 = str_replace(".", "", $this->input->post('hg_reseller2'));
        $hg_reseller3 = str_replace(".", "", $this->input->post('hg_reseller3'));
        $hg_reseller4 = str_replace(".", "", $this->input->post('hg_reseller4'));

        $data = array(
            'kode_barang' => $this->input->post('kode_barang'),
            'nama_barang' => $this->input->post('nama_barang'),
            'harga_beli' => $harga_beli,
            'harga_jual' => $harga_jual,
            'hg_reseller1' => $hg_reseller1,
            'hg_reseller2' => $hg_reseller2,
            'hg_reseller3' => $hg_reseller3,
            'hg_reseller4' => $hg_reseller4,
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
        $where = array(
            'id' => $id
        );
        $data = $this->db->get_where('barang', $where)->row_array();

        echo json_encode($data);
    }

    public function edit_barang_aksi()
    {
        $id =  $this->input->post('edit_id');

        $edit_harga_beli = str_replace(".", "", $this->input->post('edit_harga_beli'));
        $edit_harga_jual = str_replace(".", "", $this->input->post('edit_harga_jual'));
        $edit_hg_reseller1 = str_replace(".", "", $this->input->post('edit_hg_reseller1'));
        $edit_hg_reseller2 = str_replace(".", "", $this->input->post('edit_hg_reseller2'));
        $edit_hg_reseller3 = str_replace(".", "", $this->input->post('edit_hg_reseller3'));
        $edit_hg_reseller4 = str_replace(".", "", $this->input->post('edit_hg_reseller4'));

        $data = array(
            'kode_barang' => $this->input->post('edit_kode_barang'),
            'nama_barang' => $this->input->post('edit_nama_barang'),
            'harga_beli' => $edit_harga_beli,
            'harga_jual' => $edit_harga_jual,
            'hg_reseller1' => $edit_hg_reseller1,
            'hg_reseller2' => $edit_hg_reseller2,
            'hg_reseller3' => $edit_hg_reseller3,
            'hg_reseller4' => $edit_hg_reseller4,
            'stok' => $this->input->post('edit_stok'),
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
        $where = array('id' => $id);
        $this->db->where($where);
        $this->db->delete('barang');
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
