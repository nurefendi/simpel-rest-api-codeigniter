<?php

require APPPATH . 'libraries/REST_Controller.php';

class Banner extends REST_Controller {

    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model('m_baner', 'banner');
        
    }


    public $form_conf = array(
        array('field' => 'baner_name', 'label' => 'Nama Banner', 'rules' => 'required|max_length[255]'),
    );

    public function index_get()
    {  
   
        $rs_banner = $this->banner->getBaner();   

        if(!empty($rs_banner)) {
        $this->response([
            'status' => true,
            'data' => $rs_banner,
            ], REST_Controller::HTTP_OK); 
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Products Not Found.'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
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

        $data['baner_name'] = $this->put('baner_name');
        $data['baner_desc'] = $this->put('baner_desc');
        $data['baner_link'] = $this->put('baner_link');
        $data['meta_title'] = $this->put('meta_title');
        $data['meta_desc'] = $this->put('meta_desc');
        $data['meta_tag'] = $this->put('meta_tag');

        if ($this->put('id') === '') {
            $this->response([
                'status' => FALSE,
                'message' => 'Provide an id.'
                ], REST_Controller::HTTP_BAD_REQUEST); 
        }

        if ($this->produk->ubah_data('banner', 'banner_id',$this->put('id'), $data)) {
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

