<!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

        <div class="row">
        	<div class="col-lg">

        		<?= $this->session->flashdata('message'); ?>

        		

        		<?php foreach ($candidate as $c) : ?>
        			<div class="card-columns">
		        		<div class="card" style="width: 18rem;">
								  <img src="<?= base_url('assets/img/candidate/').$c['image']; ?>" class="card-img-top" alt="...">
								  <div class="card-body">
								    <h5 class="card-title"><?= $c['name']; ?></h5>
								    <p class="card-text"><?=  $c['nim']; ?></p>

								    <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newMenuModal">Detail Candidate</a>
								  </div>
								</div>
							</div>
						<?php endforeach; ?>

        	</div>
        </div>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal -->
<div class="modal fade" id="newMenuModal" tabindex="-1" aria-labelledby="newMenuModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newMenuModalLabel">Detail Candidate</h5>
        <?= validation_errors(); ?>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	      <div class="modal-body">

	      	<div class="card mb-3" style="max-width: 540px;">
					  <div class="row no-gutters">
					    <div class="col-md-4">
					      <img src=".." alt="...">
					    </div>
					    <div class="col-md-8">
					      <div class="card-body">
					        <h5 class="card-title"><?= $c['name']; ?></h5>
					        <small class="text-muted"><?= $c['nim']; ?></small>
					        <p class="card-text"><?= $c['vision']; ?></p>
					      </div>
					    </div>
					  </div>
					</div>

	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary">Add</button>
	      </div>
    </div>
  </div>
</div>