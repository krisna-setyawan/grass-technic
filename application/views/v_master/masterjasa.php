<main class="content" style="padding: 10px;">
	<!-- <div class="container" style="padding: 0px;"> -->

	<h1 class="h3 mb-2 ml-3">Master Jasa</h1>

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body" style="padding: 15px;">

					<?= $this->session->flashdata('pesan') ?>

					<button class="btn btn-sm btn-success mb-3" data-toggle="modal" data-target="#modal-tambah-jasa">Tambah Jasa</button>

					<div class="table-responsive">
						<table class="table table-bordered table-striped" style="border: solid 1px #E5E8E8;white-space: nowrap" id="dataTable" width="100%">
							<thead>
								<tr class="text-center">
									<th width="5%">No</th>
									<th width="10%">Kode</th>
									<th width="50%">Nama Jasa</th>
									<th width="15%">Tarif</th>
									<th width="20%">Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1;
								foreach ($jasa as $js) : ?>
									<tr>
										<td><?= $no++ ?></td>
										<td><?= $js->kode_jasa ?></td>
										<td><?= $js->nama_jasa ?></td>
										<td><?= number_format($js->tarif) ?></td>
										<td class="text-center">
											<a>
												<button onclick="detail(<?= $js->id ?>)" class="badge btn-secondary">Detail</button>
											</a>
											<a>
												<button onclick="edit(<?= $js->id ?>)" class="badge btn-info">Edit</button>
											</a>
											<a>
												<button onclick="hapus(<?= $js->id ?>)" class="badge btn-danger">Hapus</button>
											</a>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>

				</div>
			</div>
		</div>
	</div>

	<!-- </div> -->
</main>

<!-- Modal add jasa -->
<div class="modal fade" id="modal-tambah-jasa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Tambah Jasa</h5>
				<button type="button" onclick="batal_tambah()" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="needs-validation" novalidate autocomplete="off" id="form_tambah" method="POST" action="<?= base_url() ?>masterjasa/add_jasa_aksi">
					<div class="form-group row mb-3">
						<label class="col-sm-3 col-form-label">Kode Jasa</label>
						<div class="col-sm-9">
							<input type="text" class="form-control form-control-lg" id="kode_jasa" name="kode_jasa" required>
							<div class="invalid-feedback">Kode Jasa harus diisi.</div>
						</div>
					</div>
					<div class="form-group row mb-3">
						<label class="col-sm-3 col-form-label">Nama Jasa</label>
						<div class="col-sm-9">
							<input type="text" class="form-control form-control-lg" id="nama_jasa" name="nama_jasa" required>
							<div class="invalid-feedback">Nama Jasa harus diisi.</div>
						</div>
					</div>
					<div class="form-group row mb-3">
						<label class="col-sm-3 col-form-label">Tarif</label>
						<div class="col-sm-9">
							<input type="text" class="form-control form-control-lg" id="tarif" name="tarif" required>
							<div class="invalid-feedback">Harga Beli harus diisi.</div>
						</div>
					</div>
					<div class="row mt-5 mb-4 justify-content-center">
						<div class="col-md-3 mb-3">
							<button type="button" class="btn btn-block btn-danger" data-dismiss="modal" onclick="batal_tambah()">Batal</button>
						</div>
						<div class="col-md-3 mb-3">
							<button type="submit" class="btn btn-block btn-primary">Simpan</button>
						</div>
					</div>
			</div>
			</form>
		</div>
	</div>
</div>

<!-- Modal edit Jasa -->
<div class="modal fade" id="modal-edit-jasa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Edit Jasa</h5>
				<button type="button" onclick="batal_edit()" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="needs-validation" novalidate autocomplete="off" id="form_edit" method="POST" action="<?= base_url() ?>masterjasa/edit_jasa_aksi">
					<input type="hidden" name="edit_id" id="edit_id">
					<div class="form-group row mb-3">
						<label class="col-sm-3 col-form-label">Kode Jasa</label>
						<div class="col-sm-9">
							<input type="text" class="form-control form-control-lg" id="edit_kode_jasa" name="edit_kode_jasa" required>
							<div class="invalid-feedback">Kode Jasa harus diisi.</div>
						</div>
					</div>
					<div class="form-group row mb-3">
						<label class="col-sm-3 col-form-label">Nama Jasa</label>
						<div class="col-sm-9">
							<input type="text" class="form-control form-control-lg" id="edit_nama_jasa" name="edit_nama_jasa" required>
							<div class="invalid-feedback">Nama Jasa harus diisi.</div>
						</div>
					</div>
					<div class="form-group row mb-3">
						<label class="col-sm-3 col-form-label">Tarif</label>
						<div class="col-sm-9">
							<input type="text" class="form-control form-control-lg" id="edit_tarif" name="edit_tarif" required>
							<div class="invalid-feedback">Harga Beli harus diisi.</div>
						</div>
					</div>
					<div class="row mt-5 mb-4 justify-content-center">
						<div class="col-md-3 mb-3">
							<button type="button" class="btn btn-block btn-danger" data-dismiss="modal" onclick="batal_edit()">Batal</button>
						</div>
						<div class="col-md-3 mb-3">
							<button type="submit" class="btn btn-block btn-primary">Simpan</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Modal detail Jasa -->
