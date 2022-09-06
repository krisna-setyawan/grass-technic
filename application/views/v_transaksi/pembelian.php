<main class="content" style="padding: 10px;">
    <!-- <div class="container" style="padding: 0px;"> -->

    <h1 class="h3 mb-2 ml-3">Data Pembelian</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body" style="padding: 15px;">

                    <?= $this->session->flashdata('pesan') ?>

                    <button class="btn btn-sm btn-success mb-3" id="btn-add-pembelian">Tambah Pembelian</button>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" style="border: solid 1px #E5E8E8; white-space: nowrap" id="dataTable" width="100%">
                            <thead>
                                <tr class="text-center">
                                    <th width="5%">No</th>
                                    <th width="12%">Nomor</th>
                                    <th width="10%">Tanggal</th>
                                    <th width="35%">Nama Suplier</th>
                                    <th width="13%">Total</th>
                                    <th width="10%">Status</th>
                                    <th width="15%">Aksi</th>
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

<!-- Modal add pembelian -->
<div class="modal fade" id="modal-tambah-pembelian" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Pembelian</h5>
                <button type="button" onclick="batal_tambah()" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate autocomplete="off" id="form_tambah" method="POST" action="<?= base_url() ?>pembelian/add_pembelian_aksi">
                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label">No Pembelian</label>
                        <div class="col-sm-9">
                            <input readonly type="text" class="form-control form-control-lg" id="no_pembelian" name="no_pembelian" required>
                            <div class="invalid-feedback">No Pembelian harus diisi.</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label">Pilih Suplier</label>
                        <div class="col-sm-9">
                            <select class="custom-select form-control" id="id_suplier" name="id_suplier" required>
                                <option value="" selected>-- Pilih Suplier --</option>
                                <?php foreach ($suplier as $sp) : ?>
                                    <option value="<?= $sp->id ?>"><?= $sp->nama ?></option>
                                <?php endforeach ?>
                            </select>
                            <div class="invalid-feedback">Suplier harus diisi.</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label">Tanggal Pembelian</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-lg" id="tanggal" name="tanggal" required>
                            <div class="invalid-feedback">Tanggal Pembelian harus diisi.</div>
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

<!-- Modal detail pembelian -->
<div class="modal fade" id="modal-detail-pembelian" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Pembelian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <strong style="font-size: larger;"><?= $profil_toko['nama'] ?></strong>
                            <div class="text-muted">No Pembelian &nbsp; <strong id="detail_no_pembelian">210609001</strong> </div>
                            <div class="text-muted">Tanggal &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <strong id="detail_tanggal">09 Juni 2021</strong> </div>
                        </div>
                        <div class="col-md-6 text-md-right">
                            <div class="text-muted">Pembelian ke</div>
                            <strong id="detail_nama_suplier">Nama Suplier</strong>
                            <p id="detail_alamat_suplier" class="mb-2">Alamat Suplier</p>
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
                            <th colspan="3" class="text-right"> Grand Total </th>
                            <th class="text-right" id="detail_grand_total">Rp. 0</th>
                        </tr>
                    </table>

                    <div class="text-center mt-5 mb-3">
                        <a href="#" class="btn btn-primary">
                            Print Nota Pembelian
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
                "url": "<?= base_url('pembelian/get_data') ?>",
                "type": "POST",
            },
            // "order": [
            //     [1, "desc"]
            // ],

            "ordering": false,
            columnDefs: [{
                "targets": [5, 6],
                "className": 'text-center'
            }, {
                "targets": [0, 6],
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




        // ADD PEMBELIAN
        $('#btn-add-pembelian').click(function() {
            $.ajax({
                type: "GET",
                url: "<?= base_url() ?>pembelian/no_trx_auto",
                dataType: 'JSON',
                success: function(response) {
                    $('#no_pembelian').val(response);
                }
            })
            $('#modal-tambah-pembelian').modal({
                backdrop: 'static',
                keyboard: false
            })
        })
    })





    // ADD DATA PEMBELIAN -------------------------------------------------------------------------- ADD DATA PEMBELIAN
    function batal_tambah() {
        $('#id_suplier').val("");
        $('#tanggal').val("");
        $('#form_tambah').removeClass('was-validated')
    }
    // ADD DATA PEMBELIAN -------------------------------------------------------------------------- ADD DATA PEMBELIAN




    // RESUME TRANSAKSI PEMBELIAN ------------------------------------------------------------------- RESUME TRANSAKSI PEMBELIAN
    function resume(id) {
        window.location = '<?= base_url() ?>pembelian/buat/' + id;
    }
    // RESUME TRANSAKSI PEMBELIAN ------------------------------------------------------------------- RESUME TRANSAKSI PEMBELIAN





    // HAPUS DATA PEMBELIAN ------------------------------------------------------------------------- HAPUS DATA PEMBELIAN
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
                window.location.href = '<?= base_url() ?>pembelian/hapus_pembelian/' + id;
            }
        })
    }
    // HAPUS DATA PEMBELIAN ------------------------------------------------------------------------- HAPUS DATA PEMBELIAN





    // DETAIL DATA PEMBELIAN ------------------------------------------------------------------------- DETAIL DATA PEMBELIAN
    function detail(id_pembelian) {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>pembelian/get_detail",
            data: '&id_pembelian=' + id_pembelian,
            dataType: 'JSON',
            success: function(response) {
                $('#detail_nama_suplier').html(response.nama_suplier);
                $('#detail_alamat_suplier').html(response.alamat_suplier);
                $('#detail_no_pembelian').html(response.no_pembelian);
                $('#detail_tanggal').html(response.tanggal);
                $('#detail_grand_total').html('Rp. ' + format_rupiah(response.grand_total));
            }
        })
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>pembelian/get_detail_list",
            data: '&id_pembelian=' + id_pembelian,
            success: function(html) {
                $('#detail_list_barang').html(html);
            }
        })

        $('#modal-detail-pembelian').modal('toggle');
    }
    // DETAIL DATA PEMBELIAN ------------------------------------------------------------------------- DETAIL DATA PEMBELIAN
</script>