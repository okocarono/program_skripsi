<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>
    <title>Pencarian Kata Tidak Baku</title>
  </head>
  <body>
    <div class="container">
      <h1 class="display-4 text-center" onclick="debug()">Pencarian Kata Tidak Baku</h1>

      <input type="hidden" id="id_dokumen" value="<?= $dokumen->id_dokumen ?>">
      <input type="hidden" id="lokasi_dokumen" value="<?= $dokumen->file_path ?>">
      <hr>
      <div class="row">
	<div class="col-5">
    <h3>Summary</h3>

    <table>
        <tr>
            <td><h5>Total kata di dokumen</h5></td>
            <td><h5>:</h5></td>
            <td><h5><span id="total_kata_dokumen">0</span> kata.</h5></td>
        </tr>
        <tr>
            <td><h5>Total kata & simbol yang dibuang</h5></td>
            <td><h5>:</h5></td>
            <td><h5><span id="total_kata_dibuang">0</span> kata.</h5></td>
        </tr>
        <tr>
            <td><h5>Total kata di stemming</h5></td>
            <td><h5>:</h5></td>
            <td><h5><span id="total_kata">0</span> kata.</h5></td>
        </tr>
        <tr>
            <td><h5>Total kata baku </h5></td>
            <td><h5>:</h5></td>
            <td><h5><span id="total_kata_baku">0</span> kata.</h5></td>
        </tr>
        <tr>
            <td><h5>Total kata tidak baku</h5></td>
            <td><h5>:</h5></td>
            <td><h5><span id="total_masalah">0</span> kata.</h5></td>
        </tr>
        <tr>
            <td><h5>Total waktu eksekusi</h5></td>
            <td><h5>:</h5></td>
            <td><h5><span id="total_waktu_eksekusi">0</span> detik.</h5></td>
        </tr>
    </table>
    
	  <small class="text-danger font-weight-bold">* Kata tidak baku bisa berupa nama orang, bahasa asing, akronim, dan merek</small>
	  <br>
    <small class="text-danger font-weight-bold">* Jika rekomendasi kata kosong maka kata bisa berupa nama orang, bahasa asing, akronim, dan merek</small>
    <br>
	</div>
	<div class="col-7">
	  <h3>Kata tidak baku dan rekomendasi kata baku</h3>
	  <div style="height: 300px; overflow-y: scroll">
	    <table class="table">
	      <tbody id="list_tidak_baku">
	      </tbody>
	    </table>
	  </div>
	</div>
  </div>
      <hr>
      <button type="button" id="tombol" onclick="tampilkan_data()" class="btn btn-primary mt-2">Tampilkan</button>
    <div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script>
      let id_dokumen = document.getElementById('id_dokumen');
      let total_kata = document.getElementById('total_kata');
      let total_kata_baku = document.getElementById('total_kata_baku');
      let total_kata_dokumen = document.getElementById('total_kata_dokumen');
      let total_kata_dibuang = document.getElementById('total_kata_dibuang');
      let total_masalah = document.getElementById('total_masalah');
      let total_waktu_eksekusi = document.getElementById('total_waktu_eksekusi');
      let tombol = document.getElementById('tombol');

      let list_tidak_baku = document.getElementById('list_tidak_baku');
      let rekomendasi_kata = document.getElementById('rekomendasi_kata');

      const load_data = async (id_dokumen, lokasi_dokumen) => {
		  return await axios.post('http://127.0.0.1:5000/index', {
		  	id: id_dokumen,
		  	lokasi: lokasi_dokumen
		  }).then(res => {
		      return res.data;
		  })
      }

      const cek_data = async () => {
      	return await axios.post('http://127.0.0.1:5000/testing', {
		  	id: 1,
		  	lokasi: 'once again'
		  }).then(res => {
		      return res.data;
		  })
	  }

      const debug = async () => {
      	id_dokumen = document.getElementById('id_dokumen');
      	lokasi_dokumen = document.getElementById('lokasi_dokumen');

      	let result = await cek_data().then(res => res);

      	console.log(lokasi_dokumen)
      	console.log('Hasil', result);
      }
      
      const tampilkan_data = async () => {
      	  id_dokumen = document.getElementById('id_dokumen');
      	  lokasi_dokumen = document.getElementById('lokasi_dokumen');

		  tombol.classList.add("disabled");
		  tombol.innerText = 'Sedang Proses';
		  let result = await load_data(id_dokumen.value, lokasi_dokumen.value).then(res => res);
		  console.log(result)
		  if(result) {
		      tombol.classList.remove("disabled");
		      tombol.innerText = 'Tampilkan';
		  }
		  total_kata.innerText = result.total_kata;
		  total_kata_baku.innerText = result.total_kata_baku;
      total_kata_dokumen.innerText = result.total_kata_dokumen;
		  total_kata_dibuang.innerText = result.dibuang;
		  total_masalah.innerText = result.total_masalah;
      total_waktu_eksekusi.innerText = result.total_waktu_eksekusi.toFixed(2);
      
      // rekomendasi_kata.innerText = result.masalah;

      let saran_kata = result.masalah;
      let kata_dibuang = result.masalah_baru;

      // custom
      let koreksi = result.koreksi;
      let rekomendasi_koreksi = result.rekomendasi_koreksi;

      let saran = '';
      let sementara = '';

      rekomendasi_koreksi.forEach(res => {
          saran += `<tr><td>Berikut beberapa saran entri lain yang mirip. ${res}</td></tr>`;
      });

      saran_kata.forEach(res => {
          saran += `<tr><td>${res}</td></tr>`;
      });

      // rekomendasi_kata.innerHTML = saran;
      
      let i = 0;
      koreksi.forEach(res => {
        sementara += `<tr><td>${res} <span class='text-danger'>tidak baku</span> : Berikut beberapa saran entri lain yang mirip. ${rekomendasi_koreksi[i]}</td></tr>`;   
        i++;
      });

      i = 0;
      kata_dibuang.forEach(res => {
        sementara += `<tr><td>${res} <span class='text-danger'>tidak baku</span> : ${saran_kata[i]}</td></tr>`;
        i++;
      });


		  list_tidak_baku.innerHTML = sementara;  
      }
    </script>
  </body>
</html>
