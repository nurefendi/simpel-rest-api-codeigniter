<?php

require APPPATH . 'libraries/REST_Controller.php';

class Category extends REST_Controller {

    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model('m_kategori', 'category');
        
    }

    public $form_conf = array(
        array('field' => 'nama_kategori', 'label' => 'Nama Kategori', 'rules' => 'required|max_length[255]'),
    );

    public function index_get()
    {  
        $id = $this->get('id');
        // $q = $this->get('q');
        // $categori = $this->get('categori');
        // $order = $this->get('order');
        // $limit = $this->get('limit');
       
        if(empty($id)){
            $rs_kategori = $this->category->getAllkategori();   

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

                $next_url = base_url('category').'?'.$output;
            }         
        } else {
            $rs_kategori = $this->category->getDetailcategory($id);
        }

        if(!empty($rs_kategori)) {
        $this->response([
            'status' => true,
            'data' => $rs_kategori,
            'more' => isset($next_url)?$next_url:null,
            ], REST_Controller::HTTP_OK); 
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Category Not Found.'
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

        if ($this->category->hapus_data('kategori', array('kategori_id'=>$id))) {

            $this->set_response([
                'status' => TRUE,
                'id' => $id,
                'message' => 'Kategori Berhasil Dihapus.'
                ], REST_Controller::HTTP_OK); 
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Id Not Found. '
                ], REST_Controller::HTTP_BAD_REQUEST); 
        }
    
        
    }

    public function index_post()
    {     // load form validation
        $this->load->library('form_validation');
        // $this->form_validation->set_error_delimiters('<p>', '');
        $this->form_validation->set_rules($this->form_conf);

        // run validation
        if ($this->form_validation->run($this) == false) {
            $this->response([
                'status' => FALSE,
                'message' => validation_errors(),
                ], REST_Controller::HTTP_BAD_REQUEST); 
        }
        
        $data['nama_kategori'] = $this->post('nama_kategori');        
        $data['create_at'] = date('Y-m-d H:i:s');
        $data['update_at'] = date('Y-m-d H:i:s');

        if ($this->category->tambah_data('kategori', $data)) {
            $this->set_response([
                'status' => TRUE,
                'nama_kategori' => $this->post('nama_kategori'),
                'message' => 'Kategori Berhasil Ditambahkan.'
                ], REST_Controller::HTTP_CREATED); 
        } else {
            $eror = $this->category->get_db_error();
            $this->response([
                'status' => FALSE,
                'error' => $eror['code'],
                'message' => 'Tidak Dapat Menambahkan Kategori. '
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

        $data['nama_kategori'] = $this->put('nama_kategori');
        $data['update_at'] = date('Y-m-d H:i:s');

        if ($this->put('id') === '') {
            $this->response([
                'status' => FALSE,
                'message' => 'Provide an id.'
                ], REST_Controller::HTTP_BAD_REQUEST); 
        }

        if ($this->category->ubah_data('kategori', 'kategori_id',$this->put('id'), $data)) {
            $this->set_response([
                'status' => TRUE,
                'kategori_id' => $this->put('id'),
                'message' => 'Kategori Berhasil Diubah.'
                ], REST_Controller::HTTP_CREATED); 
        } else {
            $eror = $this->category->get_db_error();
            $this->response([
                'status' => FALSE,
                'error' => $eror['code'],
                'message' => 'Gagal Mengubah Kategori. '
                ], REST_Controller::HTTP_BAD_REQUEST); 
        }
    }

}

/* End of file Controllername.php */

