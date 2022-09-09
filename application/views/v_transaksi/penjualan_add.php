<body onload="load_data_penjualan('<?= $penjualan['id'] ?>')"></body>
<main class="content" style="padding: 10px;">
	<!-- <div class="container" style="padding: 0px;"> -->

	<h1 class="h3 mb-2 ml-3">Transaksi Penjualan</h1>

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body" style="padding: 15px;">

					<input type="hidden" id="id_penjualan" name="id_penjualan" value="<?= $penjualan['id'] ?>">
					<input type="hidden" id="id_jasa" name="id_jasa">
					<input type="hidden" id="id_barang" name="id_barang">
					<input type="hidden" id="grand_total" name="grand_total">

					<div class="row">
						<div class="col-md-3">
							<select style="background-color: #D35400; color: white;" class="form-control form-control-lg" id="opsi_tambah" name="opsi_tambah">
								<option selected value="tambahbarang">Tambah Barang</option>
								<option value="tambahjasa">Tambah Jasa</option>
							</select>
						</div>

						<div class="col-md-3">
							<div class="input-group input-group-lg mb-2 mr-sm-2">
								<div class="input-group-text"><b>No Penjualan </b></div>
								<input readonly type="text" class="form-control" id="no_penjualan" name="no_penjualan" value="<?= $penjualan['no_penjualan'] ?>">
							</div>
						</div>
						<div class="col-md-3">
							<div class="input-group input-group-lg mb-2 mr-sm-2">
								<div class="input-group-text"><b>Tanggal</b></div>
								<input readonly type="text" class="form-control" id="tanggal" name="tanggal" value="<?= $penjualan['tanggal'] ?>">
							</div>
						</div>
						<div class="col-md-3">
							<div class="input-group input-group-lg mb-2 mr-sm-2">
								<div class="input-group-text"><b>Pembeli</b></div>
								<input readonly type="text" class="form-control" id="nama_pembeli" name="nama_pembeli" value="<?= $penjualan['nama_pembeli'] ?>">
							</div>
						</div>
					</div>

					<br>

					<div id="form_tambah_barang">
						<div class="row">
							<div class="col-md-4">
								<div class="input-group input-group-lg mb-2 mr-sm-2">
									<div class="input-group-text"><b>Barang</b></div>
									<input autocomplete="off" list="datalist_barang" class="form-control" id="nama_barang" name="nama_barang">
									<datalist id="datalist_barang">
										<?php foreach ($barang as $br) { ?>
											<option value="<?= $br->kode_barang ?>"><?= $br->nama_barang ?></option>
										<?php } ?>
									</datalist>
								</div>
							</div>
							<div class="col-md-4">
								<div class="input-group input-group-lg mb-2 mr-sm-2">
									<div class="input-group-text"><b>Hg Satuan</b></div>
									<input readonly type="text" class="form-control" id="harga_jual" name="harga_jual">
								</div>
							</div>
							<div class="col-md-4">
								<div class="input-group input-group-lg mb-2 mr-sm-2">
									<div class="input-group-text"><b>Stok</b></div>
									<input readonly type="text" class="form-control" id="stok" name="stok">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-4">
								<div class="input-group input-group-lg mb-2 mr-sm-2">
									<div class="input-group-text"><b>Jumlah</b></div>
									<input type="text" class="form-control" id="jumlah_barang" name="jumlah_barang" onkeypress="return hanyaAngka(event)" maxlength="6">
								</div>
							</div>
							<div class="col-md-4">
								<div class="input-group input-group-lg mb-2 mr-sm-2">
									<div class="input-group-text"><b>Hg Total</b></div>
									<input readonly type="text" class="form-control" id="hg_total" name="hg_total">
								</div>
							</div>
							<div class="col-md-4">
								<button onclick="validasi_add_list_penjualan()" class="btn btn-lg btn-block btn-primary">Tambahkan Barang</button>
							</div>
						</div>
					</div>

					<div hidden id="form_tambah_jasa">
						<div class="row">
							<div class="col-md-4">
								<div class="input-group input-group-lg mb-2 mr-sm-2">
									<div class="input-group-text"><b>Jasa</b></div>
									<input autocomplete="off" list="datalist_jasa" class="form-control" id="nama_jasa" name="nama_jasa">
									<datalist id="datalist_jasa">
										<?php foreach ($jasa as $js) { ?>
											<option value="<?= $js->kode_jasa ?>"><?= $js->nama_jasa ?></option>
										<?php } ?>
									</datalist>
								</div>
							</div>
							<div class="col-md-4">
								<div class="input-group input-group-lg mb-2 mr-sm-2">
									<div class="input-group-text"><b>Tarif</b></div>
									<input readonly type="text" class="form-control" id="tarif" name="tarif">
								</div>
							</div>
							<div class="col-md-4">
								<button onclick="validasi_add_jasa_penjualan()" class="btn btn-lg btn-block btn-primary">Tambahkan Jasa</button>
							</div>
						</div>
					</div>

					<hr>

					<div class="table-responsive mt-3">
						<table class="table table-hover table-warning table-bordered table-striped" style="white-space: nowrap" id="dataTable" width="100%">
							<thead>
								<tr class="text-center">
									<th width="5%">No</th>
									<th width="10%">Kode</th>
									<th width="37%">Nama Barang / Jasa</th>
									<th width="10%">Qty</th>
									<th width="15%">Hg Satuan</th>
									<th width="15%">Total</th>
									<th width="8%">Aksi</th>
								</tr>
							</thead>
							<tbody id="list_data_penjualan">
							</tbody>
							<tbody id="list_jasa_penjualan">
							</tbody>
							<tr>
								<td colspan="5" style="font-size: larger; text-align: right; padding-right: 5%;"> <b> Grand Total </b> </td>
								<td colspan="2" id="text_grand_total" style="font-size: larger;"></td>
							</tr>
						</table>
					</div>

					<div class="row">
					</div>

					<hr>

					<div class="row justify-content-between mt-4">
						<div class="col-md-4">
							<div class="input-group">
								<div class="input-group-text"> <b>Garansi</b> </div>
								<select class="form-control form-control-lg" id="garansi" name="garansi">
									<option selected value="Tidak ada">Tidak ada garansi</option>
									<option value="1 Minggu">1 Minggu</option>
									<option value="2 Minggu">2 Minggu</option>
									<option value="3 Minggu">3 Minggu</option>
									<option value="4 Minggu">4 Minggu</option>
									<option value="5 Minggu">5 Minggu</option>
									<option value="6 Minggu">6 Minggu</option>
								</select>
							</div>
						</div>

						<div class="col-md-4">
							<div class="input-group input-group-lg mb-2 mr-sm-2">
								<div class="input-group-text"><b>Bayar Rp.</b></div>
								<input id="jumlah_bayar" style="height: 60px; font-size: 45px; text-align: right;" onchange="hitung_kembalian()" type="text" min="1000" max="100000000" step="1000" class="form-control" />
							</div>
						</div>

						<div class="col-md-4">
							<div class="input-group input-group-lg mb-2 mr-sm-2">
								<div class="input-group-text"><b>Kembalian Rp.</b></div>
								<input id="jumlah_kembalian" style="height: 60px; font-size: 45px; text-align: right;" readonly type="text" min="1000" max="100000000" step="1000" class="form-control" />
							</div>
						</div>
					</div>

					<div class="row justify-content-end mt-4">
						<div class="col-md-8">
							<button onclick="validasi_simpan_penjualan(<?= $penjualan['id'] ?>)" class="btn btn-lg btn-block btn-success">Simpan Penjualan</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- </div> -->
