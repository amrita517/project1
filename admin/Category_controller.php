<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_controller extends CI_Controller {
	public function __construct(){
        parent::__construct();
        $this->load->model('admin/Category_model');
      }

    public function categoryPage(){
        if($this->session->userdata('admin_id')){
            $data['category'] = $this->Category_model->categoryList();
            $this->load->view('admin/assets/header');
            $this->load->view('admin/assets/sidebar');
            $this->load->view('admin/category',$data);
            $this->load->view('admin/assets/footer');    
        }else{
            redirect('admin.html');
        }
        
    }

     public function categorySubmit(){
        if($this->input->post('cat_id')){
            $data = array('category' => $this->input->post('category'),
                            'id' => $this->input->post('cat_id'));
            $result = $this->Category_model->updateCategory($data);
            if($result == 1){
                    $this->session->set_flashdata('msg', '<div class="alert alert-success">Data Update Successfully !</div>');
                    redirect('Category.html');
            }else{
                $this->session->set_flashdata('msg', '<div class="alert alert-danger">Data not added to database please try again ? </div>');
                redirect('Category.html');
            }
            
        }else{
            $data = array('category' => $this->input->post('category'));
            $result = $this->Category_model->addCategory($data);
            if($result == 1){
                $this->session->set_flashdata('msg', '<div class="alert alert-success">Data Add Successfully !</div>');
                redirect('Category.html');    
            }else{
                $this->session->set_flashdata('msg', '<div class="alert alert-danger">Data not Updated to database please try again ? </div>');
                redirect('Category.html');
            }
        }
    }

    public function subCategorySubmimt(){
        if($this->input->post('cat_id')){
            $data = array('category' => $this->input->post('sub_category'),
                            'id' => $this->input->post('cat_id'),
                        'cat_id' => $this->input->post('sub_id'));
            $result = $this->Category_model->updateCategory($data);
            if($result == 1){
                $this->session->set_flashdata('msg', '<div class="alert alert-success">Data Add Successfully !</div>');
                redirect('Category.html');    
            }else{
                $this->session->set_flashdata('msg', '<div class="alert alert-danger">Data not Added to database please try again ? </div>');
                redirect('Category.html');
            }
        }else{
            $data = array('category' => $this->input->post('sub_category'),'cat_id' => $this->input->post('sub_id'));
            $result = $this->Category_model->addSubCategory($data);
            if($result == 1){
                $this->session->set_flashdata('msg', '<div class="alert alert-success">Data Add Successfully !</div>');
                redirect('Category.html');    
            }else{
                $this->session->set_flashdata('msg', '<div class="alert alert-danger">Data not Added to database please try again ? </div>');
                redirect('Category.html');
            }
        }
        
    }

    public function maincatEdit($id){
        $data['data'] = $this->Category_model->editdatafetch($id);
         $data['category'] = $this->Category_model->categoryList();
            $this->load->view('admin/assets/header');
            $this->load->view('admin/assets/sidebar');
            $this->load->view('admin/category',$data);
            $this->load->view('admin/assets/footer'); 
    }

    public function maincatDelete($id){
     $data = $this->Category_model->DeleteCategoryData($id);
     if ($data == 1) {
        $this->session->set_flashdata('msg', '<div class="alert alert-success">Data Delete Successfully ! </div>');
         redirect('Category.html');
     }
    }


}
