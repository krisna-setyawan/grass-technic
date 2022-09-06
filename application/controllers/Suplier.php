<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Suplier extends CI_Controller
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

        $data['suplier'] = $this->db->get('suplier')->result();

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('v_master/suplier', $data);
        $this->load->view('templates/footer');
    }





    // CRUD SUPLIER --------------------------------------------------------------------------------------- CRUD SUPLIER   
    public function add_suplier_aksi()
    {
        $data = array(
            'nama' => $this->input->post('nama'),
            'alamat' => $this->input->post('alamat'),
            'no_telp' => $this->input->post('no_telp'),
        );
        $this->db->insert('suplier', $data);

        $this->session->set_flashdata('pesan', '
        <div class="alert alert-success alert-dismissible" role="alert mb-3">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="alert-message">
                <strong>Berhasil!</strong> Menambah data suplier.
            </div>
        </div>
        ');
        redirect('suplier');
    }

    public function getSuplierById($id)
    {
        $where = array(
            'id' => $id
        );
        $data = $this->db->get_where('suplier', $where)->row_array();

        echo json_encode($data);
    }

    public function edit_suplier_aksi()
    {
        $id =  $this->input->post('edit_id');

        $data = array(
            'nama' => $this->input->post('edit_nama'),
            'alamat' => $this->input->post('edit_alamat'),
            'no_telp' => $this->input->post('edit_no_telp'),
        );

        $this->db->where('id', $id);
        $this->db->update('suplier', $data);

        $this->session->set_flashdata('pesan', '
        <div class="alert alert-primary alert-dismissible" role="alert mb-3">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="alert-message">
                <strong>Berhasil!</strong> Edit data suplier.
            </div>
        </div>
        ');
        redirect('suplier');
    }

    public function hapus_suplier($id)
    {
        $where = array('id' => $id);
        $this->db->where($where);
        $this->db->delete('suplier');
        $this->session->set_flashdata('pesan', '
        <div class="alert alert-danger alert-dismissible" role="alert mb-3">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="alert-message">
                <strong>Berhasil!</strong> Menghapus data suplier.
            </div>
        </div>
        ');
        redirect('suplier');
    }
    // CRUD SUPLIER --------------------------------------------------------------------------------------- CRUD SUPLIER   
}
