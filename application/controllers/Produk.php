<?php

require APPPATH . 'libraries/REST_Controller.php';

class Produk extends REST_Controller {

    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model('m_produk', 'produk');
        
    }

    public $form_conf = array(
        array('field' => 'kategori_id', 'label' => 'Kategori', 'rules' => 'required|max_length[255]'),
        array('field' => 'user_id', 'label' => 'User', 'rules' => 'required|max_length[255]'),
        array('field' => 'nama_produk', 'label' => 'Nama Produk', 'rules' => 'required|max_length[255]'),
        array('field' => 'harga', 'label' => 'Harga', 'rules' => 'required|max_length[255]'),
        array('field' => 'deskripsi', 'label' => 'Deskripsi', 'rules' => 'required|max_length[255]'),
        array('field' => 'berat', 'label' => 'Berat', 'rules' => 'required|max_length[255]'),
        array('field' => 'halal', 'label' => 'Halal', 'rules' => 'required|max_length[255]'),
    );
    

    public function index_get()
    {  
        $id = $this->get('id');
        // $q = $this->get('q');
        // $categori = $this->get('categori');
        // $order = $this->get('order');
        // $limit = $this->get('limit');
       
        if(empty($id)){
            $rs_produk = $this->produk->getAllproduk();   
            
            

            if ($this->input->get('limit') && $this->input->get('start')) {
                // $this->load->library('pagination');
                // $config['base_url'] = base_url('produk');
                // $config
                $input = [];
                foreach ($this->input->get() as $key => $v) {

                    if ($key == 'limit') {
                        $input[$key] =  $v+$v;
                    }else {
                        $input[$key] =  $v;
                    }
                }
                
                $output = implode('&', array_map(
                    function ($v, $k) {                         
                        return sprintf("%s=%s", $k, $v); },
                    $input,
                    array_keys($input)
                ));

                $next_url = base_url('produk').'?'.$output;
            }         
        } else {
            $rs_produk = $this->produk->getDetailproduk($id);
        }

        if(!empty($rs_produk)) {
        $this->response([
            'status' => true,
            'data' => $rs_produk,
            'more' => isset($next_url)?$next_url:null,
            ], REST_Controller::HTTP_OK); 
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Products Not Found.'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function index_delete()
    {
        $id = $this->delete('id');

        if (empty($id)) {
            $this->response([
                'status' => FALSE,
                'message' => 'Provide an id.'
                ], REST_Controller::HTTP_BAD_REQUEST); 
        } 

        if ($this->produk->hapus_data('produk', array('produk_id' => $id))) {

            $this->set_response([
                'status' => TRUE,
                'id' => $id,
                'message' => 'Produk Berhasil Dihapus.'
                ], REST_Controller::HTTP_OK); 
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Id Not Found. '
                ], REST_Controller::HTTP_BAD_REQUEST); 
        }
    
        
    }

    public function index_post()
    {
        // load form validation
        $this->load->library('form_validation');
        // $this->form_validation->set_error_delimiters('<p>', '');
        // $this->form_validation->set_data($this->put());
        $this->form_validation->set_rules($this->form_conf);

        // run validation
        if ($this->form_validation->run($this) == false) {
            $this->response([
                'status' => FALSE,
                'message' => validation_errors(),
                ], REST_Controller::HTTP_BAD_REQUEST); 
        }

        $data['kategori_id'] = $this->post('kategori_id');
        $data['user_id'] = $this->post('user_id');
        $data['nama_produk'] = $this->post('nama_produk');
        $data['harga'] = $this->post('harga');
        $data['deskripsi'] = $this->post('deskripsi');
        $data['foto'] = $this->post('foto');
        $data['berat'] = $this->post('berat');
        $data['halal'] = $this->post('halal');
        $data['create_at'] = date('Y-m-d H:i:s');
        $data['update_at'] = date('Y-m-d H:i:s');

        if ($this->produk->tambah_data('produk', $data)) {
            $this->set_response([
                'status' => TRUE,
                'nama_produk' => $this->post('nama_produk'),
                'message' => 'Produk Berhasil Ditambahkan.'
                ], REST_Controller::HTTP_CREATED); 
        } else {
            $eror = $this->produk->get_db_error();
            $this->response([
                'status' => FALSE,
                'error' => $eror['code'],
                'message' => 'Tidak Dapat Menambahkan Produk. '
                ], REST_Controller::HTTP_BAD_REQUEST); 
        }
        
    }
    public function index_put()
    {
    
        // load form validation
        $this->load->library('form_validation');
        // $this->form_validation->set_error_delimiters('<p>', '');
        $this->form_validation->set_data($this->put());
        $this->form_validation->set_rules($this->form_conf);

        // run validation
        if ($this->form_validation->run($this) == false) {
            $this->response([
                'status' => FALSE,
                'message' => validation_errors(),
                ], REST_Controller::HTTP_BAD_REQUEST); 
        }

        $data['kategori_id'] = $this->put('kategori_id');
        $data['user_id'] = $this->put('user_id');
        $data['nama_produk'] = $this->put('nama_produk');
        $data['harga'] = $this->put('harga');
        $data['deskripsi'] = $this->put('deskripsi');
        $data['foto'] = $this->put('foto');
        $data['berat'] = $this->put('berat');
        $data['halal'] = $this->put('halal');
        $data['update_at'] = date('Y-m-d H:i:s');

        if ($this->put('id') === '') {
            $this->response([
                'status' => FALSE,
                'message' => 'Provide an id.'
                ], REST_Controller::HTTP_BAD_REQUEST); 
        }

        if ($this->produk->ubah_data('produk', 'produk_id',$this->put('id'), $data)) {
            $this->set_response([
                'status' => TRUE,
                'produk_id' => $this->post('produk_id'),
                'message' => 'Produk Berhasil Diubah.'
                ], REST_Controller::HTTP_CREATED); 
        } else {
            $eror = $this->produk->get_db_error();
            $this->response([
                'status' => FALSE,
                'error' => $eror['code'],
                'message' => 'Gagal Mengubah Produk. '
                ], REST_Controller::HTTP_BAD_REQUEST); 
        }
        
    }

}

/* End of file Controllername.php */

