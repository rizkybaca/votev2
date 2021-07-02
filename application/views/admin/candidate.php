<!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

        <div class="row">
        	<div class="col-lg-6">

        		<?= form_error('role', '<div class="alert alert-danger" role="alert">','</div>') ?>

        		<?= $this->session->flashdata('message'); ?>

        		<a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newRoleModal">Add New Candidate</a>

        		<table class="table table-hover">
						  <thead>
						    <tr>
						      <th scope="col">#</th>
						      <th scope="col">Role</th>
						      <th scope="col">Action</th>
						    </tr>
						  </thead>
						  <tbody>
						  	<?php $i=1; foreach ($candidate as $c) : ?>
						    <tr>
						      <th scope="row"><?= $i++; ?></th>
						      <td><?= $c['role']; ?></td>
						      <td>
						      	<a href="<?= base_url('admin/roleaccess/').$c['id']; ?>" class="badge badge-warning">access</a>
						      	<a href="" class="badge badge-success">edit</a>
						      	<a href="" class="badge badge-danger">hapus</a>
						      </td>
						    </tr>
						    <?php endforeach; ?>
						  </tbody>
						</table>
        	</div>
        </div>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal -->
<div class="modal fade" id="newRoleModal" tabindex="-1" aria-labelledby="newRoleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newRoleModalLabel">Add New Candidate</h5>
        <?= validation_errors(); ?>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?= form_open_multipart('admin/candidate');?>
	      <div class="modal-body">

	      	<div class="form-group">
				    <input type="text" class="form-control" id="nim" name="nim" placeholder="NIM">
				    <?= form_error('nim', '<small class="text-danger pl-3">', '</small>'); ?>
				  </div>
				  <div class="form-group">
				    <input type="text" class="form-control" id="name" name="name" placeholder="nama lengkap kandidat">
				    <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
				  </div>
				  <div class="form-group">
				    <div class="custom-file">
						  <input type="file" class="custom-file-input" id="image" name="image">
						  <label class="custom-file-label" for="image">pilih foto</label>
						</div>
				  </div>
				  <div class="form-group">
				    <textarea class="form-control" id="vision" name="vision" rows="3" placeholder="visi oleh kandidat"></textarea>
				    <?= form_error('vision', '<small class="text-danger pl-3">', '</small>'); ?>
				  </div>
				  <div class="form-group">
				    <textarea class="form-control" id="mission" name="mission" rows="3" placeholder="misi oleh kandidat"></textarea>
				    <?= form_error('mission', '<small class="text-danger pl-3">', '</small>'); ?>
				  </div>
	      </div>

	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary">Add</button>
	      </div>
      </form>
    </div>
  </div>
</div>