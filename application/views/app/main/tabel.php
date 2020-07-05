<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Pencarian Kata Baku dan Tidak Baku</title>
  </head>
  <body>
    <div class="container">
      <h1 class="display-4 text-center">Dokumen</h1>
      <div class="row">
      	<?php if($this->session->flashdata('pesan')): ?>
      	<div class="col-12 mt-2 text-center">
      		<?= $this->session->flashdata('pesan'); ?>
      	</div>
        <?php endif; ?>
		<div class="col-12 my-2">
		  <button type="button" data-toggle="modal" data-target="#unggahModal"  class="btn btn-success float-right">Unggah Dokumen</button>
		</div>
		<div class="col-12">
		  <table class="table table-striped">
		    <thead>
		      <th>#</th>
		      <th>Nama Dokumen</th>
		      <th>Tanggal diunggah</th>
		      <th>Aksi</th>
		    </thead>
		    <tbody>
		      <?php if($dokumen): ?>
			      <tr>
					<td>1.</td>
					<td><?= $dokumen->nama_dokumen; ?></td>
					<td><?= date('d/m/Y', strtotime($dokumen->tanggal)) ?></td>
					<td>
					  <a href="<?= base_url('App/rincian/') . $dokumen->id_dokumen ?>" class="badge badge-sm badge-pill badge-success text-white py-2">Lihat Dokumen</a>
					</td>
			      </tr>
			  <?php endif; ?>
		    </tbody>
		  </table>
		</div>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="unggahModal" tabindex="-1" role="dialog" aria-labelledby="unggahModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Unggah Dokumen</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
		  </div>
		  <form action="<?= base_url('App/file_upload') ?>" method="post" enctype="multipart/form-data">
			  <div class="modal-body">
	            <div class="form-group">
			      <label>Pilih Dokumen</label>
			      <input type="file" name="dokumen" class="form-control">
			      <small class="text-danger">File yang diunggah harus berupa doc, docx</small>
			    </div>
			  </div>
			  <div class="modal-footer">
	            <button type="button" class="btn btn-secondary" data-dismiss="modal">Ga jadi</button>
	            <button type="submit" class="btn btn-primary">Unggah Sekarang</button>
			  </div>
		  </form>
		</div>
      </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    
  </body>
</html>
