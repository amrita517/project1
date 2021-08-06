<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_controller extends CI_Controller {
	public function __construct(){
        parent::__construct();
        $this->load->model('admin/auth/Auth');
    }

    public function loginPage(){
        if($this->session->userdata('admin_id')){
            redirect('Dashboard.html');
        }else{
            $this->load->view('admin/auth/login');
        }
    }

    public function adminRegistration(){
        $this->load->view('admin/auth/adminRegistration');
    }


    public function loginSubmit(){
        $this->form_validation->set_rules('email', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Email', 'required');

		if ($this->form_validation->run())
                {
					$data = array('email' => $this->input->post('email'),
									'password' => md5($this->input->post('password')),  
								);

				 $result = $this->Auth->loginData($data);
				 	
				 if(is_array($result)){
					$this->session->set_userdata('admin_id',$result['id']);
					redirect('Dashboard.html');
				 }else{
				 	redirect('AdminLogin.html');
				 }
				      
                }else{
					// redirect();
					redirect('admin.html');
				}
				 
    	}

    	public function admin_logout(){
    		$this->session->sess_destroy($this->session->userdata('admin_id'));
    		if ($this->session->userdata('admin_id')) {
    			redirect('Dashboard.html');
    		}else{
    			redirect('admin.html');
    		}
    	}

}
