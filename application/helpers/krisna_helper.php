<?php

function is_logged_in()
{

	$ci = get_instance();

	if (!$ci->session->userdata('grass')) {
		redirect('auth');
	} else {
		$user_id = $ci->session->userdata('id_user');
		$menu = $ci->uri->segment(1);

		$queryMenu = $ci->db->get_where('user_menu', ['url' => $menu])->row_array();
		$menuId = $queryMenu['id'];

		$userAccess = $ci->db->get_where('user_access_menu', [
			'id_user' => $user_id,
			'id_menu' => $menuId
		]);

		if ($userAccess->num_rows() < 1) {
			redirect('auth/blocked');
		}
	}
}

function check_akses($id_menu, $id_user)
{
	$ci = get_instance();

	$ada = $ci->db->get_where('user_access_menu', ['id_user' => $id_user, 'id_menu' => $id_menu]);
	if ($ada->num_rows() > 0) {
		return "checked='checked'";
	}
}
