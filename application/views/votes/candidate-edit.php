    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

        <div class="row">
        	<div class="col-lg-8">
        		<form action="" method="POST" enctype="multipart/form-data">
        			<input type="hidden" name="id" value="<?= $candidate['id']; ?>">

        			<div class="form-group row">
						    <label for="nim" class="col-sm-2 col-form-label">NIM</label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control" id="nim" name="nim" value="<?= $candidate['nim']; ?>">
						      <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
						    </div>
						  </div>

						  <div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">Full Name</label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control" id="name" name="name" value="<?= $candidate['name']; ?>">
						      <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
						    </div>
						  </div>

						  <div class="form-group row">
						    <div class="col-sm-2">Picture</div>
						    <div class="col-sm-10">
						    	<div class="row">
						    		<div class="col-sm-3">
						    			<img src="<?= base_url('assets/img/candidate/').$candidate['image']; ?>" class="img-thumbnail">
						    		</div>
						    		<div class="col-sm-9">
						    			<div class="custom-file">
											  <input type="file" class="custom-file-input" id="image" name="image">
											  <label class="custom-file-label" for="image">Choose file</label>
											</div>
						    		</div>
						    	</div>
						    </div>
						  </div>

						  <div class="form-group row">
						    <label for="vision" class="col-sm-2 col-form-label">Vision</label>
						    <div class="col-sm-10">
						      <textarea class="form-control" id="vision" name="vision" rows="3" placeholder="visi oleh kandidat"><?= $candidate['vision']; ?></textarea>
						    </div>
						  </div>

						  <div class="form-group row">
						    <label for="mission" class="col-sm-2 col-form-label">Mission</label>
						    <div class="col-sm-10">
						      <textarea class="form-control" id="mission" name="mission" rows="9" placeholder="misi oleh kandidat"><?= $candidate['mission']; ?></textarea>
						    </div>
						  </div>

						  <div class="form-group row justify-content-end">
						  	<div class="col-sm-10">
						  		<a type="button" href="<?= base_url('votes/candidate'); ?>" class="btn btn-secondary" >Cancel</a>
						  		<button type="submit" class="btn btn-primary">Edit</button>
						  	</div>
						  </div>

        		</form>
        	</div>
        </div>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

            