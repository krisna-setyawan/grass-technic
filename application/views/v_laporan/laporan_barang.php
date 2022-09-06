<main class="content" style="padding: 10px; background-color: #E7E7E7;">
    <!-- <div class="container" style="padding: 0px;"> -->

    <h1 class="h3 mb-2 ml-3">Laporan Barang</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body" style="padding: 15px;">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>5 Barang Stock Tersedikit</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered table-warning table-hover table-striped" style="white-space: nowrap" width="100%">
                                    <thead>
                                        <tr class="text-center">
                                            <th width="5%">No</th>
                                            <th width="75%">Nama Barang</th>
                                            <th width="25%">Stok</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($sedikit as $sd) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $sd->nama_barang ?></td>
                                                <td><?= $sd->stok ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h4>5 Barang Stock Terbanyak</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered table-primary table-hover table-striped" style="white-space: nowrap" width="100%">
                                    <thead>
                                        <tr class="text-center">
                                            <th width="5%">No</th>
                                            <th width="75%">Nama Barang</th>
                                            <th width="25%">Stock</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($banyak as $by) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $by->nama_barang ?></td>
                                                <td><?= $by->stok ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- </div> -->
</main>