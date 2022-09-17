<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Prints extends CI_Controller
{

	public function print_nota($id)
	{
		$data['profil_toko'] = $this->db->get_where('profil_toko', ['id' => 1])->row_array();
		$data['data_penjualan'] = $this->db->get_where('penjualan', ['id' => $id])->row_array();

		$list_penjualan = $this->db->get_where('penjualan_detail', ['id_penjualan' => $id])->result();
		if ($list_penjualan) {
			foreach ($list_penjualan as $ls) {
				$data['list_barang'] = '
				<tr>
					<td>' . $ls->nama_barang . '</td>
					<td class="text-center">' . $ls->jumlah . '</td>
					<td class="text-right">Rp.' . number_format($ls->hg_satuan, 0, ',', '.') . '</td>
					<td class="text-right">Rp.' . number_format($ls->hg_total, 0, ',', '.') . '</td>
				</tr>
				';
			}
		} else {
			$data['list_barang'] = '';
		}

		$jasa_penjualan = $this->db->get_where('penjualan_jasa', ['id_penjualan' => $id])->result();

		if ($jasa_penjualan) {
			foreach ($jasa_penjualan as $ls) {
				$data['list_jasa'] = '
				<tr>
					<td colspan="3">' . $ls->nama_jasa . '</td>
					<td class="text-right">Rp.' . number_format($ls->tarif, 0, ',', '.') . '</td>
				</tr>
				';
			}
		} else {
			$data['list_jasa'] = '';
		}

		if ($data['data_penjualan']['diskon'] != 0) {
			$data['list_diskon'] = '
			<tr>
				<td colspan="3"> <b> Diskon </b> </td>
				<td class="text-right"> <b>- Rp.' . number_format($data['data_penjualan']['diskon'], 0, ',', '.') . '</b></td>
			</tr>';
		} else {
			$data['list_diskon'] = '';
		}

		$this->load->view('v_print/nota_penjualan', $data);
	}




	public function print_nota_pembelian($id)
	{
		$data['profil_toko'] = $this->db->get_where('profil_toko', ['id' => 1])->row_array();

		$q = "SELECT pembelian.*, suplier.nama as nama_suplier, suplier.alamat as alamat_suplier FROM pembelian JOIN suplier ON pembelian.id_suplier = suplier.id WHERE pembelian.id = '$id'";
		$data['data_pembelian']  = $this->db->query($q)->row_array();

		$list_pembelian = $this->db->get_where('pembelian_detail', ['id_pembelian' => $id])->result();
		if ($list_pembelian) {
			foreach ($list_pembelian as $ls) {
				$data['list_barang'] = '
				<tr>
					<td>' . $ls->nama_barang . '</td>
					<td class="text-center">' . $ls->jumlah . '</td>
					<td class="text-right">Rp.' . number_format($ls->hg_satuan, 0, ',', '.') . '</td>
					<td class="text-right">Rp.' . number_format($ls->hg_total, 0, ',', '.') . '</td>
				</tr>
				';
			}
		} else {
			$data['list_barang'] = '';
		}

		$this->load->view('v_print/nota_pembelian', $data);
	}
}
