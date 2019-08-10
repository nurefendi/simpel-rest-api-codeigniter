<?php

class M_model_base extends CI_Model {

    var $pesan_error = array(
        1451 => 'Data sedang digunakan oleh sistem.  Silakan periksa kembali penggunaan data.'
    );

    public function __construct() {
        parent::__construct();
    }

    function tambah_data($tabel, $data) {
        if (empty($tabel) || empty($data))
            return false;
        return $this->db->insert($tabel, $data);
    }

    function tambah_data_batch($tabel, $data) {
        if (empty($tabel) || empty($data))
            return false;
        return $this->db->insert_batch($tabel, $data);
    }

    function ubah_data($tabel, $kolom, $id = null, $data) {
        if (empty($tabel) || empty($data) || empty($kolom))
            return false;

        if (is_array($kolom)) {
            $this->db->update($tabel, $data, $kolom);
            return $this->db->affected_rows();
        }
        $this->db->where($kolom, $id);
        $this->db->update($tabel, $data);
        return $this->db->affected_rows();
    }

    function hapus_data($tabel, $parameter) {
        if (empty($tabel) OR empty($parameter))
            return false;
        return $this->db->delete($tabel, $parameter);
    }

    function get_error_message() {
        $get_error = $this->db->error();
        if (isset($this->pesan_error[$get_error['code']]))
            return $this->pesan_error[$get_error['code']];
        else
            return $get_error['message'];
    }

    function get_db_error() {
        return $this->db->error();
    }

    function id_terakhir() {
        return $this->db->insert_id();
    }

    protected function get_select2_data($sql, $params)
    {
        $dt = $this->input->post();

        $data['total_record'] = $this->db->query($sql, $params)->num_rows();

        $start  = ($dt['page'] - 1) * $dt['page_limit'];
        $length = $dt['page_limit'];
        $sql .= " LIMIT {$start}, {$length}";

        $query = $this->db->query($sql, $params);

        $data['more'] = $data['total_record'] > $dt['page'] * $dt['page_limit'];

        if ($query->num_rows() > 0) {
          $result = $query->result_array();
          $query->free_result();
          $data['items'] = $result;
          return $data;
      } else {
          $data['items'] = [];
          return $data;
      }
  }

}