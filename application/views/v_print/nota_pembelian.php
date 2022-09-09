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
				<strong style="font-size: larger;"><?= $profil_toko['nama'] ?></strong>
				<div class="text-muted">No Pembelian &nbsp; <strong id="detail_no_pembelian"><?= $data_pembelian['no_pembelian'] ?></strong> </div>
				<div class="text-muted">Tanggal &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <strong id="detail_tanggal"><?= $data_pembelian['tanggal'] ?></strong> </div>
			</div>
			<div class="col-6 text-right">
				<div class="text-muted">Pembelian ke</div>
				<strong id="detail_nama_suplier"><?= $data_pembelian['nama_suplier'] ?></strong>
				<p id="detail_alamat_suplier" class="mb-2"><?= $data_pembelian['alamat_suplier'] ?></p>
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

			<tr>
				<th colspan="3" class="text-right"> Grand Total </th>
				<th class="text-right" id="detail_grand_total"><?= number_format($data_pembelian['grand_total'], 0, ',', '.') ?></th>
			</tr>
		</table>
	</div>


	<script src="<?= base_url() ?>assets/template/js/app.js"></script>

	<script>
		window.print();
	</script>

</body>

</html>
