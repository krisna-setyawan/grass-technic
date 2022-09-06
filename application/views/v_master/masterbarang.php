<main class="content" style="padding: 10px;">
    <!-- <div class="container" style="padding: 0px;"> -->

    <h1 class="h3 mb-2 ml-3">Master Barang</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body" style="padding: 15px;">

                    <?= $this->session->flashdata('pesan') ?>

                    <button class="btn btn-sm btn-success mb-3" data-toggle="modal" data-target="#modal-tambah-barang">Tambah Barang</button>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" style="border: solid 1px #E5E8E8;white-space: nowrap" id="dataTable" width="100%">
                            <thead>
                                <tr class="text-center">
                                    <th width="5%">No</th>
                                    <th width="10%">Kode</th>
                                    <th width="32%">Nama Barang</th>
                                    <th width="11%">Harga Beli</th>
                                    <th width="11%">Harga Jual</th>
                                    <th width="11%">Stok</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($barang as $br) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $br->kode_barang ?></td>
                                        <td><?= $br->nama_barang ?></td>
                                        <td>Rp. <?= number_format($br->harga_beli, 0, ',', '.') ?></td>
                                        <td>Rp. <?= number_format($br->harga_jual, 0, ',', '.') ?></td>
                                        <td><?= $br->stok ?></td>
                                        <td class="text-center">
                                            <a>
                                                <button onclick="detail(<?= $br->id ?>)" class="badge btn-secondary">Detail</button>
                                            </a>
                                            <a>
                                                <button onclick="edit(<?= $br->id ?>)" class="badge btn-info">Edit</button>
                                            </a>
                                            <a>
                                                <button onclick="hapus(<?= $br->id ?>)" class="badge btn-danger">Hapus</button>
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

<!-- Modal add barang -->
<div class="modal fade" id="modal-tambah-barang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Barang</h5>
                <button type="button" onclick="batal_tambah()" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate autocomplete="off" id="form_tambah" method="POST" action="<?= base_url() ?>masterbarang/add_barang_aksi">
                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label">Kode Barang</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-lg" id="kode_barang" name="kode_barang" required>
                            <div class="invalid-feedback">Kode Barang harus diisi.</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label">Nama Barang</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-lg" id="nama_barang" name="nama_barang" required>
                            <div class="invalid-feedback">Nama Barang harus diisi.</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label">Harga Beli</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-lg" id="harga_beli" name="harga_beli" required>
                            <div class="invalid-feedback">Harga Beli harus diisi.</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label">Harga Jual</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-lg" id="harga_jual" name="harga_jual" required>
                            <div class="invalid-feedback">Harga Jual harus diisi.</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label">Hrg Reseller 1</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-lg" id="hg_reseller1" name="hg_reseller1" required>
                            <div class="invalid-feedback">Harga Jual ke Reseller Kelas 1 harus diisi.</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label">Hrg Reseller 2</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-lg" id="hg_reseller2" name="hg_reseller2" required>
                            <div class="invalid-feedback">Harga Jual ke Reseller Kelas 2 harus diisi.</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label">Hrg Reseller 3</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-lg" id="hg_reseller3" name="hg_reseller3" required>
                            <div class="invalid-feedback">Harga Jual ke Reseller Kelas 3 harus diisi.</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label">Hrg Reseller 4</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-lg" id="hg_reseller4" name="hg_reseller4" required>
                            <div class="invalid-feedback">Harga Jual ke Reseller Kelas 4 harus diisi.</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label">Stok Awal</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-lg" id="stok" name="stok" required>
                            <div class="invalid-feedback">Jumlah Stok awal harus diisi.</div>
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

