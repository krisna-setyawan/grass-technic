<main class="content" style="padding: 10px;">
    <!-- <div class="container" style="padding: 0px;"> -->

    <h1 class="h3 mb-2 ml-3">Pengaturan</h1>


    <div class="card">
        <div class="card-body" style="padding: 15px;">
            <?= $this->session->flashdata('pesan') ?>
            <div style="background-color: #F7F5F4;">
                <div class="mb-5">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a href="#toko" class="nav-link active" data-toggle="tab" id="pengaturan_toko">
                                <p class="mt-2 mb-2 judul-pav"> <b> Pengaturan Toko </b> </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#user" class="nav-link" data-toggle="tab" id="pengaturan_user">
                                <p class="mt-2 mb-2 judul-pav"> <b> Pengaturan User </b> </p>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">

                        <!-- PENGATURAN TOKO -->
                        <div class="tab-pane fade show active" id="toko">
                            <form class="needs-validation" novalidate autocomplete="off" action="<?= base_url() ?>pengaturan/edit_profil" method="POST" enctype="multipart/form-data">
                                <div class="mb-3 mt-4 row">
                                    <label class="col-form-label col-form-label-lg col-sm-2 text-sm-right">Nama Toko</label>
                                    <div class="col-sm-9">
                                        <input required value="<?= $profil_toko['nama'] ?>" type="text" name="nama" class="form-control form-control-lg" placeholder="Nama Toko">
                                        <div class="invalid-feedback">Nama Toko harus diisi.</div>
                                    </div>
                                </div>
                                <div class="mb-3 mt-4 row">
                                    <label class="col-form-label col-form-label-lg col-sm-2 text-sm-right">Keterangan</label>
                                    <div class="col-sm-9">
                                        <input required value="<?= $profil_toko['keterangan'] ?>" type="text" name="keterangan" class="form-control form-control-lg" placeholder="Keterangan Toko">
                                        <div class="invalid-feedback">Keterangan harus diisi.</div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-form-label col-form-label-lg col-sm-2 text-sm-right">Telepon</label>
                                    <div class="col-sm-9">
                                        <input required value="<?= $profil_toko['telepon'] ?>" type="text" name="telepon" class="form-control form-control-lg" placeholder="Telepon">
                                        <div class="invalid-feedback">No Telp Toko harus diisi.</div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-form-label col-form-label-lg col-sm-2 text-sm-right">Alamat Toko</label>
                                    <div class="col-sm-9">
                                        <textarea required name="alamat" class="form-control form-control-lg" placeholder="Alamat Toko" rows="2" style="resize: none;"><?= $profil_toko['alamat'] ?></textarea>
                                        <div class="invalid-feedback">Alamat Toko harus diisi.</div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-form-label col-form-label-lg col-sm-2 text-sm-right">Logo Toko</label>
                                    <div class="col-sm-2">
                                        <img id="logo_toko" src="<?= base_url() ?>assets/logo/<?= $profil_toko['logo'] ?>" width="100%" height="100%" alt="">
                                    </div>
                                    <div class="col-sm-7">
                                        <input class="form-control input-logo" type="file" name="logo" id="logo">
                                        <div class="invalid-feedback">Logo Toko harus diisi.</div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div class="col-sm-10 ml-sm-auto">
                                        <button type="submit" class="btn btn-primary">SIMPAN</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- PENGATURAN TOKO -->

                        <!-- PENGATURAN USER -->
                        <div class="tab-pane fade" id="user">
                            <button class="btn btn-sm btn-success mb-3 mt-4" data-toggle="modal" data-target="#modal-tambah-user">Tambah User</button>

                            <div class="table-responsive">
                                <table class="table table-bordered table-light" style="border: solid 1px #E5E8E8; white-space: nowrap" id="dataTable" width="100%">
                                    <thead>
                                        <tr class="text-center">
                                            <th width="5%">No</th>
                                            <th width="35%">Nama User</th>
                                            <th width="20%">Username</th>
                                            <th width="20%">Password</th>
                                            <th width="20%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($user as $usr) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $usr->nama_user ?></td>
                                                <td><?= $usr->username ?></td>
                                                <td><?= $usr->password ?></td>
                                                <td class="text-center">
                                                    <a>
                                                        <button onclick="hak_menu(<?= $usr->id ?>)" class="badge btn-secondary">Menu</button>
                                                    </a>
                                                    <a>
                                                        <button onclick="edit(<?= $usr->id ?>)" class="badge btn-info">Edit</button>
                                                    </a>
                                                    <a>
                                                        <button onclick="hapus(<?= $usr->id ?>)" class="badge btn-danger">Hapus</button>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- PENGATURAN USER -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- </div> -->