<div class="modal fade" id="modal-detail-jasa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Detail Jasa</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="font-size: large;">
				<div class="row">
					<div class="col-6">
						<p>Kode Jasa</p>
					</div>
					<div class="col-6">
						<p><b id="detail_kode_jasa"></b></p>
					</div>
				</div>
				<div class="row">
					<div class="col-6">
						<p>Nama Jasa</p>
					</div>
					<div class="col-6">
						<p><b id="detail_nama_jasa"></b></p>
					</div>
				</div>
				<div class="row">
					<div class="col-6">
						<p>Tarif</p>
					</div>
					<div class="col-6">
						<p><b id="detail_tarif"></b></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		window.setTimeout(function() {
			$(".alert").fadeTo(500, 0).slideUp(500, function() {
				$(this).remove();
			});
		}, 3000);

		$('#dataTable').dataTable();

		// Format mata uang.
		$('#tarif').mask('000.000.000', {
			reverse: true
		});

		$('#edit_tarif').mask('000.000.000', {
			reverse: true
		});
	});





	// ADD DATA ----------------------------------------------------------------------------------- ADD DATA
	function batal_tambah() {
		$('#kode_jasa').val("");
		$('#nama_jasa').val("");
		$('#tarif').val("");
		$('#form_tambah').removeClass('was-validated')
	}
	// ADD DATA ----------------------------------------------------------------------------------- ADD DATA





	// EDIT DATA ----------------------------------------------------------------------------------- EDIT DATA
	function batal_edit() {
		$('#edit_kode_jasa').val("");
		$('#edit_nama_jasa').val("");
		$('#edit_tarif').val("");
		$('#form_edit').removeClass('was-validated')
	}

	function edit(id) {
		$.ajax({
			type: "GET",
			url: "<?= base_url() ?>masterjasa/getJasaById/" + id,
			dataType: 'JSON',
			success: function(response) {
				$('#edit_id').val(response.id);
				$('#edit_kode_jasa').val(response.kode_jasa);
				$('#edit_nama_jasa').val(response.nama_jasa);
				$('#edit_tarif').val(format_rupiah(response.tarif));
				$('#modal-edit-jasa').modal('toggle');
			}
		})
	}
	// EDIT DATA ----------------------------------------------------------------------------------- EDIT DATA





	// HAPUS DATA ----------------------------------------------------------------------------------- HAPUS DATA
	function hapus(id) {
		Swal.fire({
			title: 'Yakin Mau Hapus?',
			text: "Data akan dihapus permanen!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#3085d6',
			confirmButtonText: 'Hapus',
			cancelButtonText: 'Batal',
		}).then((result) => {
			if (result.isConfirmed) {
				window.location.href = '<?= base_url() ?>masterjasa/hapus_jasa/' + id;
			}
		})
	}
	// HAPUS DATA ----------------------------------------------------------------------------------- HAPUS DATA





	// DETAIL DATA ----------------------------------------------------------------------------------- DETAIL DATA
	function detail(id) {
		$.ajax({
			type: "GET",
			url: "<?= base_url() ?>masterjasa/getJasaById/" + id,
			dataType: 'JSON',
			success: function(response) {
				$('#detail_kode_jasa').html(response.kode_jasa);
				$('#detail_nama_jasa').html(response.nama_jasa);
				$('#detail_tarif').html('Rp. ' + format_rupiah(response.tarif));
				$('#detail_stok').html(response.stok);
				$('#modal-detail-jasa').modal('toggle');
			}
		})
	}
	// DETAIL DATA ----------------------------------------------------------------------------------- DETAIL DATA
</script>
