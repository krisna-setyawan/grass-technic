<body onload="load_data()"></body>

<!-- // loading ajax -->
<div id='ajax-wait' style="display: none; position: fixed; z-index: 1999">
	<img alt='loading...' src='<?= base_url() ?>assets/icon/ajax-loader.gif' width='50' height='50' />
</div>

<main class="content" style="padding: 10px; background-color: #E7E7E7;">
	<!-- <div class="container" style="padding: 0px;"> -->

	<h1 class="h3 mb-2 ml-3">Laporan Keuntungan</h1>

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body" style="padding: 15px;">

					<div class="row mb-3">
						<div class="col-md-4 p-1">
							<h3 id="judul" class="mb-2 ml-3"> <b> Keuntungan Bulan <?= date('m') ?> Tahun <?= date('Y') ?> </b> </h3>
						</div>
						<div class="col-md-4">
							<div class="row text-right">
								<div class="col-6 p-1">
									Filter Berdasarkan:
								</div>
								<div class="col-6">
									<select class="form-control" id="filter" name="filter" onchange="ganti_filter()">
										<option selected value="bulanan">Perbulan</option>
										<option value="custom">Custom</option>
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div id="pencarian-filter-bulanan" class="input-group input-group-lg mb-2 mr-sm-2">
								<select class="form-control" id="bulan">
									<option selected value="">Pilih Bulan</option>
									<option value="01">Januari</option>
									<option value="02">Februari</option>
									<option value="03">Maret</option>
									<option value="04">April</option>
									<option value="05">Mei</option>
									<option value="06">Juni</option>
									<option value="07">Juli</option>
									<option value="08">Agustus</option>
									<option value="09">September</option>
									<option value="10">Oktober</option>
									<option value="11">November</option>
									<option value="12">Desember</option>
								</select>
								<select class="form-control" id="tahun">
									<option selected value="">Pilih Tahun</option>
									<option value="2022">2022</option>
									<option value="2021">2021</option>
									<option value="2020">2020</option>
								</select>
								<div class="btn btn-info" onclick="cari_data_bulanan()"><i class="fas fa-search"></i> <b>Cari</b></div>
							</div>

							<div hidden id="pencarian-filter-custom" class="input-group input-group-lg mb-2 mr-sm-2">
								<input autocomplete="off" id="tgl_awal" name="tgl_awal" type="text" class="form-control form-control-sm" placeholder="Tanggal Awal">
								<input autocomplete="off" id="tgl_akhir" name="tgl_akhir" type="text" class="form-control form-control-sm" placeholder="Tanggal Akhir">
								<div class="btn btn-info" onclick="cari_data_custom()"><i class="fas fa-search"></i> <b>Cari</b></div>
							</div>
						</div>
					</div>

					<div class="container">
						<div class="table-responsive">
							<table class="table table-bordered table-secondary table-hover table-striped" style="white-space: nowrap" width="100%">
								<thead>
									<tr class="text-center p-0" style="vertical-align: middle;">
										<th width="4%">No</th>
										<th width="11%">Tanggal</th>
										<th width="12%">Jml Penjualan</th>
										<th width="12%">Modal Beli</th>
										<th width="12%">Penjualan</th>
										<th width="12%">Jasa</th>
										<th width="12%">Total</th>
										<th width="12%">Keuntungan</th>
										<th width="13%">Keuntungan + Jasa</th>
									</tr>
								</thead>
								<tbody id="isi-table">

								</tbody>
							</table>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>

	<!-- </div> -->
</main>

<script>
	// loading ajax
	$(document).ajaxStart(function() {
		$("#ajax-wait").css({
			left: ($(window).width() - 32) / 2 + "px", // 32 = lebar gambar
			top: ($(window).height() - 32) / 2 + "px", // 32 = tinggi gambar
			display: "block"
		})
	}).ajaxComplete(function() {
		$("#ajax-wait").fadeOut();
	});

	$('#tgl_awal').datetimepicker({
		datepicker: true,
		timepicker: false,
		format: 'Y-m-d',
		weeks: false,
		yearStart: 2018,
		yearEnd: 2025,
		scrollInput: false,
		scrollMonth: false,
	});

	$('#tgl_akhir').datetimepicker({
		datepicker: true,
		timepicker: false,
		format: 'Y-m-d',
		weeks: false,
		yearStart: 2018,
		yearEnd: 2025,
		scrollInput: false,
		scrollMonth: false,
	});

	// load data
	function load_data() {
		$.ajax({
			type: "GET",
			url: "<?= base_url() ?>laporan/get_laporan_keuntungan_bulanan",
			success: function(html) {
				$('#isi-table').html(html);
			}
		});
	}

	function ganti_filter() {
		let filter = $('#filter').val();
		switch (filter) {
			case 'custom':
				$('#pencarian-filter-custom').attr('hidden', false);
				$('#pencarian-filter-bulanan').attr('hidden', true);
				break
			case 'bulanan':
				$('#pencarian-filter-custom').attr('hidden', true);
				$('#pencarian-filter-bulanan').attr('hidden', false);
				break
		}
	}

	function cari_data_bulanan() {
		let bulan = $('#bulan').val();
		let tahun = $('#tahun').val();
		$.ajax({
			type: "POST",
			data: "&bulan=" + bulan + "&tahun=" + tahun,
			url: "<?= base_url() ?>laporan/get_laporan_keuntungan_bulanan",
			success: function(html) {
				$('#judul').html('<b> Keuntungan Bulan ' + bulan + ' Tahun ' + tahun + ' </b>');
				$('#isi-table').html(html);
			}
		});
	}

	function cari_data_custom() {
		let tgl_awal = $('#tgl_awal').val();
		let tgl_akhir = $('#tgl_akhir').val();
		$.ajax({
			type: "POST",
			data: "&tgl_awal=" + tgl_awal + "&tgl_akhir=" + tgl_akhir,
			url: "<?= base_url() ?>laporan/get_laporan_keuntungan_custom",
			success: function(html) {
				$('#judul').html('<b> Keuntungan Tanggal <br> ' + tgl_awal + ' sampai ' + tgl_akhir + ' </b>');
				$('#isi-table').html(html);
			}
		});
	}
</script>
