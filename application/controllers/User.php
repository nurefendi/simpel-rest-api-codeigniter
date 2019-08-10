<?php

require APPPATH . 'libraries/REST_Controller.php';

class User extends REST_Controller {

    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model('m_user', 'user');
        
    }
    

    public function index_get()
    {  
        $id = $this->get('id');
        // $q = $this->get('q');
        // $categori = $this->get('categori');
        // $order = $this->get('order');
        // $limit = $this->get('limit');
       
        if(empty($id)){
            $rs_user = $this->user->getAlluser();   

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

                $next_url = base_url('user').'?'.$output;
            }         
        } else {
            $rs_user = $this->user->getDetailuser($id);
        }

        if(!empty($rs_user)) {
        $this->response([
            'status' => true,
            'data' => $rs_user,
            'more' => isset($next_url)?$next_url:null,
            ], REST_Controller::HTTP_OK); 
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'User Not Found.'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }


}

/* End of file Controllername.php */