</main>

<!-- Modal detail penjualan -->
<div class="modal fade" id="modal-detail-penjualan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Detail Penjualan</h5>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="row">
						<div class="col-md-6">
							<strong style="font-size: 20px;"><?= $profil_toko['nama'] ?></strong>
							<p class="mb-2">
								<?= $profil_toko['keterangan'] ?>
								<br> <?= $profil_toko['alamat'] ?>
								<br> <?= $profil_toko['telepon'] ?>
							</p>
						</div>
						<div class="col-md-6 text-md-right">
							<div class="text-muted">Customer</div>
							<strong id="detail_nama_pembeli">Nama Pembeli</strong>
							<div class="text-muted" id="detail_alamat_pembeli" class="mb-2">Alamat Pembeli</div>
							<div class="text-muted" id="detail_no_telp_pembeli" class="mb-2">No Telp Pembeli</div>
						</div>
					</div>

					<div class="row mt-2">
						<div class="col-md-12">
							<div class="text-muted">No Nota &nbsp; &nbsp; <strong id="detail_no_penjualan">210609001</strong> </div>
							<div class="text-muted">Tanggal &nbsp; &nbsp; <strong id="detail_tanggal">09 Juni 2021</strong> </div>
						</div>
					</div>

					<hr class="my-3" />

					<table class="table table-sm" width="100%">
						<thead>
							<tr>
								<th width="65%">Nama Barang</th>
								<th width="10%">Jumlah</th>
								<th width="10%" class="text-right">Satuan</th>
								<th width="15%" class="text-right">Total</th>
							</tr>
						</thead>

						<tbody id="detail_list_barang">
						</tbody>
						<tbody id="detail_list_jasa">
						</tbody>

						<tr>
							<th colspan="3" class="text-right"> Total </th>
							<th class="text-right" id="detail_grand_total">Rp. 0</th>
						</tr>
						<tr>
							<th colspan="3" class="text-right"> Bayar </th>
							<th class="text-right" id="detail_jumlah_bayar">Rp. 0</th>
						</tr>
						<tr>
							<th colspan="3" class="text-right"> Kembalian </th>
							<th class="text-right" id="detail_jumlah_kembalian">Rp. 0</th>
						</tr>
					</table>

					<p id="detail_garansi">Garansi : -</p>

					<div class="text-center mt-5 mb-3">
						<button type="button" id="btn_print_nota" class="btn btn-secondary">
							Print Nota Penjualan
						</button>
						<br>
						<br>
						<a href="<?= base_url() ?>penjualan" class="btn btn-success">
							Selesai
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		// Format mata uang.
		$('#jumlah_bayar').mask('000.000.000', {
			reverse: true
		});
	})





	function load_data_penjualan(id_penjualan) {
		$.ajax({
			type: 'post',
			url: '<?= base_url() ?>penjualan/load_data_penjualan',
			data: '&id_penjualan=' + id_penjualan,
			success: function(html) {
				$('#list_data_penjualan').html(html);
			}
		})
		$.ajax({
			type: 'post',
			url: '<?= base_url() ?>penjualan/get_jumlah_list_barang',
			data: '&id_penjualan=' + id_penjualan,
			success: function(res) {
				load_jasa(res)
			}
		})

		function load_jasa(jumlah) {
			$.ajax({
				type: 'post',
				url: '<?= base_url() ?>penjualan/load_jasa_penjualan',
				data: '&id_penjualan=' + id_penjualan + '&jumlah_list_barang=' + jumlah,
				success: function(html) {
					$('#list_jasa_penjualan').html(html);
				}
			})
		}

		$.ajax({
			type: 'post',
			url: '<?= base_url() ?>penjualan/load_grand_total',
			data: '&id_penjualan=' + id_penjualan,
			dataType: 'JSON',
			success: function(data) {
				let g_total = format_rupiah(data.grand_total);
				$('#text_grand_total').html('<b> Rp. ' + g_total + '</b>');
				$('#grand_total').val(data.grand_total);
			}
		})
	}



	$("#opsi_tambah").change(function() {
		let val = $(this).val();
		if (val == 'tambahbarang') {
			$('#form_tambah_barang').attr('hidden', false);
			$('#form_tambah_jasa').attr('hidden', true);
		} else {
			$('#form_tambah_barang').attr('hidden', true);
			$('#form_tambah_jasa').attr('hidden', false);

		}
	})



	$("#nama_jasa").change(function() {
		let kd_js = $(this).val();
		if (kd_js != '') {
			$.ajax({
				url: "<?= base_url() ?>penjualan/get_jasa_autocomplete",
				type: "post",
				data: "&kd_js=" + kd_js,
				dataType: 'JSON',
				success: function(data) {
					if (data.kodeku == 'ada') {
						$('#id_jasa').val(data.id);
						$('#tarif').val(data.tarif);
					} else {
						$('#id_jasa').val('');
						$('#tarif').val('');
					}
				}
			});
		} else {
			$('#id_jasa').val('');
			$('#tarif').val('');
		}
	})


	$("#nama_barang").change(function() {
		let kd_brg = $(this).val();
		if (kd_brg != '') {
			$.ajax({
				url: "<?= base_url() ?>penjualan/get_barang_autocomplete",
				type: "post",
				data: "&kd_brg=" + kd_brg,
				dataType: 'JSON',
				success: function(data) {
					if (data.kodeku == 'ada') {
						$('#id_barang').val(data.id);
						$('#harga_jual').val(data.harga_jual);
						$('#stok').val(data.stok);
						$('#hg_total').val('');
						$('#jumlah_barang').val('');
					} else {
						$('#harga_jual').val('');
						$('#stok').val('');
						$('#hg_total').val('');
						$('#jumlah_barang').val('');
					}
				}
			});
		} else {
			$('#harga_jual').val('');
			$('#stok').val('');
			$('#hg_total').val('');
			$('#jumlah_barang').val('');
		}
	})

	$("#jumlah_barang").change(function() {
		let jml_brg = $(this).val();
		let hg_brg = $('#harga_jual').val();
		let stok = $('#stok').val();
		let barang = $('#nama_barang').val();

		let fix_stok = parseFloat(stok);
		let fix_jml_brg = parseFloat(jml_brg);


		if (fix_stok != 0) {
			if (fix_jml_brg != 0) {
				if (fix_stok >= fix_jml_brg) {
					let hg_total = fix_jml_brg * hg_brg;
					$('#hg_total').val(hg_total);
				} else {
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: 'Jumlah barang yang dibeli melebihi Stok!',
					})
					$('#hg_total').val('');
				}
			} else {
				Swal.fire({
					icon: 'error',
					title: 'Gagal...',
					text: 'Jumlah barang yang dibeli tidak bisa 0!',
				})
				$('#hg_total').val('');
			}
		} else {
			Swal.fire({
				icon: 'error',
				title: 'Gagal...',
				text: 'Barang yang dibeli sudah habis!',
			})
		}

	})





	// TAMBAH LIST & SIMPAN PENJUALAN
	function tambahListBarang() {
		let id_penjualan = $('#id_penjualan').val();
		$.ajax({
			type: 'post',
			url: '<?= base_url() ?>penjualan/add_list',
			data: '&id_penjualan=' + $('#id_penjualan').val() +
				'&id_barang=' + $('#id_barang').val() +
				'&no_penjualan=' + $('#no_penjualan').val() +
				'&jumlah=' + $('#jumlah_barang').val() +
				'&hg_satuan=' + $('#harga_jual').val() +
				'&hg_total=' + $('#hg_total').val(),
			success: function() {
				Swal.fire(
					'Berhasil!',
					'Berhasil menambah barang !',
					'success'
				)
				$('#nama_barang').val('');
				$('#harga_jual').val('');
				$('#stok').val('');
				$('#jumlah_barang').val('');
				$('#hg_total').val('');
				load_data_penjualan(id_penjualan);
			}
		})
	}

	function hapus_list(id_detail) {
		let id_penjualan = $('#id_penjualan').val();
		$.ajax({
			type: 'post',
			url: '<?= base_url() ?>penjualan/delete_list',
			data: '&id_detail=' + id_detail,
			success: function() {
				Swal.fire(
					'Berhasil!',
					'Berhasil menghapus barang !',
					'success'
				)
				$('#nama_barang').val('');
				$('#harga_jual').val('');
				$('#stok').val('');
				$('#jumlah_barang').val('');
				$('#hg_total').val('');
				load_data_penjualan(id_penjualan);
			}
		})
	}


	function tambahJasaBarang() {
		let id_penjualan = $('#id_penjualan').val();
		$.ajax({
			type: 'post',
			url: '<?= base_url() ?>penjualan/add_jasa',
			data: '&id_penjualan=' + $('#id_penjualan').val() +
				'&no_penjualan=' + $('#no_penjualan').val() +
				'&id_jasa=' + $('#id_jasa').val(),
			success: function() {
				Swal.fire(
					'Berhasil!',
					'Berhasil menambah Jasa !',
					'success'
				)
				$('#nama_jasa').val('');
				$('#tarif').val('');
				load_data_penjualan(id_penjualan);
			}
		})
	}

	function hapus_jasa(id_jasa) {
		let id_penjualan = $('#id_penjualan').val();
		$.ajax({
			type: 'post',
			url: '<?= base_url() ?>penjualan/delete_jasa',
			data: '&id_jasa=' + id_jasa,
			success: function() {
				Swal.fire(
					'Berhasil!',
					'Berhasil menghapus jasa !',
					'success'
				)
				$('#nama_jasa').val('');
				$('#tarif').val('');
				load_data_penjualan(id_penjualan);
			}
		})
	}



	function hitung_kembalian() {
		let grand_total = $('#grand_total').val();
		let bayar = $('#jumlah_bayar').val();

		if (grand_total == 0) {
			Swal.fire(
				'Maaf...',
				'Anda belum menambahkan daftar barang jual apapun !',
				'error'
			)
			$('#jumlah_bayar').val('');
		} else {
			bayar = bayar.replace(/\./g, '');
			bayar = parseInt(bayar, 10);

			let jumlah_kembalian = bayar - grand_total;
			if (jumlah_kembalian < 0) {
				Swal.fire({
					icon: 'warning',
					title: 'Gagal!',
					text: 'Jumlah Bayar Kurang !',
				})
				$('#jumlah_kembalian').val('');
			} else {
				$('#jumlah_kembalian').val(format_rupiah(jumlah_kembalian));

			}
		}
	}


	function validasi_simpan_penjualan(id_penjualan) {
		$.ajax({
			url: "<?= base_url() ?>penjualan/validasi_simpan_jual",
			type: "post",
			data: "&id_penjualan=" + id_penjualan,
			dataType: 'JSON',
			success: function(data) {
				if (data.kodeku == 'ada') {
					simpan_penjualan(id_penjualan);
				} else {
					Swal.fire(
						'Maaf...',
						'Anda belum menambahkan daftar barang jual apapun !',
						'error'
					)
				}
			}
		});
	}


	function simpan_penjualan(id_penjualan) {
		let garansi = $('#garansi').val();
		let jumlah_bayar = $('#jumlah_bayar').val();
		let jumlah_kembalian = $('#jumlah_kembalian').val();

		bayar = jumlah_bayar.replace(/\./g, '');
		bayar = parseInt(bayar, 10);
		kembalian = jumlah_kembalian.replace(/\./g, '');
		kembalian = parseInt(kembalian, 10);

		if (jumlah_bayar == '') {
			Swal.fire({
				icon: 'warning',
				title: 'Gagal!',
				text: 'Jumlah Bayar Belum diisi !',
			})
		} else if (jumlah_kembalian == '') {
			Swal.fire({
				icon: 'warning',
				title: 'Gagal!',
				text: 'Jumlah Kembalian Belum diisi !',
			})
		} else if (kembalian > bayar) {
			Swal.fire({
				icon: 'warning',
				title: 'Gagal!',
				text: 'Jumlah Kembalian Salah !',
			})
		} else {
			$.ajax({
				type: 'post',
				url: '<?= base_url() ?>penjualan/simpan_penjualan',
				data: '&id_penjualan=' + id_penjualan +
					'&garansi=' + garansi +
					'&jumlah_bayar=' + bayar +
					'&jumlah_kembalian=' + kembalian,
				success: function() {
					Swal.fire({
						icon: 'success',
						title: 'Berhasil!',
						text: 'Berhasil simpan transaksi penjualan !',
						allowOutsideClick: false,
						allowEscapeKey: false
					}).then(function() {
						detail(id_penjualan);
					});;
				}
			})
		}
	}





	// DETAIL DATA PENJUALAN ------------------------------------------------------------------------- DETAIL DATA PENJUALAN
	function detail(id_penjualan) {
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>penjualan/get_detail",
			data: '&id_penjualan=' + id_penjualan,
			dataType: 'JSON',
			success: function(response) {
				$('#detail_nama_pembeli').html(response.nama_pembeli);
				$('#detail_alamat_pembeli').html(response.alamat_pembeli);
				$('#detail_no_telp_pembeli').html(response.no_telp_pembeli);
				$('#detail_no_penjualan').html(response.no_penjualan);
				$('#detail_tanggal').html(response.tanggal);
				$('#detail_grand_total').html('Rp. ' + format_rupiah(response.grand_total));
				$('#detail_jumlah_bayar').html('Rp. ' + format_rupiah(response.jumlah_bayar));
				$('#detail_jumlah_kembalian').html('Rp. ' + format_rupiah(response.jumlah_kembalian));
				$('#detail_garansi').html('<b> Garansi : </b> ' + response.garansi);
				$('#btn_print_nota').attr('onclick', 'print_nota(' + response.id + ')')
			}
		})
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>penjualan/get_detail_list",
			data: '&id_penjualan=' + id_penjualan,
			success: function(html) {
				$('#detail_list_barang').html(html);
			}
		})
		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>penjualan/get_detail_jasa",
			data: '&id_penjualan=' + id_penjualan,
			success: function(html) {
				$('#detail_list_jasa').html(html);
			}
		})

		$('#modal-detail-penjualan').modal({
			backdrop: 'static',
			keyboard: false
		});
	}
	// DETAIL DATA PENJUALAN ------------------------------------------------------------------------- DETAIL DATA PENJUALAN




	function print_nota(id) {
		var s5_taf_parent = window.location;
		window.open('<?= base_url() ?>Prints/print_nota/' + id, 'page', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=900,height=750,left=50,top=50,titlebar=yes')
	}
</script>
