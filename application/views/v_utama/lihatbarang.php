<main class="content" style="padding: 10px;">
    <!-- <div class="container" style="padding: 0px;"> -->

    <h1 class="h3 mb-2 ml-3">Lihat Data Barang</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body" style="padding: 15px;">

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" style="border: solid 1px #E5E8E8; white-space: nowrap" id="dataTable" width="100%">
                            <thead>
                                <tr class="text-center">
                                    <th width="5%">No</th>
                                    <th width="10%">Kode</th>
                                    <th width="40%">Nama Barang</th>
                                    <th width="19%">Harga Jual</th>
                                    <th width="13%">Stok</th>
                                    <th width="13%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($barang as $br) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $br->kode_barang ?></td>
                                        <td><?= $br->nama_barang ?></td>
                                        <td>Rp. <?= number_format($br->harga_jual, 0, ',', '.') ?></td>
                                        <td><?= $br->stok ?></td>
                                        <td class="text-center">
                                            <a>
                                                <button onclick="detail(<?= $br->id ?>)" class="badge btn-secondary">Detail</button>
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
    });





    // DETAIL DATA ----------------------------------------------------------------------------------- DETAIL DATA
    function detail(id) {
        $.ajax({
            type: "GET",
            url: "<?= base_url() ?>lihatbarang/getBarangById/" + id,
            dataType: 'JSON',
            success: function(response) {
                $('#detail_kode_barang').html(response.kode_barang);
                $('#detail_nama_barang').html(response.nama_barang);
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