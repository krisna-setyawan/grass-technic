<main class="content" style="padding: 10px; background-color: #E7E7E7;">
	<!-- <div class="container" style="padding: 0px;"> -->

	<h1 class="h3 mb-2 ml-3">Laporan Barang</h1>

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body" style="padding: 15px;">


					<div class="row">
						<div class="col-lg-6 mb-5">
							<div style="text-decoration: none ;">
								<div class="card-ku">
									<div class="judul-card" style="background-color: #F1C40F;"></div>
									<div class="container-ku">
										<div class="row">
											<div class="col-6">
												<h4 class="mt-3 mb-3"> <b> Total Modal</b> <br> (Belum terjual) </h4>
											</div>
											<div class="col-6">
												<h4 class="mt-3 mb-3"> Rp. <?= number_format($modal['total_modal'], 0, ',', '.') ?> </h4>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 mb-5">
							<div style="text-decoration: none ;">
								<div class="card-ku">
									<div class="judul-card" style="background-color: #F1C40F;"></div>
									<div class="container-ku">
										<div class="row">
											<div class="col-6">
												<h4 class="mt-3 mb-2"> <b> Barang Stok Habis </b> </h4>
											</div>
											<div class="col-6">
												<h4 class="mt-3 mb-2 text-right mr-5"> <b> <?= $habis['stok_habis'] ?> Barang </b> </h4>
											</div>
										</div>
										<h4 style="cursor: pointer; color:blue" onclick="lihat_barang_habis()" class="mb-2"> Lihat barang </h4>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<h4>10 Barang Stok Tersedikit</h4>
							<div class="table-responsive">
								<table class="table table-bordered table-warning table-hover table-striped" style="white-space: nowrap" width="100%">
									<thead>
										<tr class="text-center">
											<th width="5%">No</th>
											<th width="75%">Nama Barang</th>
											<th width="25%">Stok</th>
										</tr>
									</thead>
									<tbody>
										<?php $no = 1;
										foreach ($sedikit as $sd) : ?>
											<tr>
												<td><?= $no++ ?></td>
												<td><?= $sd->nama_barang ?></td>
												<td><?= $sd->stok ?></td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-md-6">
							<h4>10 Barang Stok Terbanyak</h4>
							<div class="table-responsive">
								<table class="table table-bordered table-primary table-hover table-striped" style="white-space: nowrap" width="100%">
									<thead>
										<tr class="text-center">
											<th width="5%">No</th>
											<th width="75%">Nama Barang</th>
											<th width="25%">Stok</th>
										</tr>
									</thead>
									<tbody>
										<?php $no = 1;
										foreach ($banyak as $by) : ?>
											<tr>
												<td><?= $no++ ?></td>
												<td><?= $by->nama_barang ?></td>
												<td><?= $by->stok ?></td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>

	<!-- </div> -->
</main>

<!-- Modal detail barang -->
<div class="modal fade" id="modal-barang-habis" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">List Barang Habis</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="font-size: large;">
				<div id="table-barang-habis"></div>
			</div>
		</div>
	</div>
</div>

<script>
	function lihat_barang_habis() {
		$.ajax({
			url: '<?= base_url() ?>laporan/barang_habis',
			type: 'get',
			dataType: 'json',
			success: function(html) {
				$('#table-barang-habis').html(html);
				$('#modal-barang-habis').modal('toggle');
				$('#dataTable').dataTable({
					"bPaginate": true,
					"bLengthChange": false,
					"bFilter": true,
					"bInfo": false,
					"bAutoWidth": false
				});
			}
		})
	}
</script>
