<?php
 
 defined('BASEPATH') OR exit('No direct script access allowed');
 require_once APPPATH . 'models/M_model_base.php';
 class M_kategori extends M_model_base {
 
     
     public function __construct()
     {
         parent::__construct();
         //Do your magic here
     }

    
     public function getAllkategori()
     {
         // $q = $this->get('q');
        // $categori = $this->get('categori');
        // $order = $this->get('order');
        // $limit = $this->get('limit');
        $sql = "SELECT kategori_id,nama_kategori FROM `kategori`";
        $where = "";

        if ($this->input->get('q')) {
            if (!empty($where)) {
                $where = " AND ";
            } else {
                $where = " WHERE ";
            }
            $sql .= $where . " nama_kategori LIKE '%". $this->db->escape_like_str($this->input->get('q')) ."%'";
        }
        if ($this->input->get('order')) {
            $sql .= " ORDER BY nama_kategori ". $this->db->escape_like_str($this->input->get('order'));
        }

        if ($this->input->get('limit') && $this->input->get('start')) {
            $sql .= " LIMIT ". $this->db->escape_like_str($this->input->get('start')) .','.$this->db->escape_like_str($this->input->get('limit')) ;
        }

        // $sql .= " WHERE ".$where; 
        $query = $this->db->query($sql);         
         if ($query->num_rows() > 0) {
             $result = $query->result_array();
             $query->free_result();
             return $result;
         } else {
             return array();
         }
         
     }
     
     public function getDetailcategory($id)
     {
         $query = $this->db->select('kategori_id,nama_kategori')->get_where('kategori', array('kategori_id'=>$id));
         if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
     }


     
 
 }
 
 /* End of file M_produk.php */
 