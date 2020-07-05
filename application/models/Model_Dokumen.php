<?php

class Model_Dokumen extends CI_Model {
	public function unggah_dokumen($data) {
		return $this->db->insert('dokumen', $data);
	}

	public function tampilkan_dokumen($id = NULL) {
		
		if($id) return $this->db->get_where('dokumen', ['id_dokumen' => $id])->row();

		$this->db->select('*');
		$this->db->from('dokumen');
		$this->db->order_by('id_dokumen', 'desc');
		$this->db->limit(1);
		return $this->db->get()->row(); // return object
	}
}