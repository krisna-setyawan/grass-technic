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

        $data['barang'] = $this->db->get('barang')->result();

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('v_utama/lihatbarang', $data);
        $this->load->view('templates/footer');
    }





    public function getBarangById($id)
    {
        $where = array(
            'id' => $id
        );
        $data = $this->db->get_where('barang', $where)->row_array();

        echo json_encode($data);
    }
}
