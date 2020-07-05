 <!DOCTYPE html>
 <html>
 <head>
 	<title>IR - STEMMING NAZIEF</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
     <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

 </head>
	<body>
    <nav class="navbar navbar-light bg-light">
      <a class="navbar-brand container-fluid" href="#">APLIKASI PENCARIAN KATA BAKU DAN KATA TIDAK BAKU</a>
    </nav>
		<div class="py-5 display-4 text-center"></div>
       <!--  <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <form method="post" action="<?= base_url(); ?>">
                        <label for="kalimat">Masukan Kalimat : </label>
                        <textarea name="kata" id="kata" class="form-control" cols="30" rows="10"><?= $kata ?></textarea>
                        <input type="submit" name="submit" class="btn btn-primary my-2" value="Submit"> <br>
                        <?= form_error('kata', '<small style="color: red;">', '</small>') ?>
                    </form>         
                </div>
                <div class="col-lg-6">
                    <label for="hasil">Kata Dasar :</label>
                    <textarea name="hasil" id="hasil" class="form-control" cols="30" rows="10"><?php if($stemming){ if(count($stemming) > 1) { $hitung = 1; foreach($stemming as $s) { if($hitung != count($stemming)) { echo $s.', '; } else { echo $s; } $hitung++; } } else { echo $stemming; } } ?></textarea>
                </div>
            </div>
        </div> -->

        <div class="container">
            <?php if($this->session->flashdata('pesan')): ?>
                <div class="row">
                    <div class="col-7 mx-auto text-center">
                        <?= $this->session->flashdata('pesan'); ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-7 mx-auto">
                    <div class="card">
                        <div class="card-header">Dokumen Word</div>
                            <div class="card-body">
                                <form action="<?= base_url('App/file_upload')?>" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="upload">Unggah File</label>
                                        <input type="file" multiple name="file" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary"> Unggah </button>
                                    </div>
                                </form>
                            </div>
                    </div>
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