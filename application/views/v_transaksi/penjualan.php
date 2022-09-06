<main class="content" style="padding: 10px;">
    <!-- <div class="container" style="padding: 0px;"> -->

    <h1 class="h3 mb-2 ml-3">Data Penjualan</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body" style="padding: 15px;">

                    <?= $this->session->flashdata('pesan') ?>

                    <button class="btn btn-sm btn-success mb-3" id="btn-add-penjualan">Tambah Penjualan</button>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" style="border: solid 1px #E5E8E8; white-space: nowrap" id="dataTable" width="100%">
                            <thead>
                                <tr class="text-center">
                                    <th width="4%">No</th>
                                    <th width="11%">Nomor</th>
                                    <th width="10%">Tanggal</th>
                                    <th width="10%">Jenis</th>
                                    <th width="29%">Nama Pembeli</th>
                                    <th width="13%">Total</th>
                                    <th width="10%">Status</th>
                                    <th width="13%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- </div> -->
</main>

<!-- Modal add penjualan -->
<div class="modal fade" id="modal-tambah-penjualan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Penjualan</h5>
                <button type="button" onclick="batal_tambah()" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate autocomplete="off" id="form_tambah" method="POST" action="<?= base_url() ?>penjualan/add_penjualan_aksi">
                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label">No Penjualan</label>
                        <div class="col-sm-9">
                            <input readonly type="text" class="form-control form-control-lg" id="no_penjualan" name="no_penjualan" required>
                            <div class="invalid-feedback">No Penjualan harus diisi.</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label">Pilih Jenis Penjualan</label>
                        <div class="col-sm-9">
                            <select class="custom-select form-control" id="jenis_penjualan" name="jenis_penjualan" required>
                                <option value="" selected>-- Jenis Penjualan --</option>
                                <option value="Umum">Umum</option>
                                <option value="Pelanggan">Pelanggan</option>
                                <option value="Reseller">Reseller</option>
                            </select>
                            <div class="invalid-feedback">Jenis Penjualan harus diisi.</div>
                        </div>
                    </div>

                    <div class="form-group row mb-3" hidden id="div_id_pelanggan">
                        <label class="col-sm-3 col-form-label">Pilih Pelanggan</label>
                        <div class="col-sm-9">
                            <select class="custom-select form-control" id="id_pelanggan" name="id_pelanggan" required>
                                <option value="" selected>-- Pilih Pelanggan --</option>
                                <?php foreach ($pelanggan as $sp) : ?>
                                    <option value="<?= $sp->id ?>"><?= $sp->nama ?></option>
                                <?php endforeach ?>
                            </select>
                            <div class="invalid-feedback">Pelanggan harus diisi.</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3" hidden id="div_id_reseller">
                        <label class="col-sm-3 col-form-label">Pilih Reseller</label>
                        <div class="col-sm-9">
                            <select class="custom-select form-control" id="id_reseller" name="id_reseller" required>
                                <option value="" selected>-- Pilih Reseller --</option>
                                <?php foreach ($reseller as $sp) : ?>
                                    <option value="<?= $sp->id ?>"><?= $sp->nama ?></option>
                                <?php endforeach ?>
                            </select>
                            <div class="invalid-feedback">Reseller harus diisi.</div>
                        </div>
                    </div>

                    <div class="form-group row mb-3" hidden id="div_nama_pembeli">
                        <label class="col-sm-3 col-form-label">Nama Pembeli</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-lg" id="nama_pembeli" name="nama_pembeli" required>
                            <div class="invalid-feedback">Nama Pembeli harus diisi.</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3" hidden id="div_alamat_pembeli">
                        <label class="col-sm-3 col-form-label">Alamat Pembeli</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-lg" id="alamat_pembeli" name="alamat_pembeli" required>
                            <div class="invalid-feedback">Alamat Pembeli harus diisi.</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3" hidden id="div_no_telp_pembeli">
                        <label class="col-sm-3 col-form-label">No Telp Pembeli</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-lg" id="no_telp_pembeli" name="no_telp_pembeli" required>
                            <div class="invalid-feedback">No Telp Pembeli harus diisi.</div>
                        </div>
                    </div>

                    <!-- KELAS RESELLER -->
                    <div class="form-group row mb-3" hidden id="div_kelas_reseller">
                        <label class="col-sm-3 col-form-label">Kelas Reseller</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-lg" id="kelas_reseller" name="kelas_reseller" readonly required>
                            <div class="invalid-feedback">Kelas Reseller harus diisi.</div>
                        </div>
                    </div>


                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label">Tanggal Penjualan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-lg" id="tanggal" name="tanggal" required>
                            <div class="invalid-feedback">Tanggal Penjualan harus diisi.</div>
                        </div>
                    </div>
                    <div class="row mt-5 mb-4 justify-content-center">
                        <div class="col-md-3 mb-3">
                            <button type="button" class="btn btn-block btn-danger" data-dismiss="modal" onclick="batal_tambah()">Batal</button>
                        </div>
                        <div class="col-md-3 mb-3">
                            <button type="submit" class="btn btn-block btn-success">Lanjutkan</button>
                        </div>
                    </div>
            </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal detail penjualan -->
