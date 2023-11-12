<?php
	class Siswa_model extends CI_Model {

        public $name;
        public $last_name;
        public $phone;
		public $email;
		public $address;

        public function getSiswa($id = null)
        {
			if($id === null) {
				return $this->db->get('siswa')->result();
			} else {
				return $this->db->get_where('siswa', ['id' => $id])->result();
			}
        }

        public function postSiswa($data)
        {
			return $this->db->insert('siswa', $data);
        }

        public function putSiswa($data, $id = null)
        {
            $this->db->update('siswa', $data, ['id'=> $id]);
			return $this->db->affected_rows();
        }

		public function deleteSiswa($id){
			$this->db->delete('siswa', ['id' => $id]);
			return $this->db->affected_rows();
		}

}