<!-- Modal edit barang -->
<div class="modal fade" id="modal-edit-barang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Barang</h5>
                <button type="button" onclick="batal_edit()" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate autocomplete="off" id="form_edit" method="POST" action="<?= base_url() ?>masterbarang/edit_barang_aksi">
                    <input type="hidden" name="edit_id" id="edit_id">
                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label">Kode Barang</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-lg" id="edit_kode_barang" name="edit_kode_barang" required>
                            <div class="invalid-feedback">Kode Barang harus diisi.</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label">Nama Barang</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-lg" id="edit_nama_barang" name="edit_nama_barang" required>
                            <div class="invalid-feedback">Nama Barang harus diisi.</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label">Harga Beli</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-lg" id="edit_harga_beli" name="edit_harga_beli" required>
                            <div class="invalid-feedback">Harga Beli harus diisi.</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label">Harga Jual</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-lg" id="edit_harga_jual" name="edit_harga_jual" required>
                            <div class="invalid-feedback">Harga Jual harus diisi.</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label">Hrg Reseller 1</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-lg" id="edit_hg_reseller1" name="edit_hg_reseller1" required>
                            <div class="invalid-feedback">Harga Jual ke Reseller Kelas 1 harus diisi.</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label">Hrg Reseller 2</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-lg" id="edit_hg_reseller2" name="edit_hg_reseller2" required>
                            <div class="invalid-feedback">Harga Jual ke Reseller Kelas 2 harus diisi.</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label">Hrg Reseller 3</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-lg" id="edit_hg_reseller3" name="edit_hg_reseller3" required>
                            <div class="invalid-feedback">Harga Jual ke Reseller Kelas 3 harus diisi.</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label">Hrg Reseller 4</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-lg" id="edit_hg_reseller4" name="edit_hg_reseller4" required>
                            <div class="invalid-feedback">Harga Jual ke Reseller Kelas 4 harus diisi.</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label">Stok Sekarang</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-lg" id="edit_stok" name="edit_stok" required>
                            <div class="invalid-feedback">Jumlah Stok sekarang harus diisi.</div>
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

