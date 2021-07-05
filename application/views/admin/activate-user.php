<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="row">
    	<div class="col-lg-6">
    		<?= $this->session->flashdata('message'); ?>
    	</div>
    </div>

    
    <div class="row">
    	<div class="col-lg-6">
    		<div class="card" style="width: 18rem;">
				  <div class="card-body">
				    <h5 class="card-title">Activate Committees</h5>
				    <p class="card-text">Button for activate comittee(s)</p>
				    <?php if ($committees[1]['is_active']==="0") : ?>
				    	<a href="<?= base_url('admin/activatecommittees'); ?>" class="btn btn-outline-primary">Activate</a>
				    <?php else : ?>
				    	<a href="<?= base_url('admin/nonactivatecommittees'); ?>" class="btn btn-outline-secondary">Nonactivate</a>
				    <?php endif; ?>
				  </div>
				</div>
    	</div>
    </div>
    

		<div class="card" style="width: 18rem;">
		  <div class="card-body">
		    <h5 class="card-title">Activate Voter</h5>
		    <p class="card-text">Button for activate voter(s)</p>
		    <?php if ($voter[1]['is_active']==="0") : ?>
		    	<a href="<?= base_url('admin/activatevoter'); ?>" class="btn btn-outline-primary">Activate</a>
		    <?php else : ?>
		    	<a href="<?= base_url('admin/nonactivatevoter'); ?>" class="btn btn-outline-secondary">Nonactivate</a>
		    <?php endif; ?>
		  </div>
		</div>


    </div>
</div>
<!-- /.container-fluid -->