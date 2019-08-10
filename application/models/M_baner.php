<?php
 
 defined('BASEPATH') OR exit('No direct script access allowed');
 
 class M_baner extends CI_Model {
 
     
     public function __construct()
     {
         parent::__construct();
         //Do your magic here
     }

    
     public function getBaner()
     {

        $query = $this->db->get('banner');         
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
 