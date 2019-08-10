<?php
 
 defined('BASEPATH') OR exit('No direct script access allowed');
 require_once APPPATH . 'models/M_model_base.php';
 class M_produk extends M_model_base {
 
     
     public function __construct()
     {
         parent::__construct();
         //Do your magic here
     }

    
     public function getAllproduk()
     {
         // $q = $this->get('q');
        // $categori = $this->get('categori');
        // $order = $this->get('order');
        // $limit = $this->get('limit');
        $sql = "SELECT * FROM `produk`";
        $where = "";

        if ($this->input->get('q')) {
            if (!empty($where)) {
                $where = " AND ";
            } else {
                $where = " WHERE ";
            }
            $sql .= $where . " nama_produk LIKE '%". $this->db->escape_like_str($this->input->get('q')) ."%'";
        }
        if ($this->input->get('categori')) {
            if (!empty($where)) {
                $where = " AND ";
            } else {
                $where = " WHERE ";
            }
            $sql .= $where . " kategori_id = ". $this->db->escape($this->input->get('categori'));
        }
        if ($this->input->get('halal')) {
            if (!empty($where)) {
                $where = " AND ";
            } else {
                $where = " WHERE ";
            }
            $sql .= $where . " halal = ". $this->db->escape($this->input->get('halal'));
        }
        if ($this->input->get('order')) {
            $sql .= " ORDER BY nama_produk ". $this->db->escape_like_str($this->input->get('order'));
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
     
     public function getDetailproduk($id)
     {
         $query = $this->db->get_where('produk', array('produk_id'=>$id));
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
 