<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends CI_Controller
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

        $data['pelanggan'] = $this->db->get('pelanggan')->result();
        $data['reseller'] = $this->db->get('reseller')->result();

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('v_transaksi/penjualan', $data);
        $this->load->view('templates/footer');
    }





    // CRD PENJUALAN ---------------------------------------------------------------------- CRD PENJUALAN
    public function no_trx_auto()
    {
        $quer = "SELECT max(right(kode_transaksi, 3)) AS kode FROM no_pj_auto WHERE DATE(tanggal) = CURDATE()";
        $query = $this->db->query($quer)->row_array();

        if ($query) {
            $no = ((int)$query['kode']) + 1;
            $kd = sprintf("%03s", $no);
        } else {
            $kd = "001";
        }
        date_default_timezone_set('Asia/Jakarta');
        $kode = date('dmy') . $kd;

        echo json_encode($kode);
    }

    function get_data()
    {
        $list = $this->m_penjualan->get_datatables();
        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $ls) {
            $no++;
            $row = array();
            $row[] = $no . ".";
            $row[] = $ls->no_penjualan;
            $row[] = $ls->tanggal;
            $row[] = $ls->jenis_penjualan;
            $row[] = $ls->nama_pembeli;
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
            "recordsTotal" => $this->m_penjualan->count_all(),
            "recordsFiltered" => $this->m_penjualan->count_filtered(),
            "data" => $data,
        );
        // output to json format
        echo json_encode($output);
    }

    public function get_pelanggan()
    {
        $id_pelanggan = $this->input->post('id_pelanggan');
        $pelanggan = $this->db->get_where('pelanggan', ['id' => $id_pelanggan])->row_array();
        echo json_encode($pelanggan);
    }

    public function get_reseller()
    {
        $id_reseller = $this->input->post('id_reseller');
        $reseller = $this->db->get_where('reseller', ['id' => $id_reseller])->row_array();
        echo json_encode($reseller);
    }

    public function add_penjualan_aksi()
    {
        $data = array(
            'no_penjualan' => $this->input->post('no_penjualan'),
            'jenis_penjualan' => $this->input->post('jenis_penjualan'),
            'id_pelanggan' => $this->input->post('id_pelanggan'),
            'id_reseller' => $this->input->post('id_reseller'),
            'nama_pembeli' => $this->input->post('nama_pembeli'),
            'alamat_pembeli' => $this->input->post('alamat_pembeli'),
            'no_telp_pembeli' => $this->input->post('no_telp_pembeli'),
            'kelas_reseller' => $this->input->post('kelas_reseller'),
            'tanggal' => $this->input->post('tanggal'),
        );
        $this->db->insert('penjualan', $data);
        $id_penjualan = $this->db->insert_id();

        $insert_no_pj_auto = [
            'id_penjualan' => $id_penjualan,
            'kode_transaksi' => $this->input->post('no_penjualan')
        ];
        $this->db->insert('no_pj_auto', $insert_no_pj_auto);

        redirect('penjualan/buat/' . $id_penjualan);
    }

    public function hapus_penjualan($id)
    {
        $where = array('id' => $id);
        $this->db->where($where);
        $this->db->delete('penjualan');
        $this->session->set_flashdata('pesan', '
        <div class="alert alert-danger alert-dismissible" role="alert mb-3">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="alert-message">
                <strong>Berhasil!</strong> Menghapus data penjualan.
            </div>
        </div>
        ');
        redirect('penjualan');
    }

    public function get_detail()
    {
        $id_penjualan = $this->input->post('id_penjualan');
        $data = $this->db->get_where('penjualan', ['id' => $id_penjualan])->row_array();
        echo json_encode($data);
    }

    public function get_detail_list()
    {
        $id_penjualan = $this->input->post('id_penjualan');
        $list_penjualan = $this->db->get_where('penjualan_detail', ['id_penjualan' => $id_penjualan])->result();

        foreach ($list_penjualan as $ls) {
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
    // CRD PENJUALAN ---------------------------------------------------------------------- CRD PENJUALAN





    // ADD LIST / DETAIL PENJUALAN -------------------------------------------------------- ADD LIST / DETAIL PENJUALAN
    public function buat($id_penjualan)
    {
        $data_session_username = $this->session->userdata('username');
        $data['user_login'] = $this->db->get_where('user', ['username' => $data_session_username])->row_array();

        $data['penjualan'] = $this->db->get_where('penjualan', ['id' => $id_penjualan])->row_array();

        $data['profil_toko'] = $this->db->get_where('profil_toko', ['id' => 1])->row_array();

        $data['penjualan']['hg_reseller'] = $this->kode_hg_reseller($data['penjualan']['kelas_reseller']);

        // KONDISI JIKA DATA SUDAH DIHAPUS
        if (!$data['penjualan']) {
            redirect('penjualan');
        } else {
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('v_transaksi/penjualan_add', $data);
            $this->load->view('templates/footer');
        }
    }

    public function kode_hg_reseller($kelas_reseller)
    {
        if ($kelas_reseller == 'Kelas 1') {
            $hg_reseller = 'hg_reseller1';
        } else if ($kelas_reseller == 'Kelas 2') {
            $hg_reseller = 'hg_reseller2';
        } else if ($kelas_reseller == 'Kelas 3') {
            $hg_reseller = 'hg_reseller3';
        } else if ($kelas_reseller == 'Kelas 4') {
            $hg_reseller = 'hg_reseller4';
        } else {
            $hg_reseller = '0';
        }
        return $hg_reseller;
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
                'hg_reseller1' => '',
                'hg_reseller2' => '',
                'hg_reseller3' => '',
                'hg_reseller4' => '',
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

        $qty = $this->input->post('jumlah');
        $hg_jual = $this->input->post('hg_satuan');
        $hg_beli = $barang['harga_beli'];
        $hg_total_beli = $hg_beli * $qty;
        $laba_satuan = $hg_jual - $hg_beli;
        $laba_total = $laba_satuan * $qty;

        $data_input = [
            'id_penjualan' => $this->input->post('id_penjualan'),
            'id_barang' => $this->input->post('id_barang'),
            'no_penjualan' => $this->input->post('no_penjualan'),
            'kode_barang' => $barang['kode_barang'],
            'nama_barang' => $barang['nama_barang'],
            'jumlah' => $this->input->post('jumlah'),
            'hg_beli' => $barang['harga_beli'],
            'hg_total_beli' => $hg_total_beli,
            'hg_satuan' => $this->input->post('hg_satuan'),
            'hg_total' => $this->input->post('hg_total'),
            'laba_total' => $laba_total,
        ];
        $this->db->insert('penjualan_detail', $data_input);
    }

    public function load_data_penjualan()
    {
        $id_penjualan = $this->input->post('id_penjualan');
        $data_penjualan = $this->db->get_where('penjualan_detail', ['id_penjualan' => $id_penjualan])->result();

        $no = 1;
        foreach ($data_penjualan as $data) {
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
        $id_penjualan = $this->input->post('id_penjualan');
        $result_total = $this->db->query("SELECT sum(hg_total) as grand_total, sum(laba_total) as grand_laba, sum(hg_total_beli) as grand_beli FROM penjualan_detail WHERE id_penjualan = '$id_penjualan'")->row_array();

        if ($result_total['grand_total']) {
            $data_total['grand_total'] = $result_total['grand_total'];
            $data_total['grand_laba'] = $result_total['grand_laba'];
            $data_total['grand_beli'] = $result_total['grand_beli'];
        } else {
            $data_total['grand_total'] = '0';
            $data_total['grand_laba'] = '0';
            $data_total['grand_beli'] = '0';
        }

        echo json_encode($data_total);
    }

    public function delete_list()
    {
        $id_detail = $this->input->post('id_detail');
        $this->db->where('id', $id_detail);
        $this->db->delete('penjualan_detail');
    }





    // SIMPAN PENJUALAN
    public function validasi_simpan_jual()
    {
        $id_penjualan = $this->input->post('id_penjualan');
        $list_penjualan = $this->db->get_where('penjualan_detail', ['id_penjualan' => $id_penjualan])->result_array();
        if ($list_penjualan) {
            $data['kodeku'] = 'ada';
        } else {
            $data['kodeku'] = 'tidak';
        }
        echo json_encode($data);
    }

    public function simpan_penjualan()
    {
        $id_penjualan = $this->input->post('id_penjualan');
        $grand_beli = $this->input->post('grand_beli');
        $grand_total = $this->input->post('grand_total');
        $grand_laba = $this->input->post('grand_laba');
        $jumlah_bayar = $this->input->post('jumlah_bayar');
        $jumlah_kembalian = $this->input->post('jumlah_kembalian');

        $data_update = [
            'grand_beli' => $grand_beli,
            'grand_total' => $grand_total,
            'grand_laba' => $grand_laba,
            'jumlah_bayar' => $jumlah_bayar,
            'jumlah_kembalian' => $jumlah_kembalian,
            'status' => 'Selesai',
        ];

        $this->db->where('id', $id_penjualan);
        $this->db->update('penjualan', $data_update);
    }
}
