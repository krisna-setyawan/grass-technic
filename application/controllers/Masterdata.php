<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Masterdata extends CI_Controller
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

		$id_user = $this->session->userdata('id_user');
		$queryMenu = "  SELECT user_menu.*
                    FROM user_menu JOIN user_access_menu 
                    ON user_menu.id = user_access_menu.id_menu
                    WHERE user_access_menu.id_user = $id_user AND user_menu.sidebar = 'no' AND user_menu.datamaster = 'yes'
                    ORDER BY user_access_menu.id_menu ASC
                ";
		$data['menu_master'] = $this->db->query($queryMenu)->result_array();

		$this->load->view('templates/header');
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('v_master/masterdata', $data);
		$this->load->view('templates/footer');
	}
}
