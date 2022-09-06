<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengaturan extends CI_Controller
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

        $data['user'] = $this->db->get('user')->result();

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('v_pengaturan/pengaturan', $data);
        $this->load->view('templates/footer');
    }





    public function edit_profil()
    {
        $upload_file = $_FILES['logo']['name'];

        $nama = $this->input->post('nama');
        $keterangan = $this->input->post('keterangan');
        $telepon = $this->input->post('telepon');
        $alamat = $this->input->post('alamat');

        if ($upload_file) {
            $config['upload_path'] = "./assets/logo";
            $config['allowed_types'] = 'gif|jpg|png';
            $config['encrypt_name'] = TRUE;
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('logo')) {

                $data = array(
                    'nama' => $nama,
                    'keterangan' => $keterangan,
                    'telepon' => $telepon,
                    'alamat' => $alamat,
                    'logo' => $this->upload->data('file_name'),
                );
                $this->db->where('id', 1);
                $this->db->update('profil_toko', $data);

                $this->session->set_flashdata('pesan', '
                <div class="alert alert-primary alert-dismissible" role="alert mb-3">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="alert-message">
                        <strong>Berhasil!</strong> Edit data profil Toko.
                    </div>
                </div>
                ');
                redirect('pengaturan');
            } else {
                echo $this->upload->display_errors();
            }
        } else {
            $data = array(
                'nama' => $nama,
                'keterangan' => $keterangan,
                'telepon' => $telepon,
                'alamat' => $alamat,
            );
            $this->db->where('id', 1);
            $this->db->update('profil_toko', $data);

            $this->session->set_flashdata('pesan', '
        <div class="alert alert-primary alert-dismissible" role="alert mb-3">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="alert-message">
                <strong>Berhasil!</strong> Edit data profil Toko.
            </div>
        </div>
        ');
            redirect('pengaturan');
        }
    }





    // CRUD USER --------------------------------------------------------------------------------------- CRUD USER   
    public function add_user_aksi()
    {
        $data = array(
            'nama_user' => $this->input->post('nama_user'),
            'username' => $this->input->post('username'),
            'password' => $this->input->post('password'),
        );
        $this->db->insert('user', $data);

        $this->session->set_flashdata('pesan', '
        <div class="alert alert-success alert-dismissible" role="alert mb-3">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="alert-message">
                <strong>Berhasil!</strong> Menambah data user.
            </div>
        </div>
        ');
        redirect('pengaturan');
    }

    public function edit_user($id)
    {
        $where = array(
            'id' => $id
        );
        $data = $this->db->get_where('user', $where)->row_array();

        echo json_encode($data);
    }

    public function edit_user_aksi()
    {
        $id =  $this->input->post('edit_id');

        $data = array(
            'nama_user' => $this->input->post('edit_nama_user'),
            'username' => $this->input->post('edit_username'),
            'password' => $this->input->post('edit_password'),
        );

        $this->db->where('id', $id);
        $this->db->update('user', $data);

        $this->session->set_flashdata('pesan', '
        <div class="alert alert-primary alert-dismissible" role="alert mb-3">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="alert-message">
                <strong>Berhasil!</strong> Edit data user.
            </div>
        </div>
        ');
        redirect('pengaturan');
    }

    public function hapus_user($id)
    {
        $where = array('id' => $id);
        $this->db->where($where);
        $this->db->delete('user');
        $this->session->set_flashdata('pesan', '
        <div class="alert alert-danger alert-dismissible" role="alert mb-3">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="alert-message">
                <strong>Berhasil!</strong> Menghapus data user.
            </div>
        </div>
        ');
        redirect('pengaturan');
    }
    // CRUD USER --------------------------------------------------------------------------------------- CRUD USER   






    // MENU USER --------------------------------------------------------------------------------------- MENU USER
    public function get_hak_menu()
    {
        $id_user = $this->input->post('id_user');
        $user_menu = $this->db->get('user_menu')->result();

        $user = $this->db->get_where('user', ['id' => $id_user])->row_array();

        $no = 1;
        foreach ($user_menu as $um) {
            echo "
        <tr>
            <td>" . $no++ . "</td>
            <td>$um->judul</td>
            <td class='text-center'>
                <div class='custom-control custom-checkbox'>
                    <input onclick='beri_menu($um->id, $id_user)' type='checkbox' " . check_akses($um->id, $id_user) . ">
                </div>
            </td>
        </tr>
        ";
        }
    }

    public function beri_hak_menu()
    {
        $id_menu = $this->input->post('id_menu');
        $id_user = $this->input->post('id_user');

        $query = "SELECT * FROM user_access_menu WHERE id_user = $id_user AND id_menu = $id_menu";

        $ada = $this->db->query($query);

        if ($ada->num_rows() < 1) {
            $dtinsert = [
                'id_menu' => $id_menu,
                'id_user' => $id_user,
            ];
            $this->db->insert('user_access_menu', $dtinsert);
        } else {
            $where = array(
                'id_user' => $id_user,
                'id_menu' => $id_menu,
            );
            $this->db->delete('user_access_menu', $where);
        }
    }
    // MENU USER --------------------------------------------------------------------------------------- MENU USER
}
