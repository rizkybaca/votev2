<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
    	<div class="col-lg-3 mb-3">
    		<?= form_open_multipart('votes/import');?>
	    		<div class="custom-file mb-2">
				    <input type="file" class="custom-file-input" id="file" name="file" accept=".xlsx, .xls">
				    <label class="custom-file-label" for="file">Upload csv voter</label>
				  </div>
				  <button class="btn btn-primary" type="submit" name="upload">Upload</button>
				</form>
    	</div>
    </div>

    <div class="row">
    	<div class="col-lg-6">

    		<?= $this->session->flashdata('message'); ?>
    		<table class="table table-hover">
				  <thead>
				    <tr>
				      <th scope="col">#</th>
				      <th scope="col">NIM</th>
				      <th scope="col">Name</th>
				      <th scope="col">Action</th>
				    </tr>
				  </thead>
				  <tbody>
				  	<?php if (!empty($voter)) : ?>
				  	<?php $i=1; foreach ($voter as $v) : ?>
				    <tr>
				      <th scope="row"><?= $i++; ?></th>
				      <td><?= $v['nim']; ?></td>
				      <td><?= $v['name']; ?></td>
				      <td>
				      	<a href="<?= base_url('votes/voteredit/').$v['id']; ?>" class="badge badge-success">edit</a>
				      	<a href="<?= base_url('votes/voterdelete/').$v['id']; ?>" class="badge badge-danger">delete</a>
				      </td>
				    </tr>
				    <?php endforeach; ?>
				  	<?php else : ?>
				  		<tr>
				  			<td colspan="4">No voter(s) found..</td>
				  		</tr>
				  	<?php endif; ?>
				  </tbody>
				</table>
    	</div>
    </div>

</div>
<!-- /.container-fluid -->