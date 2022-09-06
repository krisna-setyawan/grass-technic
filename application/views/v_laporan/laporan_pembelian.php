<body onload="load_data()"></body>
<main class="content" style="padding: 10px; background-color: #E7E7E7;">
    <!-- <div class="container" style="padding: 0px;"> -->

    <h1 class="h3 mb-2 ml-3">Laporan Pembelian</h1>

    <!-- <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3"> <b> Total Barang Pembelian </b> </h5>
                    <h1 class="mb-2">2.382</h1>
                    <div class="mb-1">
                        <span class="text-muted">Dalam Sebulan</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3"> <b> Total Nominal Pembelian </b> </h5>
                    <h1 class="mb-2">$21.300</h1>
                    <div class="mb-1">
                        <span class="text-muted">Dalam Sebulan</span>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body" style="padding: 15px;">

                    <div class="row mb-3">
                        <div class="col-md-8">
                            <h3 id="judul" class="mb-2 ml-3"> <b> Pembelian Bulan <?= date('m') ?> Tahun <?= date('Y') ?> </b> </h3>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group input-group-lg mb-2 mr-sm-2">
                                <select class="form-control" id="bulan">
                                    <option selected value="">Pilih Bulan</option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                                <select class="form-control" id="tahun">
                                    <option selected value="">Pilih Tahun</option>
                                    <option value="2021">2021</option>
                                    <option value="2020">2020</option>
                                    <option value="2019">2019</option>
                                </select>
                                <div class="btn btn-info" onclick="cari_data()"><i class="fas fa-search"></i> <b>Cari</b></div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="table-responsive">
                            <table class="table table-bordered table-secondary table-hover table-striped" style="white-space: nowrap" width="100%">
                                <thead>
                                    <tr class="text-center">
                                        <th width="5%">No</th>
                                        <th width="20%">Tanggal</th>
                                        <th width="25%">Jumlah Pembelian</th>
                                        <th width="50%">Jumlah Nominal Pembelian</th>
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
    // load data
    function load_data() {
        $.ajax({
            type: "GET",
            url: "<?= base_url() ?>laporan/get_laporan_pembelian_bulanan",
            success: function(html) {
                $('#isi-table').html(html);
            }
        });
    }

    function cari_data() {
        let bulan = $('#bulan').val();
        let tahun = $('#tahun').val();
        $.ajax({
            type: "POST",
            data: "&bulan=" + bulan + "&tahun=" + tahun,
            url: "<?= base_url() ?>laporan/get_laporan_pembelian_bulanan",
            success: function(html) {
                $('#judul').html('<b> Pembelian Bulan ' + bulan + ' Tahun ' + tahun + ' </b>');
                $('#isi-table').html(html);
            }
        });
    }
</script>