<!-- Modal detail barang -->
<div class="modal fade" id="modal-detail-barang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="font-size: large;">
                <div class="row">
                    <div class="col-6">
                        <p>Kode Barang</p>
                    </div>
                    <div class="col-6">
                        <p><b id="detail_kode_barang"></b></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <p>Nama Barang</p>
                    </div>
                    <div class="col-6">
                        <p><b id="detail_nama_barang"></b></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <p>Harga Beli</p>
                    </div>
                    <div class="col-6">
                        <p><b id="detail_harga_beli"></b></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <p>Harga Jual</p>
                    </div>
                    <div class="col-6">
                        <p><b id="detail_harga_jual"></b></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <p>Harga Jual Reseller 1</p>
                    </div>
                    <div class="col-6">
                        <p><b id="detail_hg_reseller1"></b></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <p>Harga Jual Reseller 2</p>
                    </div>
                    <div class="col-6">
                        <p><b id="detail_hg_reseller2"></b></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <p>Harga Jual Reseller 3</p>
                    </div>
                    <div class="col-6">
                        <p><b id="detail_hg_reseller3"></b></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <p>Harga Jual Reseller 4</p>
                    </div>
                    <div class="col-6">
                        <p><b id="detail_hg_reseller4"></b></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <p>Stok</p>
                    </div>
                    <div class="col-6">
                        <p><b id="detail_stok"></b></p>
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

        $('#dataTable').dataTable({
            "ordering": false
        });

        // Format mata uang.
        $('#harga_beli').mask('000.000.000', {
            reverse: true
        });
        $('#harga_jual').mask('000.000.000', {
            reverse: true
        });
        $('#hg_reseller1').mask('000.000.000', {
            reverse: true
        });
        $('#hg_reseller2').mask('000.000.000', {
            reverse: true
        });
        $('#hg_reseller3').mask('000.000.000', {
            reverse: true
        });
        $('#hg_reseller4').mask('000.000.000', {
            reverse: true
        });

        $('#edit_harga_beli').mask('000.000.000', {
            reverse: true
        });
        $('#edit_harga_jual').mask('000.000.000', {
            reverse: true
        });
        $('#edit_hg_reseller1').mask('000.000.000', {
            reverse: true
        });
        $('#edit_hg_reseller2').mask('000.000.000', {
            reverse: true
        });
        $('#edit_hg_reseller3').mask('000.000.000', {
            reverse: true
        });
        $('#edit_hg_reseller4').mask('000.000.000', {
            reverse: true
        });
    });





    // ADD DATA ----------------------------------------------------------------------------------- ADD DATA
    function batal_tambah() {
        $('#kode_barang').val("");
        $('#nama_barang').val("");
        $('#harga_beli').val("");
        $('#harga_jual').val("");
        $('#hg_reseller1').val("");
        $('#hg_reseller2').val("");
        $('#hg_reseller3').val("");
        $('#hg_reseller4').val("");
        $('#stok').val("");
        $('#form_tambah').removeClass('was-validated')
    }
    // ADD DATA ----------------------------------------------------------------------------------- ADD DATA





    // EDIT DATA ----------------------------------------------------------------------------------- EDIT DATA
    function batal_edit() {
        $('#edit_kode_barang').val("");
        $('#edit_nama_barang').val("");
        $('#edit_harga_beli').val("");
        $('#edit_harga_jual').val("");
        $('#edit_hg_reseller1').val("");
        $('#edit_hg_reseller2').val("");
        $('#edit_hg_reseller3').val("");
        $('#edit_hg_reseller4').val("");
        $('#edit_stok').val("");
        $('#form_edit').removeClass('was-validated')
    }

    function edit(id) {
        $.ajax({
            type: "GET",
            url: "<?= base_url() ?>masterbarang/getBarangById/" + id,
            dataType: 'JSON',
            success: function(response) {
                $('#edit_id').val(response.id);
                $('#edit_kode_barang').val(response.kode_barang);
                $('#edit_nama_barang').val(response.nama_barang);
                $('#edit_harga_beli').val(format_rupiah(response.harga_beli));
                $('#edit_harga_jual').val(format_rupiah(response.harga_jual));
                $('#edit_hg_reseller1').val(format_rupiah(response.hg_reseller1));
                $('#edit_hg_reseller2').val(format_rupiah(response.hg_reseller2));
                $('#edit_hg_reseller3').val(format_rupiah(response.hg_reseller3));
                $('#edit_hg_reseller4').val(format_rupiah(response.hg_reseller4));
                $('#edit_stok').val(response.stok);
                $('#modal-edit-barang').modal('toggle');
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
                window.location.href = '<?= base_url() ?>masterbarang/hapus_barang/' + id;
            }
        })
    }
    // HAPUS DATA ----------------------------------------------------------------------------------- HAPUS DATA





    // DETAIL DATA ----------------------------------------------------------------------------------- DETAIL DATA
    function detail(id) {
        $.ajax({
            type: "GET",
            url: "<?= base_url() ?>masterbarang/getBarangById/" + id,
            dataType: 'JSON',
            success: function(response) {
                $('#detail_kode_barang').html(response.kode_barang);
                $('#detail_nama_barang').html(response.nama_barang);
                $('#detail_harga_beli').html('Rp. ' + format_rupiah(response.harga_beli));
                $('#detail_harga_jual').html('Rp. ' + format_rupiah(response.harga_jual));
                $('#detail_hg_reseller1').html('Rp. ' + format_rupiah(response.hg_reseller1));
                $('#detail_hg_reseller2').html('Rp. ' + format_rupiah(response.hg_reseller2));
                $('#detail_hg_reseller3').html('Rp. ' + format_rupiah(response.hg_reseller3));
                $('#detail_hg_reseller4').html('Rp. ' + format_rupiah(response.hg_reseller4));
                $('#detail_stok').html(response.stok);
                $('#modal-detail-barang').modal('toggle');
            }
        })
    }
    // DETAIL DATA ----------------------------------------------------------------------------------- DETAIL DATA
</script>