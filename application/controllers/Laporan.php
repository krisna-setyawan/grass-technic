<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
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

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('v_laporan/laporan', $data);
        $this->load->view('templates/footer');
    }





    // LAPORAN PEMBELIAN
    public function laporan_pembelian()
    {
        $data_session_username = $this->session->userdata('username');
        $data['user_login'] = $this->db->get_where('user', ['username' => $data_session_username])->row_array();

        $data['profil_toko'] = $this->db->get_where('profil_toko', ['id' => 1])->row_array();

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('v_laporan/laporan_pembelian', $data);
        $this->load->view('templates/footer');
    }

    public function get_laporan_pembelian_bulanan()
    {
        // BUAT LIST TGL DALAM SEBULAN
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        if ($bulan == null) {
            date_default_timezone_set('Asia/Jakarta');
            $month = date('m');
        } else {
            $month = $bulan;
        }
        if ($tahun == null) {
            date_default_timezone_set('Asia/Jakarta');
            $year = date('Y');
        } else {
            $year = $tahun;
        }

        for ($d = 1; $d <= 31; $d++) {
            $time = mktime(12, 0, 0, $month, $d, $year);
            if (date('m', $time) == $month) {
                $tgl_list[] = date('d', $time);
            }
            if (date('m', $time) == $month) {
                $list[] = date('Y-m-d', $time);
            }
        }
        // BUAT LIST TGL DALAM SEBULAN


        $data['bulan'] = $month;
        $data['tahun'] = $year;
        $data['tgl'] = $tgl_list;

        $no = 1;
        // ---------------------------------------------------------------------------------- //
        foreach ($list as $tgl) {
            // CARI JUMLAH PEMBELIAN PER TGL FOREACH
            $q_jumlah = "SELECT COUNT(id) as jumlah_pembelian, SUM(grand_total) as grand_total FROM `pembelian` WHERE tanggal = '$tgl'";
            $jumlah = $this->db->query($q_jumlah)->row_array();

            echo '
            <tr class="text-center">
                <td>' . $no++ . '</td>
                <td>' . $tgl . '</td>';
            if ($jumlah['jumlah_pembelian'] != 0) {
                echo '<td> <b> ' . $jumlah['jumlah_pembelian'] . ' </b> </td>';
            } else {
                echo '<td> - </td>';
            }
            if ($jumlah['grand_total'] != null) {
                echo '<td> <b> Rp.' . number_format($jumlah['grand_total'], 0, ',', '.') . ' </b> </td>';
            } else {
                echo '<td> - </td>';
            }
            echo '
            </tr>
            ';
        }
        $q_jumlah_sebulan = "SELECT COUNT(id) as jumlah_pembelian, SUM(grand_total) as grand_total FROM `pembelian` WHERE month(tanggal) = '$month' AND year(tanggal) = '$year'";
        $jumlah_sebulan = $this->db->query($q_jumlah_sebulan)->row_array();
        echo '
        <tr class="text-center" style="font-size: larger;">
            <td colspan="2"><b>Total</b></td>
            <td><b> ' . $jumlah_sebulan['jumlah_pembelian'] . ' </b></td>
            <td><b> Rp. ' . number_format($jumlah_sebulan['grand_total'], 0, ',', '.') . ' </b></td>
        </tr>
        ';
    }





    // LAPORAN PEMBELIAN
    public function laporan_barang()
    {
        $data_session_username = $this->session->userdata('username');
        $data['user_login'] = $this->db->get_where('user', ['username' => $data_session_username])->row_array();

        $data['profil_toko'] = $this->db->get_where('profil_toko', ['id' => 1])->row_array();

        $data['banyak'] = $this->db->query('SELECT * FROM barang ORDER BY stok DESC LIMIT 5')->result();
        $data['sedikit'] = $this->db->query('SELECT * FROM barang ORDER BY stok ASC LIMIT 5')->result();

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('v_laporan/laporan_barang', $data);
        $this->load->view('templates/footer');
    }
}
