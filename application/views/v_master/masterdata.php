<main class="content" style="padding: 10px;">
	<!-- <div class="container" style="padding: 0px;"> -->

	<h1 class="h3 mb-2 ml-3">Data Master</h1>

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body" style="padding: 15px;">

					<div class="row mb-3">
						<?php foreach ($menu_master as $mn) : ?>
							<div class="col-lg-6 col-xl-3 mb-4">
								<a href="<?= base_url() ?><?= $mn['url'] ?>" style="text-decoration: none ;">
									<div class="card-ku">
										<div class="judul-card" style="background-color: #C0392B;"></div>
										<div class="container-ku">
											<div class="row">
												<div class="col-12">
													<h4 class="mt-3 mb-3"> <b> <?= $mn['judul'] ?> </b> </h4>
												</div>
											</div>
										</div>
									</div>
								</a>
							</div>
						<?php endforeach; ?>
					</div>

				</div>
			</div>
		</div>
	</div>

	<!-- </div> -->
</main>
