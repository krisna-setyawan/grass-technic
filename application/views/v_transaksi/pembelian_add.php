<body onload="load_data_pembelian('<?= $pembelian['id'] ?>')"></body>
<main class="content" style="padding: 10px;">
    <!-- <div class="container" style="padding: 0px;"> -->

    <h1 class="h3 mb-2 ml-3">Transaksi Pembelian</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body" style="padding: 15px;">

                    <input type="hidden" id="id_pembelian" name="id_pembelian" value="<?= $pembelian['id'] ?>">
                    <input type="hidden" id="id_suplier" name="id_suplier" value="<?= $pembelian['id_suplier'] ?>">
                    <input type="hidden" id="id_barang" name="id_barang">
                    <input type="hidden" id="grand_total" name="grand_total">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group input-group-lg mb-2 mr-sm-2">
                                <div class="input-group-text"><b>Suplier</b></div>
                                <input readonly type="text" class="form-control" id="nama_suplier" name="nama_suplier" value="<?= $pembelian['nama_suplier'] ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group input-group-lg mb-2 mr-sm-2">
                                <div class="input-group-text"><b>Tanggal</b></div>
                                <input readonly type="text" class="form-control" id="tanggal" name="tanggal" value="<?= $pembelian['tanggal'] ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group input-group-lg mb-2 mr-sm-2">
                                <div class="input-group-text"><b>No Pembelian</b></div>
                                <input readonly type="text" class="form-control" id="no_pembelian" name="no_pembelian" value="<?= $pembelian['no_pembelian'] ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group input-group-lg mb-2 mr-sm-2">
                                <div class="input-group-text"><b>Barang</b></div>
                                <input type="text" class="form-control" id="nama_barang" name="nama_barang" onkeyup="autocomplete_barang()" maxlength="50">
                                <div id="barang_list"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group input-group-lg mb-2 mr-sm-2">
                                <div class="input-group-text"><b>Hg Satuan</b></div>
                                <input readonly type="text" class="form-control" id="harga_beli" name="harga_beli">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group input-group-lg mb-2 mr-sm-2">
                                <div class="input-group-text"><b>Stok</b></div>
                                <input readonly type="text" class="form-control" id="stok" name="stok">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group input-group-lg mb-2 mr-sm-2">
                                <div class="input-group-text"><b>Jumlah</b></div>
                                <input type="text" class="form-control" id="jumlah_barang" name="jumlah_barang" onkeypress="return hanyaAngka(event)" maxlength="6">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group input-group-lg mb-2 mr-sm-2">
                                <div class="input-group-text"><b>Hg Total</b></div>
                                <input readonly type="text" class="form-control" id="hg_total" name="hg_total">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button onclick="validasi_add_list_pembelian()" class="btn btn-lg btn-block btn-primary">Tambahkan Barang</button>
                        </div>
                    </div>

                    <hr>

                    <div class="table-responsive mt-3">
                        <table class="table table-hover table-success table-bordered table-striped" style="white-space: nowrap" id="dataTable" width="100%">
                            <thead>
                                <tr class="text-center">
                                    <th width="5%">No</th>
                                    <th width="10%">Kode Brg</th>
                                    <th width="37%">Nama Barang</th>
                                    <th width="10%">Qty</th>
                                    <th width="15%">Hg Satuan</th>
                                    <th width="15%">Total</th>
                                    <th width="8%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="list_data_pembelian">

                            </tbody>
                            <tr>
                                <td colspan="5" style="font-size: larger; text-align: right; padding-right: 5%;"> <b> Grand Total </b> </td>
                                <td colspan="2" id="text_grand_total" style="font-size: larger;"></td>
                            </tr>
                        </table>
                    </div>

                    <hr>

                    <div class="row justify-content-end mt-4">
                        <div class="col-md-4">
                            <button onclick="validasi_simpan_pembelian(<?= $pembelian['id'] ?>)" class="btn btn-lg btn-block btn-success">Simpan Pembelian</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- </div> -->
</main>

