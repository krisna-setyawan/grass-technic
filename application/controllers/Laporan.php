<?php
defined('BASEPATH') or exit('No direct script access allowed');

require('./application/third_party/excel/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
				echo '<td> </td>';
			}
			if ($jumlah['grand_total'] != null) {
				echo '<td> <b> Rp.' . number_format($jumlah['grand_total'], 0, ',', '.') . ' </b> </td>';
			} else {
				echo '<td> </td>';
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

	public function get_laporan_pembelian_custom()
	{
		// BUAT LIST TGL DALAM SEBULAN
		$tgl_awal = $this->input->post('tgl_awal');
		$tgl_akhir = $this->input->post('tgl_akhir');

		$begin = new DateTime($tgl_awal);
		$end = new DateTime($tgl_akhir);


		$jumlah_hari = $end->diff($begin)->format("%a");
		if ($tgl_akhir < $tgl_awal) {
			echo '
			<tr class="text-center">
				<td colspan="4" class="text-center">Tanggal awal lebih besar dari tanggal akhir.</td>
			</tr>';
		} else if ($jumlah_hari > 31) {
			echo '
            <tr class="text-center">
				<td colspan="4" class="text-center">Maksimal jumlah hari yang bisa ditampilkan adalah 31 hari</td>
			</tr>';
		} else {
			$no = 1;
			// ---------------------------------------------------------------------------------- //
			for ($dt = $begin; $dt <= $end; $dt->modify('+1 day')) {
				$tgl = $dt->format('Y-m-d');

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
					echo '<td> </td>';
				}
				if ($jumlah['grand_total'] != null) {
					echo '<td> <b> Rp.' . number_format($jumlah['grand_total'], 0, ',', '.') . ' </b> </td>';
				} else {
					echo '<td> </td>';
				}
				echo '
            </tr>
            ';
			}


			$q_jumlah_sebulan = "SELECT COUNT(id) as jumlah_pembelian, SUM(grand_total) as grand_total FROM `pembelian` WHERE tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'";
			$jumlah_sebulan = $this->db->query($q_jumlah_sebulan)->row_array();
			echo '
			<tr class="text-center" style="font-size: larger;">
				<td colspan="2"><b>Total</b></td>
				<td><b> ' . $jumlah_sebulan['jumlah_pembelian'] . ' </b></td>
				<td><b> Rp. ' . number_format($jumlah_sebulan['grand_total'], 0, ',', '.') . ' </b></td>
			</tr>
			';
		}
	}


	public function excel_bulanan_pembelian($bulan = null, $tahun = null)
	{
		// BUAT LIST TGL DALAM SEBULAN
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

		$spreadsheet = new Spreadsheet;

		$a = $spreadsheet->getActiveSheet();

		$a->mergeCells('A1:D1');
		$a->setCellValue('A1', 'Laporan Pembelian Bulan ' . $month . ' Tahun ' . $year);
		$a->getStyle('A1')->applyFromArray(
			array(
				'font' => array(
					'size' => 20,
					'bold' => true
				)
			)
		);

		$a->getStyle('A1')->getAlignment()->setHorizontal('center');

		$a->getStyle('A3:D3')->applyFromArray(
			array(
				'font' => array(
					'bold' => true
				),
				'borders' => array(
					'allBorders' => array(
						'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					)
				)
			)
		);

		$a->setCellValue('A3', 'No');
		$a->setCellValue('B3', 'Tanggal');
		$a->setCellValue('C3', 'Jumlah Pembelian');
		$a->setCellValue('D3', 'Jumlah Nominal Pembelian');

		$a->getColumnDimension('A')->setWidth(5);
		$a->getColumnDimension('B')->setWidth(20);
		$a->getColumnDimension('C')->setWidth(40);
		$a->getColumnDimension('D')->setWidth(40);


		$baris = 4;
		$no = 1;
		foreach ($list as $tgl) {
			// CARI JUMLAH PEMBELIAN PER TGL FOREACH
			$q_jumlah = "SELECT COUNT(id) as jumlah_pembelian, SUM(grand_total) as grand_total FROM `pembelian` WHERE tanggal = '$tgl'";
			$jumlah = $this->db->query($q_jumlah)->row_array();

			$a->setCellValue('A' . $baris, $no);
			$a->setCellValue('B' . $baris, $tgl);

			if ($jumlah['jumlah_pembelian'] != 0) {
				$a->setCellValue('C' . $baris, $jumlah['jumlah_pembelian']);
			} else {
				$a->setCellValue('C' . $baris, '');
			}

			if ($jumlah['grand_total'] != null) {
				$a->setCellValue('D' . $baris, 'Rp. ' . number_format($jumlah['grand_total'], 0, ',', '.'));
			} else {
				$a->setCellValue('D' . $baris, '');
			}

			$baris++;
			$no++;
		}


		$writer = new Xlsx($spreadsheet);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Laporan Pembelian ' . $month . '-' . $year . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}


	public function excel_custom_pembelian($tgl_awal = null, $tgl_akhir = null)
	{
		$begin = new DateTime($tgl_awal);
		$end = new DateTime($tgl_akhir);

		$spreadsheet = new Spreadsheet;

		$a = $spreadsheet->getActiveSheet();

		$a->mergeCells('A1:D1');
		$a->setCellValue('A1', 'Laporan Pembelian tgl ' . $tgl_awal . ' sampai ' . $tgl_akhir);
		$a->getStyle('A1')->applyFromArray(
			array(
				'font' => array(
					'size' => 20,
					'bold' => true
				)
			)
		);

		$a->getStyle('A1')->getAlignment()->setHorizontal('center');

		$a->getStyle('A3:D3')->applyFromArray(
			array(
				'font' => array(
					'bold' => true
				),
				'borders' => array(
					'allBorders' => array(
						'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					)
				)
			)
		);

		$a->setCellValue('A3', 'No');
		$a->setCellValue('B3', 'Tanggal');
		$a->setCellValue('C3', 'Jumlah Pembelian');
		$a->setCellValue('D3', 'Jumlah Nominal Pembelian');

		$a->getColumnDimension('A')->setWidth(5);
		$a->getColumnDimension('B')->setWidth(20);
		$a->getColumnDimension('C')->setWidth(40);
		$a->getColumnDimension('D')->setWidth(40);


		$baris = 4;
		$no = 1;
		// ---------------------------------------------------------------------------------- //
		for ($dt = $begin; $dt <= $end; $dt->modify('+1 day')) {
			$tgl = $dt->format('Y-m-d');

			// CARI JUMLAH PEMBELIAN PER TGL FOREACH
			$q_jumlah = "SELECT COUNT(id) as jumlah_pembelian, SUM(grand_total) as grand_total FROM `pembelian` WHERE tanggal = '$tgl'";
			$jumlah = $this->db->query($q_jumlah)->row_array();

			$a->setCellValue('A' . $baris, $no);
			$a->setCellValue('B' . $baris, $tgl);

			if ($jumlah['jumlah_pembelian'] != 0) {
				$a->setCellValue('C' . $baris, $jumlah['jumlah_pembelian']);
			} else {
				$a->setCellValue('C' . $baris, '');
			}

			if ($jumlah['grand_total'] != null) {
				$a->setCellValue('D' . $baris, 'Rp. ' . number_format($jumlah['grand_total'], 0, ',', '.'));
			} else {
				$a->setCellValue('D' . $baris, '');
			}

			$baris++;
			$no++;
		}


		$writer = new Xlsx($spreadsheet);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Laporan Pembelian ' . $tgl_awal . ' sampai ' . $tgl_akhir . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}





	// LAPORAN PENJUALAN
	public function laporan_penjualan()
	{
		$data_session_username = $this->session->userdata('username');
		$data['user_login'] = $this->db->get_where('user', ['username' => $data_session_username])->row_array();

		$data['profil_toko'] = $this->db->get_where('profil_toko', ['id' => 1])->row_array();

		$this->load->view('templates/header');
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('v_laporan/laporan_penjualan', $data);
		$this->load->view('templates/footer');
	}

	public function get_laporan_penjualan_bulanan()
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
			// CARI JUMLAH PENJUALAN PER TGL FOREACH
			$q_jumlah = "SELECT COUNT(id) as jumlah_penjualan, COUNT(NULLIF(grand_tarif_jasa,0)) as jumlah_jasa, 
						SUM(grand_total) as grand_total, SUM(grand_tarif_jasa) as grand_total_jasa, SUM(grand_total_barang) as grand_total_barang,  
						SUM(diskon) as diskon FROM `penjualan` WHERE tanggal = '$tgl'";
			$jumlah = $this->db->query($q_jumlah)->row_array();
			$jumlah_non_jasa = $jumlah['jumlah_penjualan'] - $jumlah['jumlah_jasa'];

			echo '
            <tr class="text-center">
                <td>' . $no++ . '</td>
                <td>' . $tgl . '</td>';

			if ($jumlah['jumlah_jasa'] != 0) {
				echo '<td> <b> ' . $jumlah['jumlah_jasa'] . ' </b> </td>';
			} else {
				echo '<td> </td>';
			}
			if ($jumlah_non_jasa != 0) {
				echo '<td> <b> ' . $jumlah_non_jasa . ' </b> </td>';
			} else {
				echo '<td> </td>';
			}
			if ($jumlah['jumlah_penjualan'] != 0) {
				echo '<td> <b> ' . $jumlah['jumlah_penjualan'] . ' </b> </td>';
			} else {
				echo '<td> </td>';
			}
			if ($jumlah['grand_total_jasa'] != null) {
				echo '<td> <b> Rp.' . number_format($jumlah['grand_total_jasa'], 0, ',', '.') . ' </b> </td>';
			} else {
				echo '<td> </td>';
			}
			if ($jumlah['grand_total_barang'] != null) {
				echo '<td> <b> Rp.' . number_format($jumlah['grand_total_barang'], 0, ',', '.') . ' </b> </td>';
			} else {
				echo '<td> </td>';
			}
			if ($jumlah['diskon'] != null) {
				echo '<td> <b> Rp.' . number_format($jumlah['diskon'], 0, ',', '.') . ' </b> </td>';
			} else {
				echo '<td> </td>';
			}
			if ($jumlah['grand_total'] != null) {
				echo '<td> <b> Rp.' . number_format($jumlah['grand_total'], 0, ',', '.') . ' </b> </td>';
			} else {
				echo '<td> </td>';
			}
			echo '
            </tr>
            ';
		}
		$q_jumlah_sebulan = "SELECT COUNT(id) as jumlah_penjualan, COUNT(NULLIF(grand_tarif_jasa,0)) as jumlah_jasa, 
							SUM(grand_total) as grand_total, SUM(grand_tarif_jasa) as grand_total_jasa, 
							SUM(grand_total_barang) as grand_total_barang, SUM(diskon) as diskon FROM `penjualan` 
							WHERE month(tanggal) = '$month' AND year(tanggal) = '$year'";
		$jumlah_sebulan = $this->db->query($q_jumlah_sebulan)->row_array();
		$jumlah_non_jasa_sebulan = $jumlah_sebulan['jumlah_penjualan'] - $jumlah_sebulan['jumlah_jasa'];

		echo '
        <tr class="text-center" style="font-size: larger;">
            <td colspan="2"><b>Total</b></td>
            <td><b> ' . $jumlah_sebulan['jumlah_jasa'] . ' </b></td>
            <td><b> ' . $jumlah_non_jasa_sebulan . ' </b></td>
            <td><b> ' . $jumlah_sebulan['jumlah_penjualan'] . ' </b></td>
            <td><b> Rp. ' . number_format($jumlah_sebulan['grand_total_jasa'], 0, ',', '.') . ' </b></td>
            <td><b> Rp. ' . number_format($jumlah_sebulan['grand_total_barang'], 0, ',', '.') . ' </b></td>
            <td><b> Rp. ' . number_format($jumlah_sebulan['diskon'], 0, ',', '.') . ' </b></td>
            <td><b> Rp. ' . number_format($jumlah_sebulan['grand_total'], 0, ',', '.') . ' </b></td>
        </tr>
        ';
	}

	public function get_laporan_penjualan_custom()
	{
		// BUAT LIST TGL DALAM SEBULAN
		$tgl_awal = $this->input->post('tgl_awal');
		$tgl_akhir = $this->input->post('tgl_akhir');

		$begin = new DateTime($tgl_awal);
		$end = new DateTime($tgl_akhir);


		$jumlah_hari = $end->diff($begin)->format("%a");
		if ($tgl_akhir < $tgl_awal) {
			echo '
			<tr class="text-center">
				<td colspan="4" class="text-center">Tanggal awal lebih besar dari tanggal akhir.</td>
			</tr>';
		} else if ($jumlah_hari > 31) {
			echo '
            <tr class="text-center">
				<td colspan="4" class="text-center">Maksimal jumlah hari yang bisa ditampilkan adalah 31 hari</td>
			</tr>';
		} else {
			$no = 1;
			// ---------------------------------------------------------------------------------- //
			for ($dt = $begin; $dt <= $end; $dt->modify('+1 day')) {
				$tgl = $dt->format('Y-m-d');

				// CARI JUMLAH PENJUALAN PER TGL FOREACH
				$q_jumlah = "SELECT COUNT(id) as jumlah_penjualan, COUNT(NULLIF(grand_tarif_jasa,0)) as jumlah_jasa, 
						SUM(grand_total) as grand_total, SUM(grand_tarif_jasa) as grand_total_jasa, SUM(grand_total_barang) as grand_total_barang,  
						SUM(diskon) as diskon FROM `penjualan` WHERE tanggal = '$tgl'";
				$jumlah = $this->db->query($q_jumlah)->row_array();
				$jumlah_non_jasa = $jumlah['jumlah_penjualan'] - $jumlah['jumlah_jasa'];

				echo '
				<tr class="text-center">
					<td>' . $no++ . '</td>
					<td>' . $tgl . '</td>';

				if ($jumlah['jumlah_jasa'] != 0) {
					echo '<td> <b> ' . $jumlah['jumlah_jasa'] . ' </b> </td>';
				} else {
					echo '<td> </td>';
				}
				if ($jumlah_non_jasa != 0) {
					echo '<td> <b> ' . $jumlah_non_jasa . ' </b> </td>';
				} else {
					echo '<td> </td>';
				}
				if ($jumlah['jumlah_penjualan'] != 0) {
					echo '<td> <b> ' . $jumlah['jumlah_penjualan'] . ' </b> </td>';
				} else {
					echo '<td> </td>';
				}
				if ($jumlah['grand_total_jasa'] != null) {
					echo '<td> <b> Rp.' . number_format($jumlah['grand_total_jasa'], 0, ',', '.') . ' </b> </td>';
				} else {
					echo '<td> </td>';
				}
				if ($jumlah['grand_total_barang'] != null) {
					echo '<td> <b> Rp.' . number_format($jumlah['grand_total_barang'], 0, ',', '.') . ' </b> </td>';
				} else {
					echo '<td> </td>';
				}
				if ($jumlah['diskon'] != null) {
					echo '<td> <b> Rp.' . number_format($jumlah['diskon'], 0, ',', '.') . ' </b> </td>';
				} else {
					echo '<td> </td>';
				}
				if ($jumlah['grand_total'] != null) {
					echo '<td> <b> Rp.' . number_format($jumlah['grand_total'], 0, ',', '.') . ' </b> </td>';
				} else {
					echo '<td> </td>';
				}
				echo '
				</tr>
            ';
			}

			$q_jumlah_sebulan = "SELECT COUNT(id) as jumlah_penjualan, COUNT(NULLIF(grand_tarif_jasa,0)) as jumlah_jasa, 
							SUM(grand_total) as grand_total, SUM(grand_tarif_jasa) as grand_total_jasa, 
							SUM(grand_total_barang) as grand_total_barang, SUM(diskon) as diskon FROM `penjualan` 
							WHERE tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'";
			$jumlah_sebulan = $this->db->query($q_jumlah_sebulan)->row_array();
			$jumlah_non_jasa_sebulan = $jumlah_sebulan['jumlah_penjualan'] - $jumlah_sebulan['jumlah_jasa'];

			echo '
			<tr class="text-center" style="font-size: larger;">
				<td colspan="2"><b>Total</b></td>
				<td><b> ' . $jumlah_sebulan['jumlah_jasa'] . ' </b></td>
				<td><b> ' . $jumlah_non_jasa_sebulan . ' </b></td>
				<td><b> ' . $jumlah_sebulan['jumlah_penjualan'] . ' </b></td>
				<td><b> Rp. ' . number_format($jumlah_sebulan['grand_total_jasa'], 0, ',', '.') . ' </b></td>
				<td><b> Rp. ' . number_format($jumlah_sebulan['grand_total_barang'], 0, ',', '.') . ' </b></td>
				<td><b> Rp. ' . number_format($jumlah_sebulan['diskon'], 0, ',', '.') . ' </b></td>
				<td><b> Rp. ' . number_format($jumlah_sebulan['grand_total'], 0, ',', '.') . ' </b></td>
			</tr>
		';
		}
	}





	// LAPORAN KEUNTUNGAN
	public function laporan_keuntungan()
	{
		$data_session_username = $this->session->userdata('username');
		$data['user_login'] = $this->db->get_where('user', ['username' => $data_session_username])->row_array();

		$data['profil_toko'] = $this->db->get_where('profil_toko', ['id' => 1])->row_array();

		$this->load->view('templates/header');
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('v_laporan/laporan_keuntungan', $data);
		$this->load->view('templates/footer');
	}

	public function get_laporan_keuntungan_bulanan()
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
			// CARI JUMLAH KEUNTUNGAN PER TGL FOREACH
			$q_jumlah = "SELECT COUNT(id) as jumlah_penjualan, SUM(grand_beli) as grand_beli, SUM(grand_total_barang) as grand_total_barang, 
						SUM(grand_total) as grand_total, SUM(diskon) as diskon, SUM(grand_tarif_jasa) as grand_total_jasa, SUM(grand_laba) as grand_laba 
						FROM `penjualan` WHERE tanggal = '$tgl'";
			$jumlah = $this->db->query($q_jumlah)->row_array();
			$laba_jasa = $jumlah['grand_total_jasa'] + $jumlah['grand_laba'];

			echo '
            <tr class="text-center">
                <td>' . $no++ . '</td>
                <td>' . $tgl . '</td>';

			if ($jumlah['jumlah_penjualan'] != 0) {
				echo '<td> <b> ' . $jumlah['jumlah_penjualan'] . ' </b> </td>';
			} else {
				echo '<td> </td>';
			}
			if ($jumlah['grand_beli'] != null) {
				echo '<td> <b> Rp.' . number_format($jumlah['grand_beli'], 0, ',', '.') . ' </b> </td>';
			} else {
				echo '<td> </td>';
			}
			if ($jumlah['grand_total_barang'] != null) {
				echo '<td> <b> Rp.' . number_format($jumlah['grand_total_barang'], 0, ',', '.') . ' </b> </td>';
			} else {
				echo '<td> </td>';
			}
			if ($jumlah['grand_total_jasa'] != null) {
				echo '<td> <b> Rp.' . number_format($jumlah['grand_total_jasa'], 0, ',', '.') . ' </b> </td>';
			} else {
				echo '<td> </td>';
			}
			if ($jumlah['grand_total'] != null) {
				echo '<td> <b> Rp.' . number_format($jumlah['grand_total'], 0, ',', '.') . ' </b> </td>';
			} else {
				echo '<td> </td>';
			}
			if ($jumlah['diskon'] != null) {
				echo '<td> <b> Rp.' . number_format($jumlah['diskon'], 0, ',', '.') . ' </b> </td>';
			} else {
				echo '<td> </td>';
			}
			if ($jumlah['grand_laba'] != null) {
				echo '<td> <b> Rp.' . number_format($jumlah['grand_laba'], 0, ',', '.') . ' </b> </td>';
			} else {
				echo '<td> </td>';
			}
			if ($laba_jasa != 0) {
				echo '<td> <b> ' . number_format($laba_jasa, 0, ',', '.') . ' </b> </td>';
			} else {
				echo '<td> </td>';
			}
			echo '
            </tr>
            ';
		}
		$q_jumlah_sebulan = "SELECT COUNT(id) as jumlah_penjualan, SUM(grand_beli) as grand_beli, SUM(grand_total_barang) as grand_total_barang, 
							SUM(grand_total) as grand_total, SUM(diskon) as diskon, SUM(grand_tarif_jasa) as grand_total_jasa, SUM(grand_laba) as grand_laba 
							FROM `penjualan` WHERE month(tanggal) = '$month' AND year(tanggal) = '$year'";
		$jumlah_sebulan = $this->db->query($q_jumlah_sebulan)->row_array();
		$laba_jasa_sebulan = $jumlah_sebulan['grand_total_jasa'] + $jumlah_sebulan['grand_laba'];

		echo '
        <tr class="text-center" style="font-size: larger;">
            <td colspan="2"><b>Total</b></td>
            <td><b> ' . $jumlah_sebulan['jumlah_penjualan'] . ' </b></td>
            <td><b> Rp. ' . number_format($jumlah_sebulan['grand_beli'], 0, ',', '.') . ' </b></td>
            <td><b> Rp. ' . number_format($jumlah_sebulan['grand_total_barang'], 0, ',', '.') . ' </b></td>
            <td><b> Rp. ' . number_format($jumlah_sebulan['grand_total_jasa'], 0, ',', '.') . ' </b></td>
            <td><b> Rp. ' . number_format($jumlah_sebulan['grand_total'], 0, ',', '.') . ' </b></td>
            <td><b> Rp. ' . number_format($jumlah_sebulan['diskon'], 0, ',', '.') . ' </b></td>
            <td><b> Rp. ' . number_format($jumlah_sebulan['grand_laba'], 0, ',', '.') . ' </b></td>
            <td><b> Rp. ' . number_format($laba_jasa_sebulan, 0, ',', '.') . ' </b></td>
        </tr>
        ';
	}

	public function get_laporan_keuntungan_custom()
	{
		// BUAT LIST TGL DALAM SEBULAN
		$tgl_awal = $this->input->post('tgl_awal');
		$tgl_akhir = $this->input->post('tgl_akhir');

		$begin = new DateTime($tgl_awal);
		$end = new DateTime($tgl_akhir);


		$jumlah_hari = $end->diff($begin)->format("%a");
		if ($tgl_akhir < $tgl_awal) {
			echo '
			<tr class="text-center">
				<td colspan="9" class="text-center">Tanggal awal lebih besar dari tanggal akhir.</td>
			</tr>';
		} else if ($jumlah_hari > 31) {
			echo '
            <tr class="text-center">
				<td colspan="9" class="text-center">Maksimal jumlah hari yang bisa ditampilkan adalah 31 hari</td>
			</tr>';
		} else {
			$no = 1;
			// ---------------------------------------------------------------------------------- //
			for ($dt = $begin; $dt <= $end; $dt->modify('+1 day')) {
				$tgl = $dt->format('Y-m-d');

				// CARI JUMLAH KEUNTUNGAN PER TGL FOREACH
				$q_jumlah = "SELECT COUNT(id) as jumlah_penjualan, SUM(grand_beli) as grand_beli, SUM(grand_total_barang) as grand_total_barang, 
						SUM(grand_total) as grand_total, SUM(diskon) as diskon, SUM(grand_tarif_jasa) as grand_total_jasa, SUM(grand_laba) as grand_laba 
						FROM `penjualan` WHERE tanggal = '$tgl'";
				$jumlah = $this->db->query($q_jumlah)->row_array();
				$laba_jasa = $jumlah['grand_total_jasa'] + $jumlah['grand_laba'];

				echo '
				<tr class="text-center">
					<td>' . $no++ . '</td>
					<td>' . $tgl . '</td>';

				if ($jumlah['jumlah_penjualan'] != 0) {
					echo '<td> <b> ' . $jumlah['jumlah_penjualan'] . ' </b> </td>';
				} else {
					echo '<td> </td>';
				}
				if ($jumlah['grand_beli'] != null) {
					echo '<td> <b> Rp.' . number_format($jumlah['grand_beli'], 0, ',', '.') . ' </b> </td>';
				} else {
					echo '<td> </td>';
				}
				if ($jumlah['grand_total_barang'] != null) {
					echo '<td> <b> Rp.' . number_format($jumlah['grand_total_barang'], 0, ',', '.') . ' </b> </td>';
				} else {
					echo '<td> </td>';
				}
				if ($jumlah['grand_total_jasa'] != null) {
					echo '<td> <b> Rp.' . number_format($jumlah['grand_total_jasa'], 0, ',', '.') . ' </b> </td>';
				} else {
					echo '<td> </td>';
				}
				if ($jumlah['grand_total'] != null) {
					echo '<td> <b> Rp.' . number_format($jumlah['grand_total'], 0, ',', '.') . ' </b> </td>';
				} else {
					echo '<td> </td>';
				}
				if ($jumlah['diskon'] != null) {
					echo '<td> <b> Rp.' . number_format($jumlah['diskon'], 0, ',', '.') . ' </b> </td>';
				} else {
					echo '<td> </td>';
				}
				if ($jumlah['grand_laba'] != null) {
					echo '<td> <b> Rp.' . number_format($jumlah['grand_laba'], 0, ',', '.') . ' </b> </td>';
				} else {
					echo '<td> </td>';
				}
				if ($laba_jasa != 0) {
					echo '<td> <b> ' . number_format($laba_jasa, 0, ',', '.') . ' </b> </td>';
				} else {
					echo '<td> </td>';
				}
				echo '
					</tr>
				';
			}

			$q_jumlah_sebulan = "SELECT COUNT(id) as jumlah_penjualan, SUM(grand_beli) as grand_beli, SUM(grand_total_barang) as grand_total_barang, 
							SUM(grand_total) as grand_total, SUM(diskon) as diskon, SUM(grand_tarif_jasa) as grand_total_jasa, SUM(grand_laba) as grand_laba 
							FROM `penjualan` WHERE tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'";
			$jumlah_sebulan = $this->db->query($q_jumlah_sebulan)->row_array();
			$laba_jasa_sebulan = $jumlah_sebulan['grand_total_jasa'] + $jumlah_sebulan['grand_laba'];

			echo '
			<tr class="text-center" style="font-size: larger;">
				<td colspan="2"><b>Total</b></td>
				<td><b> ' . $jumlah_sebulan['jumlah_penjualan'] . ' </b></td>
				<td><b> Rp. ' . number_format($jumlah_sebulan['grand_beli'], 0, ',', '.') . ' </b></td>
				<td><b> Rp. ' . number_format($jumlah_sebulan['grand_total_barang'], 0, ',', '.') . ' </b></td>
				<td><b> Rp. ' . number_format($jumlah_sebulan['grand_total_jasa'], 0, ',', '.') . ' </b></td>
				<td><b> Rp. ' . number_format($jumlah_sebulan['grand_total'], 0, ',', '.') . ' </b></td>
				<td><b> Rp. ' . number_format($jumlah_sebulan['diskon'], 0, ',', '.') . ' </b></td>
				<td><b> Rp. ' . number_format($jumlah_sebulan['grand_laba'], 0, ',', '.') . ' </b></td>
				<td><b> Rp. ' . number_format($laba_jasa_sebulan, 0, ',', '.') . ' </b></td>
			</tr>
			';
		}
	}






	// LAPORAN BARANG
	public function laporan_barang()
	{
		$data_session_username = $this->session->userdata('username');
		$data['user_login'] = $this->db->get_where('user', ['username' => $data_session_username])->row_array();

		$data['profil_toko'] = $this->db->get_where('profil_toko', ['id' => 1])->row_array();

		$data['banyak'] = $this->db->query('SELECT * FROM barang WHERE status_delete != 0 AND stok != 0 ORDER BY stok DESC LIMIT 10')->result();
		$data['sedikit'] = $this->db->query('SELECT * FROM barang WHERE status_delete != 0 AND stok != 0 ORDER BY stok ASC LIMIT 10')->result();

		$q_total_modal = "SELECT SUM(harga_beli) as total_modal FROM barang WHERE stok != 0";
		$data['modal'] = $this->db->query($q_total_modal)->row_array();

		$q_stok_habis = "SELECT COUNT(id) as stok_habis FROM barang WHERE stok = 0";
		$data['habis'] = $this->db->query($q_stok_habis)->row_array();

		$this->load->view('templates/header');
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('v_laporan/laporan_barang', $data);
		$this->load->view('templates/footer');
	}


	public function barang_habis()
	{
		$barang = $this->db->get_where('barang', ['stok' => 0])->result();

		$html = '';

		$html .= '
		<div class="table-responsive">
			<table class="table table-bordered table-striped" style="font-size:15px; border: solid 1px #E5E8E8;white-space: nowrap" id="dataTable" width="100%">
				<thead>
					<tr class="text-center">
						<th width="20%">Kode</th>
						<th width="60%">Barang</th>
						<th width="20%">Stok</th>
					</tr>
				</thead>
				<tbody>';
		foreach ($barang as $br) {
			$html .= '
						<tr>
							<td>' . $br->kode_barang . '</td>
							<td>' . $br->nama_barang . '</td>
							<td>' . $br->stok . '</td>
						</tr>';
		}
		$html .= '
				</tbody>
			</table>
		</div>
		';

		echo json_encode($html);
	}
}
