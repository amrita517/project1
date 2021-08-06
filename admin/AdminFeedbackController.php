<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminFeedbackController extends CI_Controller {
	public function __construct(){
        parent::__construct();
        $this->load->model('admin/AdminFeedbackModel');
        if(! $this->session->userdata('admin_id')){
			return redirect(base_url('admin.html'));
        	
        }
    }

    public function show_feedback()
    {
    	$result['feedback_info'] = $this->AdminFeedbackModel->show_feedback();
    	$this->load->view('admin/assets/header');
    	$this->load->view('admin/assets/sidebar');
    	$this->load->view('admin/adminContactFeedback/show_contact_feedback_page',$result);
    	$this->load->view('admin/assets/footer');
    }
}
