<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembelian extends CI_Controller
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
        $this->load->view('v_transaksi/pembelian', $data);
        $this->load->view('templates/footer');
    }





    // CRD PEMBELIAN ---------------------------------------------------------------------- CRD PEMBELIAN
    public function no_trx_auto()
    {
        $quer = "SELECT max(right(kode_transaksi, 2)) AS kode FROM no_pb_auto WHERE DATE(tanggal) = CURDATE()";
        $query = $this->db->query($quer)->row_array();

        if ($query) {
            $no = ((int)$query['kode']) + 1;
            $kd = sprintf("%02s", $no);
        } else {
            $kd = "01";
        }
        date_default_timezone_set('Asia/Jakarta');
        $kode = 'PB' . date('dmy') . $kd;

        echo json_encode($kode);
    }

    function get_data()
    {
        $list = $this->m_pembelian->get_datatables();
        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $ls) {
            $no++;
            $row = array();
            $row[] = $no . ".";
            $row[] = $ls->no_pembelian;
            $row[] = $ls->tanggal;
            $row[] = $ls->nama;
            $row[] = 'Rp. ' . number_format($ls->grand_total, 0, ',', '.');
            $row[] = $ls->status;
            // add html for action
            if ($ls->status == 'Proses') {
                $row[] = '
                        <a>
                            <button class="badge btn-warning text-dark" onclick="resume(' . $ls->id . ')"> Lanjutkan </button>
                        </a>
                        <a>
                            <button class="badge btn-danger" onclick="hapus(' . $ls->id . ')"> Hapus </button>
                        </a>
                    ';
            } else {
                $row[] = '
                        <a>
                            <button class="badge btn-info" onclick="detail(' . $ls->id . ')"> Detail </button>
                        </a>
                        <a>
                            <button class="badge btn-danger" onclick="hapus(' . $ls->id . ')"> Hapus </button>
                        </a>
                    ';
            }
            $data[] = $row;
        }
        $output = array(
            "draw" => @$_POST['draw'],
            "recordsTotal" => $this->m_pembelian->count_all(),
            "recordsFiltered" => $this->m_pembelian->count_filtered(),
            "data" => $data,
        );
        // output to json format
        echo json_encode($output);
    }

    public function add_pembelian_aksi()
    {
        $data = array(
            'no_pembelian' => $this->input->post('no_pembelian'),
            'id_suplier' => $this->input->post('id_suplier'),
            'tanggal' => $this->input->post('tanggal'),
        );
        $this->db->insert('pembelian', $data);
        $id_pembelian = $this->db->insert_id();

        $insert_no_pb_auto = [
            'id_pembelian' => $id_pembelian,
            'kode_transaksi' => $this->input->post('no_pembelian')
        ];
        $this->db->insert('no_pb_auto', $insert_no_pb_auto);

        redirect('pembelian/buat/' . $id_pembelian);
    }

    public function hapus_pembelian($id)
    {
        $where = array('id' => $id);
        $this->db->where($where);
        $this->db->delete('pembelian');
        $this->session->set_flashdata('pesan', '
        <div class="alert alert-danger alert-dismissible" role="alert mb-3">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="alert-message">
                <strong>Berhasil!</strong> Menghapus data pembelian.
            </div>
        </div>
        ');
        redirect('pembelian');
    }

    public function get_detail()
    {
        $id_pembelian = $this->input->post('id_pembelian');
        $q = "SELECT pembelian.*, suplier.nama as nama_suplier, suplier.alamat as alamat_suplier FROM pembelian JOIN suplier ON pembelian.id_suplier = suplier.id WHERE pembelian.id = '$id_pembelian'";
        $data = $this->db->query($q)->row_array();
        echo json_encode($data);
    }

    public function get_detail_list()
    {
        $id_pembelian = $this->input->post('id_pembelian');
        $list_pembelian = $this->db->get_where('pembelian_detail', ['id_pembelian' => $id_pembelian])->result();

        foreach ($list_pembelian as $ls) {
            echo '
            <tr>
                <td>' . $ls->nama_barang . '</td>
                <td class="text-center">' . $ls->jumlah . '</td>
                <td class="text-right">Rp.' . number_format($ls->hg_satuan, 0, ',', '.') . '</td>
                <td class="text-right">Rp.' . number_format($ls->hg_total, 0, ',', '.') . '</td>
            </tr>
            ';
        }
    }
    // CRD PEMBELIAN ---------------------------------------------------------------------- CRD PEMBELIAN





    // ADD LIST / DETAIL PEMBELIAN -------------------------------------------------------- ADD LIST / DETAIL PEMBELIAN
    public function buat($id_pembelian)
    {
        $data_session_username = $this->session->userdata('username');
        $data['user_login'] = $this->db->get_where('user', ['username' => $data_session_username])->row_array();

        $q = "SELECT pembelian.*, suplier.nama as nama_suplier, suplier.id as id_suplier FROM pembelian JOIN suplier ON pembelian.id_suplier = suplier.id WHERE pembelian.id = '$id_pembelian'";
        $data['pembelian'] = $this->db->query($q)->row_array();

        $data['profil_toko'] = $this->db->get_where('profil_toko', ['id' => 1])->row_array();

        // KONDISI JIKA DATA SUDAH DIHAPUS
        if (!$data['pembelian']) {
            redirect('pembelian');
        } else {
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('v_transaksi/pembelian_add', $data);
            $this->load->view('templates/footer');
        }
    }

    public function barang_autocomplete()
    {
        if (isset($_GET['term'])) {
            $keyword_brg = $_GET['term'];

            $this->db->like('nama_barang', $keyword_brg);
            $this->db->limit(10);
            $barangs = $this->db->get('barang')->result();

            if (count($barangs) > 0) {
                foreach ($barangs as $row) {
                    $arr_result[] = $row->nama_barang;
                }
                echo json_encode($arr_result);
            }
        }
    }

    public function get_barang_autocomplete()
    {
        $nm_brg = $this->input->post('nm_brg');

        $this->db->like('nama_barang', $nm_brg);
        $hasil = $this->db->get('barang')->row_array();

        if ($hasil) {
            $data = $hasil;
            $data['kodeku'] = 'ada';
        } else {
            $data = [
                'harga_jual' => '',
                'stok' => '',
                'kodeku' => 'tidak',
            ];
        }

        echo json_encode($data);
    }

    public function add_list()
    {
        $id_barang = $this->input->post('id_barang');
        $barang = $this->db->get_where('barang', ['id' => $id_barang])->row_array();

        $data_input = [
            'id_pembelian' => $this->input->post('id_pembelian'),
            'id_suplier' => $this->input->post('id_suplier'),
            'id_barang' => $this->input->post('id_barang'),
            'kode_barang' => $barang['kode_barang'],
            'nama_barang' => $barang['nama_barang'],
            'no_pembelian' => $this->input->post('no_pembelian'),
            'jumlah' => $this->input->post('jumlah'),
            'hg_satuan' => $this->input->post('hg_satuan'),
            'hg_total' => $this->input->post('hg_total'),
        ];
        $this->db->insert('pembelian_detail', $data_input);
    }

    public function load_data_pembelian()
    {
        $id_pembelian = $this->input->post('id_pembelian');
        $data_pembelian = $this->db->get_where('pembelian_detail', ['id_pembelian' => $id_pembelian])->result();

        $no = 1;
        foreach ($data_pembelian as $data) {
            echo '
            <tr>
                <td>' . $no++ . '</td>
                <td>' . $data->kode_barang . '</td>
                <td>' . $data->nama_barang . '</td>
                <td>' . $data->jumlah . '</td>
                <td>Rp. ' . number_format($data->hg_satuan, 0, ',', '.') . '</td>
                <td>Rp. ' . number_format($data->hg_total, 0, ',', '.') . '</td>
                <td class="text-center">
                    <button onclick="hapus_list(' . $data->id . ')" class="badge btn-danger">X</button>
                </td>
            </tr>
        ';
        }
    }

    public function load_grand_total()
    {
        $id_pembelian = $this->input->post('id_pembelian');
        $result_total = $this->db->query("SELECT sum(hg_total) as grand_total FROM pembelian_detail WHERE id_pembelian = '$id_pembelian'")->row_array();

        if ($result_total['grand_total']) {
            $data_total['grand_total'] = $result_total['grand_total'];
        } else {
            $data_total['grand_total'] = '0';
        }

        echo json_encode($data_total);
    }

    public function delete_list()
    {
        $id_detail = $this->input->post('id_detail');
        $this->db->where('id', $id_detail);
        $this->db->delete('pembelian_detail');
    }





    // SIMPAN PEMBELIAN
    public function validasi_simpan_beli()
    {
        $id_pembelian = $this->input->post('id_pembelian');
        $list_pembelian = $this->db->get_where('pembelian_detail', ['id_pembelian' => $id_pembelian])->result_array();
        if ($list_pembelian) {
            $data['kodeku'] = 'ada';
        } else {
            $data['kodeku'] = 'tidak';
        }
        echo json_encode($data);
    }

    public function simpan_pembelian()
    {
        $grand_total = $this->input->post('grand_total');
        $id_pembelian = $this->input->post('id_pembelian');

        $data_update = [
            'grand_total' => $grand_total,
            'status' => 'Selesai',
        ];

        $this->db->where('id', $id_pembelian);
        $this->db->update('pembelian', $data_update);
    }
}
