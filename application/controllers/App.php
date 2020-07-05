<?php

    class App extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->library('form_validation');

            $this->load->model('Model_Stemming', 'stem');
            $this->load->model('Model_Dokumen', 'dokumen');
        }
        
        // public function index() {
        //     $data['stemming'] = NULL;
        //     $data['kata'] = ' ';
            
        //     $this->form_validation->set_rules('kata', 'Kata', 'required', [
        //         'required' => 'Silahkan Inputin Kalimat Terlebih Dahulu..'
        //     ]);
        //     if($this->form_validation->run() != FALSE) {
        //         $kata = $this->input->post('kata', 1);
        //         $hasil = $this->stem->stemming($kata);
        //         $data['stemming'] = $hasil;
        //         $data['kata'] = $kata;
        //     }    
            
        //     $this->load->view('app/index', $data);
            
        // }

        public function index() {
            $data['dokumen'] = $this->dokumen->tampilkan_dokumen();
            $this->load->view('app/main/tabel', $data);
        }

        public function rincian($id) {
            $data['dokumen'] = $this->dokumen->tampilkan_dokumen($id);

            $this->load->view('app/main/rincian', $data);
        }

        public function file_upload() { // digunakan untuk upload file
            $data = [
                'id_dokumen' => NULL,
                'nama_dokumen' => '',
                'file_path' => '',
                'tanggal' => date('Y-m-d', time())
            ];

            $uploadPath = 'dokumen/';
        
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = 'doc|docx';
            $config['max_size'] = 2000;
        
            $this->load->library('upload', $config);
        
            if ( ! $this->upload->do_upload('dokumen')) {
        
                $error = array('error' => $this->upload->display_errors());
    
                echo "Periksa permission folder ".$uploadPath;
                var_dump($error); die;
        
            } else {    
                $temp_data = array('upload_data' => $this->upload->data());
                
                $data['nama_dokumen'] = $temp_data['upload_data']['file_name'];
                $data['file_path'] = $temp_data['upload_data']['full_path'];
            }

            if($this->dokumen->unggah_dokumen($data)) {
                $this->session->set_flashdata('pesan','<div class="alert alert-success" role="alert">Dokumen berhasil diunggah</div>');
            } else {
                $this->session->set_flashdata('pesan','<div class="alert alert-danger" role="alert">Dokumen gagal diunggah</div>');
            }

            redirect('App/index');
        
          } // sampai sini

    }
