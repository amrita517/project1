<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_controller extends CI_Controller {
	public function __construct(){
        parent::__construct();
        $this->load->model('admin/Category_model');
        $this->load->model('admin/Product_model');
    }
   
    public function productPage(){
        if($this->session->userdata('admin_id')){
            $data['category'] = $this->Category_model->categoryList();
            $data['ProductList'] = $this->Product_model->ProductList();
            $this->load->view('admin/assets/header');
            $this->load->view('admin/assets/sidebar',$data);
            $this->load->view('admin/product');
            $this->load->view('admin/assets/footer');    
        }else{
            redirect('admin.html');
        }
        
    }

    public function productSubmit(){
        if($this->input->post('p_id') == ''){
            $config = array(
            'upload_path' => "assets/adminimg/",
            'allowed_types' => "gif|jpg|png|jpeg|pdf",
            'overwrite' => TRUE,
            'encrypt_name'=> TRUE,
            );
            $this->load->library('upload', $config);
            if($this->upload->do_upload('img'))
            {
                $img = $this->upload->data();
                if($this->input->post('sub_category') == ''){
                    $cat = $this->input->post('category');
                }else{
                    $cat = $this->input->post('sub_category');
                }
                 $data = array(
                        'name' => $this->input->post('product'),
                        'price' => $this->input->post('price'),
                        'description' => $this->input->post('description'),
                        'discount' => $this->input->post('discount'),
                        'image' => $img['file_name'],
                        'category' => $cat,
                     );
                 print_r($data);
                $result = $this->Product_model->insertProduct($data);
                if($result == 1){
                    $this->session->set_flashdata('msg', '<div class="alert alert-success">Data Add Successfully !</div>');
                    redirect('Product.html');
                }
            }else{
                $this->session->set_flashdata('msg', '<div class="alert alert-danger">Data Add not Successfully please try again ?</div>');
                redirect('Product.html');
            }    
        }else{
           $config = array(
            'upload_path' => "assets/adminimg/",
            'allowed_types' => "gif|jpg|png|jpeg|pdf",
            'overwrite' => TRUE,
            'encrypt_name'=> TRUE,
            );
            $this->load->library('upload', $config);
            if($this->upload->do_upload('img'))
            {
                $img = $this->upload->data();
                if($this->input->post('sub_category') == ''){
                    $cat = $this->input->post('category');
                }else{
                    $cat = $this->input->post('sub_category');
                }
                 $data = array(
                        'id' => $this->input->post('p_id'),
                        'name' => $this->input->post('product'),
                        'price' => $this->input->post('price'),
                        'image' => $img['file_name'],
                        'category' => $cat,
                     );
                $result = $this->Product_model->ProductUpdate($data);
                if($result == 1){
                    $this->session->set_flashdata('msg', '<div class="alert alert-success">Data Update successfully !</div>');
                    redirect('Product.html');
                }
            }else{
                if($this->input->post('sub_category') == ''){
                    $cat = $this->input->post('category');
                }else{
                    $cat = $this->input->post('sub_category');
                }
                 $data = array(
                        'id' => $this->input->post('p_id'),
                        'name' => $this->input->post('product'),
                        'price' => $this->input->post('price'),
                        'category' => $cat,
                     );
                 print_r($data);
                $result = $this->Product_model->ProductUpdate($data);
                if($result == 1){
                    $this->session->set_flashdata('msg', '<div class="alert alert-success">Data Update successfully !</div>');
                    redirect('Product.html');
                }
            }    
        }
        
        
    }


    public function ProducteditFetchData($id){
        $data['editdata'] = $this->Product_model->editFetch($id);

        // print_r(isset(var)$data);exit();
        if(empty($result)){
            $data['edit'] = 'edit';
            $data['category'] = $this->Category_model->categoryList();
            $data['ProductList'] = $this->Product_model->ProductList();
            $this->load->view('admin/assets/header');
            $this->load->view('admin/assets/sidebar',$data);
            $this->load->view('admin/product');
            $this->load->view('admin/assets/footer');    
        }else{
            $this->session->set_flashdata('msg', '<div class="alert alert-danger">Edit data not found please try again ?</div>');
            redirect('Product.html');
        }
          
    }
       
    public function DeleteProduct($id){
        $result = $this->Product_model->DeleteProduct($id);
        if ($result == 1) {
            redirect('Product.html');
        }
    } 
     
}
