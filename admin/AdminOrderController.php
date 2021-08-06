<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminOrderController extends CI_Controller {
	public function __construct(){
        parent::__construct();
        $this->load->model('admin/AdminOrderModel');
        if(! $this->session->userdata('admin_id')){
			return redirect(base_url('admin.html'));
        	
        }
    }

	public function show_orders()
	{
		$result['orders'] = $this->AdminOrderModel->show_orders();
		$this->load->view('admin/assets/header');
        $this->load->view('admin/assets/sidebar');
        $this->load->view('admin/adminOrder/show_order_page',$result);
        $this->load->view('admin/assets/footer');
	}  

	public function show_order_list_by_order_id()
	{
		$order_id = $this->input->get('order_id');
		$result['order_list'] = $this->AdminOrderModel->show_order_list_by_order_id($order_id);
		$this->load->view('admin/assets/header');
        $this->load->view('admin/assets/sidebar');
        $this->load->view('admin/adminOrder/order_product_list',$result);
        $this->load->view('admin/assets/footer');
	}
}