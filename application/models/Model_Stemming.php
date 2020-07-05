<?php  

    class Model_Stemming extends CI_Model {
        //fungsi untuk mengecek kata dalam tabel dictionary
function cekKamus($kata){ 
    $this->db->select('*');
    $this->db->from('dictionary');
    $this->db->where('word', $kata);
    $this->db->limit(1);
    return $this->db->get()->row_array();
}

//fungsi untuk menghapus suffix seperti -ku, -mu, -kah, dsb
function Del_Inflection_Suffixes($kata){ 
	$kataAsal = $kata;
	
	if(preg_match('/([km]u|nya|[kl]ah|pun)\z/i',$kata)){ // Cek Inflection Suffixes
		$__kata = preg_replace('/([km]u|nya|[kl]ah|pun)\z/i','',$kata);

		return $__kata;
	}
	return $kataAsal;
}

// Cek Prefix Disallowed Sufixes (Kombinasi Awalan dan Akhiran yang tidak diizinkan)
function Cek_Prefix_Disallowed_Sufixes($kata){

	if(preg_match('/^(be)[[:alpha:]]+/(i)\z/i',$kata)){ // be- dan -i
		return true;
	}

	if(preg_match('/^(se)[[:alpha:]]+/(i|kan)\z/i',$kata)){ // se- dan -i,-kan
		return true;
	}
	
	if(preg_match('/^(di)[[:alpha:]]+/(an)\z/i',$kata)){ // di- dan -an
		return true;
	}
	
	if(preg_match('/^(me)[[:alpha:]]+/(an)\z/i',$kata)){ // me- dan -an
		return true;
	}
	
	if(preg_match('/^(ke)[[:alpha:]]+/(i|kan)\z/i',$kata)){ // ke- dan -i,-kan
		return true;
	}
	return false;
}

// Hapus Derivation Suffixes ("-i", "-an" atau "-kan")
function Del_Derivation_Suffixes($kata){
	$kataAsal = $kata;
	if(preg_match('/(i|an)\z/i',$kata)){ // Cek Suffixes
		$__kata = preg_replace('/(i|an)\z/i','',$kata);
		if($this->cekKamus($__kata)){ // Cek Kamus
			return $__kata;
		}else if(preg_match('/(kan)\z/i',$kata)){
			$__kata = preg_replace('/(kan)\z/i','',$kata);
			if($this->cekKamus($__kata)){
				return $__kata;
			}
		}
/*– Jika Tidak ditemukan di kamus –*/
	}
	return $kataAsal;
}

// Hapus Derivation Prefix ("di-", "ke-", "se-", "te-", "be-", "me-", atau "pe-")
function Del_Derivation_Prefix($kata){
	$kataAsal = $kata;

	/* —— Tentukan Tipe Awalan ————*/
	if(preg_match('/^(di|[ks]e)/',$kata)){ // Jika di-,ke-,se-
		$__kata = preg_replace('/^(di|[ks]e)/','',$kata);
		
		if($this->cekKamus($__kata)){
			return $__kata;
		}
		
		$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			
		if($this->cekKamus($__kata__)){
			return $__kata__;
		}
		
		if(preg_match('/^(diper)/',$kata)){ //diper-
			$__kata = preg_replace('/^(diper)/','',$kata);
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
		
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
			
		}
		
		if(preg_match('/^(ke[bt]er)/',$kata)){  //keber- dan keter-
			$__kata = preg_replace('/^(ke[bt]er)/','',$kata);
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
		
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
		}
			
	}
	
	if(preg_match('/^([bt]e)/',$kata)){ //Jika awalannya adalah "te-","ter-", "be-","ber-"
		
		$__kata = preg_replace('/^([bt]e)/','',$kata);
		if($this->cekKamus($__kata)){
			return $__kata; // Jika ada balik
		}
		
		$__kata = preg_replace('/^([bt]e[lr])/','',$kata);	
		if($this->cekKamus($__kata)){
			return $__kata; // Jika ada balik
		}	
		
		$__kata__ = $this->Del_Derivation_Suffixes($__kata);
		if($this->cekKamus($__kata__)){
			return $__kata__;
		}
	}
	
	if(preg_match('/^([mp]e)/',$kata)){
		$__kata = preg_replace('/^([mp]e)/','',$kata);
		if($this->cekKamus($__kata)){
			return $__kata; // Jika ada balik
		}
		$__kata__ =$this-> Del_Derivation_Suffixes($__kata);
		if($this->cekKamus($__kata__)){
			return $__kata__;
		}
		
		if(preg_match('/^(memper)/',$kata)){
			$__kata = preg_replace('/^(memper)/','',$kata);
			if($this->cekKamus($kata)){
				return $__kata;
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
		}
		
		if(preg_match('/^([mp]eng)/',$kata)){
			$__kata = preg_replace('/^([mp]eng)/','',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
			
			$__kata = preg_replace('/^([mp]eng)/','k',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
		}
		
		if(preg_match('/^([mp]eny)/',$kata)){
			$__kata = preg_replace('/^([mp]eny)/','s',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
		}
		
		if(preg_match('/^([mp]e[lr])/',$kata)){
			$__kata = preg_replace('/^([mp]e[lr])/','',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
		}
		
		if(preg_match('/^([mp]en)/',$kata)){
			$__kata = preg_replace('/^([mp]en)/','t',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
			
			$__kata = preg_replace('/^([mp]en)/','',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
		}
			
		if(preg_match('/^([mp]em)/',$kata)){
			$__kata = preg_replace('/^([mp]em)/','',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
			
			$__kata = preg_replace('/^([mp]em)/','p',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			
			$__kata__ = $this->Del_Derivation_Suffixes($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
		}	
	}
	return $kataAsal;
}

//fungsi pencarian akar kata
function stemming($kata){ 

	$test = explode(' ', $kata);

	// echo count($test);
	// die;

	$hasil = [];

	if(count($test) > 1) {
		$cekKata = '';
		$sementara = '';
		for($i=0; $i<count($test); $i++) {
			$cekKata = $this->cekKamus($test[$i]);
			if($cekKata == true){ // Cek Kamus
				$sementara = $test[$i]; // Jika Ada maka kata tersebut adalah kata dasar
			}else{ //jika tidak ada dalam kamus maka dilakukan stemming
				$test[$i] = $this->Del_Inflection_Suffixes($test[$i]);
				if($this->cekKamus($test[$i])){
					$sementara = $test[$i];
				}

				if(!$this->cekKamus($test[$i])) {
					$test[$i] = $this->Del_Inflection_Suffixes($test[$i]);
					if($this->cekKamus($test[$i])){
						$sementara = $test[$i];
					}
				}
				
				$test[$i] = $this->Del_Derivation_Suffixes($test[$i]);
				if($this->cekKamus($test[$i])){
					$sementara = $test[$i];
				}
				
				$test[$i] = $this->Del_Derivation_Prefix($test[$i]);
				if($this->cekKamus($test[$i])){
					$sementara = $test[$i];
				}

				
			}

			$hasil[] = $sementara;
		}
		return $hasil;
	} else {
		$kataAsal = $kata;
	
		$cekKata = $this->cekKamus($kata);
		if($cekKata == true){ // Cek Kamus
			return $kata; // Jika Ada maka kata tersebut adalah kata dasar
		}else{ //jika tidak ada dalam kamus maka dilakukan stemming
			$hasil = '';
			
			$kata = $this->Del_Inflection_Suffixes($kata);
			if($this->cekKamus($kata)){
				$hasil = $kata;
			}
			
			if(!$this->cekKamus($kata)) {
				$kata = $this->Del_Inflection_Suffixes($kata);
				if($this->cekKamus($kata)){
					$hasil = $kata;
				}
			}
			
			$kata = $this->Del_Derivation_Suffixes($kata);
			if($this->cekKamus($kata)){
				$hasil = $kata;
			}
			
			$kata = $this->Del_Derivation_Prefix($kata);
			if($this->cekKamus($kata)){
				$hasil = $kata;
			}

			return $kata;
		}
	}

}

	// public function gabung_bro() {
	// 	// $this->load->library('database');
	// 	$this->db->select('dictionary.word as kata, dictionary.stopword, dictionary.category as kategori, dictionary.sentiment as sentimen, tb_katadasar.tipe_katadasar as tipe');
	// 	$this->db->from('dictionary');
	// 	$this->db->join('tb_katadasar', 'tb_katadasar.katadasar = dictionary.word');
	// 	$gabung = $this->db->get()->result_array();

	// 	$this->db->insert('kamus', $gabung);

	// 	echo 'inget hapus nanti bagian controller yang disuruh hapus tadi sama insan';
	// }

}