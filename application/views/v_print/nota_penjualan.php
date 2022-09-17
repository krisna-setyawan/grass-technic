<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">


	<title>Print Nota</title>

	<!-- JQUERY -->
	<script src="<?= base_url() ?>assets/js/jquery-3.4.1.min.js"></script>

	<!-- MYCSS -->
	<link href="<?= base_url() ?>assets/css/mycss.css" rel="stylesheet">

	<!-- JQUERY MASK -->
	<script src="<?= base_url() ?>assets/jquery-mask/jquery.mask.js" crossorigin="anonymous"></script>

	<!-- KRISNA JS -->
	<script src="<?= base_url() ?>assets/js/myjs.js" crossorigin="anonymous"></script>

	<!-- JQUERY UI -->
	<link href="<?= base_url() ?>assets/jqueryui/jquery-ui.css" rel="stylesheet" />
	<script src="<?= base_url() ?>assets/jqueryui/jquery-ui.js" crossorigin="anonymous"></script>

	<!-- TEMPLATE BAWAAN -->
	<link href="<?= base_url() ?>assets/template/css/app.css" rel="stylesheet">

</head>

<body>

	<div class="container">
		<div class="row">
			<div class="col-6">
				<strong style="font-size: 20px;"><?= $profil_toko['nama'] ?></strong>
				<p class="mb-2">
					<?= $profil_toko['keterangan'] ?>
					<br> <?= $profil_toko['alamat'] ?>
					<br> <?= $profil_toko['telepon'] ?>
				</p>
			</div>
			<div class="col-6 text-right">
				<div class="text-muted">Customer</div>
				<strong id="detail_nama_pembeli"><?= $data_penjualan['nama_pembeli'] ?></strong>
				<div class="text-muted" id="detail_alamat_pembeli" class="mb-2"><?= $data_penjualan['alamat_pembeli'] ?></div>
				<div class="text-muted" id="detail_no_telp_pembeli" class="mb-2"><?= $data_penjualan['no_telp_pembeli'] ?></div>
			</div>
		</div>

		<div class="row mt-2">
			<div class="col-12">
				<div class="text-muted">No Nota &nbsp; &nbsp; <strong id="detail_no_penjualan"><?= $data_penjualan['no_penjualan'] ?></strong> </div>
				<div class="text-muted">Tanggal &nbsp; &nbsp; <strong id="detail_tanggal"><?= $data_penjualan['tanggal'] ?></strong> </div>
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
				<?= $list_barang ?>
			</tbody>
			<tbody id="detail_list_jasa">
				<?= $list_jasa ?>
			</tbody>
			<tbody id="detail_diskon">
				<?= $list_diskon ?>
			</tbody>

			<tr>
				<th colspan="3" class="text-right"> Total </th>
				<th class="text-right" id="detail_grand_total"><?= number_format($data_penjualan['grand_total'], 0, ',', '.') ?></th>
			</tr>
			<tr>
				<th colspan="3" class="text-right"> Bayar </th>
				<th class="text-right" id="detail_jumlah_bayar"><?= number_format($data_penjualan['jumlah_bayar'], 0, ',', '.') ?></th>
			</tr>
			<tr>
				<th colspan="3" class="text-right"> Kembalian </th>
				<th class="text-right" id="detail_jumlah_kembalian"><?= number_format($data_penjualan['jumlah_kembalian'], 0, ',', '.') ?></th>
			</tr>
		</table>

		<p id="detail_garansi"> <b>Garansi</b>: <?= $data_penjualan['garansi'] ?></p>
	</div>


	<script src="<?= base_url() ?>assets/template/js/app.js"></script>

	<script>
		window.print();
	</script>

</body>

</html>
