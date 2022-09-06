<main class="d-flex w-100" style="background: linear-gradient(to bottom left, #33ccff 0%, #ff99cc 100%)">
    <div class="container d-flex flex-column">
        <div class="row vh-100">
            <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                <div class="d-table-cell align-middle">

                    <div class="card">
                        <div class="card-body">
                            <div class="m-sm-4">
                                <div class="text-center">
                                    <h1 class="h2"><?= $profil_toko['nama'] ?></h1>
                                    <p class="lead">
                                        <?= $profil_toko['keterangan'] ?>
                                    </p>
                                </div>

                                <div class="text-center mb-3">
                                    <img src="<?= base_url() ?>assets/logo/<?= $profil_toko['logo'] ?>" alt="Charles Hall" class="img-fluid rounded-circle" width="132" height="132" />
                                </div>

                                <?= $this->session->flashdata('Pesan'); ?>

                                <form autocomplete="off" method="POST" action="<?= base_url('auth') ?>">

                                    <div class="mb-3">
                                        <!-- <label class="form-label">Username</label> -->
                                        <input class="form-control form-control-lg" style="text-align: center;" type="username" name="username" placeholder="Masukan username" />
                                        <?= form_error('username', '<small class="text-danger pl-3">', '</small>') ?>
                                    </div>
                                    <div class="mb-3">
                                        <!-- <label class="form-label">Password</label> -->
                                        <input class="form-control form-control-lg" style="text-align: center;" type="password" name="password" placeholder="Masukan password" />
                                        <?= form_error('password', '<small class="text-danger pl-3">', '</small>') ?>
                                    </div>

                                    <div class="text-center mt-3">
                                        <button type="submit" class="btn btn-block btn-lg btn-outline-primary"> <strong> Login </strong></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>