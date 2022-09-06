<nav id="sidebar" class="sidebar js-sidebar">
	<div class="sidebar-content js-simplebar">
		<p class="sidebar-brand text-center">
			<img src="<?= base_url() ?>assets/logo/<?= $profil_toko['logo'] ?>" class="avatar img-fluid rounded mr-1" />
			<span class="align-middle"><?= $profil_toko['nama'] ?></span>
		</p>


		<!-- query untuk menu -->
		<?php
		$id_user = $this->session->userdata('id_user');
		$queryMenu = "  SELECT `user_menu`.*
                    FROM `user_menu` JOIN `user_access_menu` 
                    ON `user_menu`.`id` = `user_access_menu`.`id_menu`
                    WHERE `user_access_menu`.`id_user` = $id_user AND user_menu.sidebar = 'yes'
                    ORDER BY `user_access_menu`.`id_menu` ASC 
                ";
		$menu = $this->db->query($queryMenu)->result_array();
		?>


		<ul class="sidebar-nav">

			<!-- looping menu -->
			<?php
			foreach ($menu as $m) : ?>

				<li class="sidebar-item">
					<a class="sidebar-link" href="<?= base_url($m['url']) ?>">
						<i class="align-middle" data-feather="<?= $m['icon'] ?>"></i> <span class="align-middle"><?= $m['judul'] ?></span>
					</a>
				</li>

			<?php endforeach; ?>



			<li class="sidebar-header">
			</li>

			<li class="sidebar-item mb-5">
				<a class="sidebar-link" href="#" data-toggle="modal" data-target="#logout_modal">
					<i class="align-middle" data-feather="corner-down-left"></i> <span class="align-middle">Logout</span>
				</a>
			</li>
		</ul>
	</div>
</nav>

<div class="modal fade" id="logout_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header bg-warning">
				<h3 class="modal-title" id="exampleModalLabel"><strong>Logout ?</strong></h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				Anda yakin akan keluar sistem?
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-info" data-dismiss="modal">Batal</button>
				<a href="<?= base_url('auth/logout/') ?>">
					<button class="btn btn-danger">Keluar</button>
				</a>
			</div>
		</div>
	</div>
</div>