<script>
    function load_data_pembelian(id_pembelian) {
        $.ajax({
            type: 'post',
            url: '<?= base_url() ?>pembelian/load_data_pembelian',
            data: '&id_pembelian=' + id_pembelian,
            success: function(html) {
                $('#list_data_pembelian').html(html);
            }
        })
        $.ajax({
            type: 'post',
            url: '<?= base_url() ?>pembelian/load_grand_total',
            data: '&id_pembelian=' + id_pembelian,
            dataType: 'JSON',
            success: function(data) {
                let g_total = format_rupiah(data.grand_total);
                $('#text_grand_total').html('<b> Rp. ' + g_total + '</b>');
                $('#grand_total').val(data.grand_total);
            }
        })
    }

    function autocomplete_barang() {
        $("#nama_barang").autocomplete({
            source: "<?php echo base_url('pembelian/barang_autocomplete'); ?>",
        });
    }

    $("#nama_barang").change(function() {
        let nm_brg = $(this).val();
        if (nm_brg != '') {
            $.ajax({
                url: "<?= base_url() ?>pembelian/get_barang_autocomplete",
                type: "post",
                data: "&nm_brg=" + nm_brg,
                dataType: 'JSON',
                success: function(data) {
                    if (data.kodeku == 'ada') {
                        $('#id_barang').val(data.id);
                        $('#harga_beli').val(data.harga_beli);
                        $('#stok').val(data.stok);
                        $('#hg_total').val('');
                        $('#jumlah_barang').val('');
                    } else {
                        $('#harga_beli').val('');
                        $('#stok').val('');
                        $('#hg_total').val('');
                        $('#jumlah_barang').val('');
                    }
                }
            });
        } else {
            $('#harga_beli').val('');
            $('#stok').val('');
            $('#hg_total').val('');
            $('#jumlah_barang').val('');
        }
    })

    $("#jumlah_barang").change(function() {
        let jml_brg = $(this).val();
        let hg_brg = $('#harga_beli').val();
        let stok = $('#stok').val();
        let barang = $('#nama_barang').val();

        let fix_stok = parseFloat(stok);
        let fix_jml_brg = parseFloat(jml_brg);

        if (barang != '') {
            if (fix_jml_brg != '') {
                let hg_total = fix_jml_brg * hg_brg;
                $('#hg_total').val(hg_total);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal...',
                    text: 'Jumlah barang tidak bisa 0!',
                })
                $('#hg_total').val('');
            }
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Gagal...',
                text: 'Barang belum dipilih!',
            })
            $('#hg_total').val('');
        }

    })

    function tambahListBarang() {
        let id_pembelian = $('#id_pembelian').val();
        $.ajax({
            type: 'post',
            url: '<?= base_url() ?>pembelian/add_list',
            data: '&id_pembelian=' + $('#id_pembelian').val() +
                '&id_suplier=' + $('#id_suplier').val() +
                '&id_barang=' + $('#id_barang').val() +
                '&no_pembelian=' + $('#no_pembelian').val() +
                '&jumlah=' + $('#jumlah_barang').val() +
                '&hg_satuan=' + $('#harga_beli').val() +
                '&hg_total=' + $('#hg_total').val(),
            success: function() {
                Swal.fire(
                    'Berhasil!',
                    'Berhasil menambah barang !',
                    'success'
                )
                $('#nama_barang').val('');
                $('#harga_beli').val('');
                $('#stok').val('');
                $('#jumlah_barang').val('');
                $('#hg_total').val('');
                load_data_pembelian(id_pembelian);
            }
        })
    }

    function hapus_list(id_detail) {
        let id_pembelian = $('#id_pembelian').val();
        $.ajax({
            type: 'post',
            url: '<?= base_url() ?>pembelian/delete_list',
            data: '&id_detail=' + id_detail,
            success: function() {
                Swal.fire(
                    'Berhasil!',
                    'Berhasil menghapus barang !',
                    'success'
                )
                $('#nama_barang').val('');
                $('#harga_beli').val('');
                $('#stok').val('');
                $('#jumlah_barang').val('');
                $('#hg_total').val('');
                load_data_pembelian(id_pembelian);
            }
        })
    }

    function validasi_simpan_pembelian(id_pembelian) {
        $.ajax({
            url: "<?= base_url() ?>pembelian/validasi_simpan_beli",
            type: "post",
            data: "&id_pembelian=" + id_pembelian,
            dataType: 'JSON',
            success: function(data) {
                if (data.kodeku == 'ada') {
                    simpan_pembelian(id_pembelian);
                } else {
                    Swal.fire(
                        'Maaf...',
                        'Anda belum melakukan pembelian apapun !',
                        'error'
                    )
                }
            }
        });
    }

    function simpan_pembelian(id_pembelian) {
        var grand_total = $('#grand_total').val();
        $.ajax({
            type: 'post',
            url: '<?= base_url() ?>pembelian/simpan_pembelian',
            data: '&grand_total=' + grand_total + '&id_pembelian=' + id_pembelian,
            success: function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Berhasil simpan transaksi pembelian !',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then(function() {
                    window.location.href = "<?= base_url() ?>pembelian";
                });;
            }
        })
    }
</script>