<div class="modal fade" id="modal-detail-penjualan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Penjualan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
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

                    <div class="text-center mt-5 mb-3">
                        <a href="#" class="btn btn-secondary">
                            Print Nota Penjualan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var table = $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "<?= base_url('penjualan/get_data') ?>",
                "type": "POST",
            },
            // "order": [
            //     [1, "desc"]
            // ],

            "ordering": false,
            columnDefs: [{
                "targets": [6, 7],
                "className": 'text-center'
            }, {
                "targets": [0, 7],
                "orderable": false,
            }],
        })

        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 3000);




        // DATEPICKER TANGGAL PEMBELIAN
        $('#tanggal').datetimepicker({
            datepicker: true,
            timepicker: false,
            format: 'Y-m-d',
            weeks: false,
            yearStart: 2000,
            yearEnd: 2030,
            scrollInput: false,
            scrollMonth: false,
        });




        // ADD PENJUALAN
        $('#btn-add-penjualan').click(function() {
            $.ajax({
                type: "GET",
                url: "<?= base_url() ?>penjualan/no_trx_auto",
                dataType: 'JSON',
                success: function(response) {
                    $('#no_penjualan').val(response);
                }
            })
            $('#modal-tambah-penjualan').modal({
                backdrop: 'static',
                keyboard: false
            })
        })
    })





    // ADD DATA PENJUALAN -------------------------------------------------------------------------- ADD DATA PENJUALAN
    function batal_tambah() {
        $('#jenis_penjualan').val("");
        $('#id_pelanggan').val("");
        $('#id_reseller').val("");
        $('#nama_pembeli').val("");
        $('#alamat_pembeli').val("");
        $('#no_telp_pembeli').val("");
        $('#kelas_reseller').val('0');
        $('#tanggal').val("");
        $('#form_tambah').removeClass('was-validated')
        // ---------------------------------------------
        $('#div_id_pelanggan').attr('hidden', true);
        $('#div_id_reseller').attr('hidden', true);
        $('#div_nama_pembeli').attr('hidden', true);
        $('#div_alamat_pembeli').attr('hidden', true);
        $('#div_no_telp_pembeli').attr('hidden', true);
    }

    $("#jenis_penjualan").change(function() {
        let jenis_penjualan = $(this).val();
        if (jenis_penjualan == '') {
            $('#div_id_pelanggan').attr('hidden', true);
            $('#div_id_reseller').attr('hidden', true);
            $('#div_nama_pembeli').attr('hidden', true);
            $('#div_alamat_pembeli').attr('hidden', true);
            $('#div_no_telp_pembeli').attr('hidden', true);
            $('#div_kelas_reseller').attr('hidden', true);
            // ---------------------------------------------
            $('#nama_pembeli').val('');
            $('#alamat_pembeli').val('');
            $('#no_telp_pembeli').val('');
            $('#kelas_reseller').val('0');
        } else if (jenis_penjualan == 'Umum') {
            $('#div_id_pelanggan').attr('hidden', true);
            $('#div_id_reseller').attr('hidden', true);
            $('#div_nama_pembeli').attr('hidden', false);
            $('#div_alamat_pembeli').attr('hidden', false);
            $('#div_no_telp_pembeli').attr('hidden', false);
            $('#div_kelas_reseller').attr('hidden', true);
            // ---------------------------------------------
            $('#id_pelanggan').attr('required', false);
            $('#id_reseller').attr('required', false);
            // ---------------------------------------------
            $('#nama_pembeli').val('');
            $('#alamat_pembeli').val('');
            $('#no_telp_pembeli').val('');
            $('#kelas_reseller').val('0');
        } else if (jenis_penjualan == 'Pelanggan') {
            $('#div_id_pelanggan').attr('hidden', false);
            $('#div_id_reseller').attr('hidden', true);
            $('#div_nama_pembeli').attr('hidden', false);
            $('#div_alamat_pembeli').attr('hidden', false);
            $('#div_no_telp_pembeli').attr('hidden', false);
            $('#div_kelas_reseller').attr('hidden', true);
            // ---------------------------------------------
            $('#id_pelanggan').attr('required', true);
            $('#id_reseller').attr('required', false);
            // ---------------------------------------------
            $('#nama_pembeli').val('');
            $('#alamat_pembeli').val('');
            $('#no_telp_pembeli').val('');
            $('#kelas_reseller').val('0');
        } else if (jenis_penjualan == 'Reseller') {
            $('#div_id_pelanggan').attr('hidden', true);
            $('#div_id_reseller').attr('hidden', false);
            $('#div_nama_pembeli').attr('hidden', false);
            $('#div_alamat_pembeli').attr('hidden', false);
            $('#div_no_telp_pembeli').attr('hidden', false);
            $('#div_kelas_reseller').attr('hidden', false);
            // ---------------------------------------------
            $('#id_pelanggan').attr('required', false);
            $('#id_reseller').attr('required', true);
            // ---------------------------------------------
            $('#nama_pembeli').val('');
            $('#alamat_pembeli').val('');
            $('#no_telp_pembeli').val('');
            $('#kelas_reseller').val('');
        }
    })

    $("#id_pelanggan").change(function() {
        let id_pelanggan = $(this).val();
        if (id_pelanggan != '') {
            $.ajax({
                type: "POST",
                url: "<?= base_url() ?>penjualan/get_pelanggan",
                data: '&id_pelanggan=' + id_pelanggan,
                dataType: 'JSON',
                success: function(response) {
                    $('#nama_pembeli').val(response.nama);
                    $('#alamat_pembeli').val(response.alamat);
                    $('#no_telp_pembeli').val(response.no_telp);
                }
            })
        } else {
            $('#nama_pembeli').val('');
            $('#alamat_pembeli').val('');
            $('#no_telp_pembeli').val('');
        }
    })

    $("#id_reseller").change(function() {
        let id_reseller = $(this).val();
        if (id_reseller != '') {
            $.ajax({
                type: "POST",
                url: "<?= base_url() ?>penjualan/get_reseller",
                data: '&id_reseller=' + id_reseller,
                dataType: 'JSON',
                success: function(response) {
                    $('#nama_pembeli').val(response.nama);
                    $('#alamat_pembeli').val(response.alamat);
                    $('#no_telp_pembeli').val(response.no_telp);
                    $('#kelas_reseller').val(response.kelas);
                }
            })
        } else {
            $('#nama_pembeli').val('');
            $('#alamat_pembeli').val('');
            $('#no_telp_pembeli').val('');
            $('#kelas_reseller').val('');
        }
    })
    // ADD DATA PENJUALAN -------------------------------------------------------------------------- ADD DATA PENJUALAN





    // RESUME TRANSAKSI PENJUALAN ------------------------------------------------------------------- RESUME TRANSAKSI PENJUALAN
    function resume(id) {
        window.location = '<?= base_url() ?>penjualan/buat/' + id;
    }
    // RESUME TRANSAKSI PENJUALAN ------------------------------------------------------------------- RESUME TRANSAKSI PENJUALAN





    // HAPUS DATA PENJUALAN ------------------------------------------------------------------------- HAPUS DATA PENJUALAN
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
                window.location.href = '<?= base_url() ?>penjualan/hapus_penjualan/' + id;
            }
        })
    }
    // HAPUS DATA PENJUALAN ------------------------------------------------------------------------- HAPUS DATA PENJUALAN





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

        $('#modal-detail-penjualan').modal({
            backdrop: 'static',
            keyboard: false
        });
    }
    // DETAIL DATA PENJUALAN ------------------------------------------------------------------------- DETAIL DATA PENJUALAN
</script>