<main class="content" style="padding: 10px;">
	<!-- <div class="container" style="padding: 0px;"> -->

	<h1 class="h3 mb-3">Dashboard</h1>


	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body" style="padding: 15px;">

					<div class="row mb-3">
						<div class="col-lg-6 col-xl-3 mb-4">
							<div class="card-ku">
								<div class="judul-card" style="background-color: #1AA09A;"></div>
								<div class="container-ku">
									<div class="row">
										<div class="col-8">
											<a href="<?= base_url() ?>/lihatbarang">
												<h4> Data Barang <br><br><b> <?= $jml_barang['jml_barang'] ?> Barang</b></h4>
											</a>
										</div>
										<div class="col-4">
											<a href="<?= base_url() ?>/lihatbarang">
												<img class="icon-dashboard" src="assets/icon/dashboard-icon-barang.png" style="width: 80px;" alt="">
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-xl-3 mb-4">
							<div class="card-ku">
								<div class="judul-card" style="background-color: #1AA09A;"></div>
								<div class="container-ku">
									<div class="row">
										<div class="col-8">
											<a href="<?= base_url() ?>/suplier">
												<h4> Data Suplier <br><br><b> <?= $jml_suplier ?> Suplier</b></h4>
											</a>
										</div>
										<div class="col-4">
											<a href="<?= base_url() ?>/suplier">
												<img class="icon-dashboard" src="assets/icon/dashboard-icon-suplier.png" style="width: 80px;" alt="">
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row mb-5">
						<div class="col-lg-6 mb-4">
							<table class="table table-secondary table-striped table-bordered table-hover">
								<thead>
									<tr>
										<td class="text-center" colspan="2">
											<a href="<?= base_url() ?>laporan/laporan_penjualan" style="font-size: larger; text-decoration: none; color: darkslategray;">
												<b>Laporan Penjualan</b>
											</a>
										</td>
									</tr>
								</thead>
								<tr>
									<td>Penjualan Hari ini</td>
									<td class="text-center"><?= $pj_hariini ?></td>
								</tr>
								<tr>
									<td>Penjualan Selesai</td>
									<td class="text-center"><?= $pj_selesai ?></td>
								</tr>
								<tr>
									<td>Penjualan Masih Proses</td>
									<td class="text-center"><?= $pj_proses ?></td>
								</tr>
							</table>
						</div>
						<div class="col-lg-6 mb-4">

						</div>
					</div>

				</div>
			</div>
		</div>
	</div>

	<!-- </div> -->
</main>

<script>

</script>
