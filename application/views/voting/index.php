<!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

       
        		<?= $this->session->flashdata('message'); ?>       		

        		<?php foreach ($candidate as $c) : ?>

		        		<div class="card" style="width: 18rem;">
								  <img src="<?= base_url('assets/img/candidate/').$c['image']; ?>" class="card-img-top" alt="...">
								  <div class="card-body">
								    <h5 class="card-title"><?= $c['name']; ?></h5>
								    <p class="card-text"><?=  $c['nim']; ?></p>

								    <a href="<?= base_url('voting/detailcandidate/').$c['id']; ?>" class="btn btn-outline-primary">Detail Candidate</a>
								  </div>
								</div>
							

						<?php endforeach; ?>
    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->