</main>

<!-- Modal add user -->
<div class="modal fade" id="modal-tambah-user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah User</h5>
                <button type="button" onclick="batal_tambah()" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate autocomplete="off" id="form_tambah" method="POST" action="<?= base_url() ?>pengaturan/add_user_aksi">
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Nama User</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama_user" name="nama_user" required>
                            <div class="invalid-feedback">Nama User harus diisi.</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="username" name="username" required>
                            <div class="invalid-feedback">Username harus diisi.</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="password" name="password" required>
                            <div class="invalid-feedback">Password harus diisi.</div>
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
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal edit user -->
<div class="modal fade" id="modal-edit-user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                <button type="button" onclick="batal_edit()" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate autocomplete="off" id="form_edit" method="POST" action="<?= base_url() ?>pengaturan/edit_user_aksi">
                    <input type="hidden" name="edit_id" id="edit_id">
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Nama User</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="edit_nama_user" name="edit_nama_user" required>
                            <div class="invalid-feedback">Nama User harus diisi.</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="edit_username" name="edit_username" required>
                            <div class="invalid-feedback">Username harus diisi.</div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="edit_password" name="edit_password" required>
                            <div class="invalid-feedback">Password harus diisi.</div>
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

<!-- Modal menu user -->
<div class="modal fade" id="modal-menu-user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Menu User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered" id="datatable-menu" width="100%">
                        <thead>
                            <tr class="text-center">
                                <th width="5%">No</th>
                                <th width="75%">Menu</th>
                                <th width="20%" style="text-align: center">Akses</th>
                            </tr>
                        </thead>
                        <tbody id="isi_tabel">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Selesai</button>
            </div>
        </div>
    </div>
</div>



<script>
    // PENGATURAN TOKO
    $(document).ready(function() {
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 3000);
    });





    $(document).ready(function() {
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 4000);


        $('#dataTable').dataTable({
            "ordering": false
        });
    });





    // ADD DATA ----------------------------------------------------------------------------------- ADD DATA
    function batal_tambah() {
        $('#nama_user').val("");
        $('#username').val("");
        $('#password').val("");
    }
    // ADD DATA ----------------------------------------------------------------------------------- ADD DATA





    // EDIT DATA ----------------------------------------------------------------------------------- EDIT DATA
    function batal_edit() {
        $('#edit_nama_user').val("");
        $('#edit_username').val("");
        $('#edit_password').val("");
    }

    function edit(id) {
        $.ajax({
            type: "GET",
            url: "<?= base_url() ?>pengaturan/edit_user/" + id,
            dataType: 'JSON',
            success: function(response) {
                $('#edit_id').val(response.id);
                $('#edit_nama_user').val(response.nama_user);
                $('#edit_username').val(response.username);
                $('#edit_password').val(response.password);
                $('#modal-edit-user').modal('toggle');
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
                window.location.href = '<?= base_url() ?>pengaturan/hapus_user/' + id;
            }
        })
    }
    // HAPUS DATA ----------------------------------------------------------------------------------- HAPUS DATA





    // MENU DATA ----------------------------------------------------------------------------------- MENU DATA
    function hak_menu(id) {
        $.ajax({
            url: '<?= base_url() ?>pengaturan/get_hak_menu',
            type: 'post',
            data: '&id_user=' + id,
            success: function(html) {
                $('#isi_tabel').html(html);
                $('#modal-menu-user').modal('toggle');
            }
        });
    }

    function beri_menu(id_menu, id_user) {
        $.ajax({
            url: '<?= base_url('pengaturan/beri_hak_menu') ?>',
            type: 'post',
            data: "&id_menu=" + id_menu +
                "&id_user=" + id_user,
            success: function() {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Berhasil edit hak akses menu!',
                    icon: 'success',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                })
            }
        });
    }
    // MENU DATA ----------------------------------------------------------------------------------- MENU DATA
</script>