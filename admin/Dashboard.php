<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function __construct(){
        parent::__construct();
        $this->load->model('admin/AdminDashboardModel');
      }

    public function dashboard(){
    	if($this->session->userdata('admin_id')){
	    	$this->load->view('admin/assets/header');
	    	$this->load->view('admin/assets/sidebar');
	        $this->load->view('admin/dashboard');
	        $this->load->view('admin/assets/footer');
    	}else{
    		redirect('admin.html');
    	}
    }

    public function show_password_page()
    {
        $this->load->view('admin/assets/header');
        $this->load->view('admin/assets/sidebar');
        $this->load->view('admin/admin_profile_password/password_page');
        $this->load->view('admin/assets/footer');
    }

    public function change_password()
    {
        $this->form_validation->set_rules('old_pass', 'Old Password','required');
        $this->form_validation->set_rules('new_pass', 'New Password', 'required');
        $this->form_validation->set_rules('confirm_pass', 'Confirm Password', 'required|matches[new_pass]');
        if($this->form_validation->run())
        {
            $oldpass = $this->input->post('old_pass');
            $admin_id = $this->session->userdata('admin_id');
            $admin = $this->AdminDashboardModel->get_admin($admin_id);
            if($admin->password !== md5($oldpass))
            {
                $this->session->set_flashdata('password_msg', '<div style="color: red;"><h6><span>Plaese enter correct old password.</span></h6></div>');
                redirect(base_url('password.html'));
            }
            else
            {
                $admin_id = $this->session->userdata('admin_id');
                $newpass = $this->input->post('new_pass');
                $this->AdminDashboardModel->admin_update_password($admin_id, array('password' => md5($newpass)));
                $this->session->set_flashdata('password_sccuess_msg','Password is Successfully Changed.');
                redirect(base_url('password.html'));
            }
        }

        else
        {
            $this->load->view('admin/assets/header');
            $this->load->view('admin/assets/sidebar');
            $this->load->view('admin/admin_profile_password/password_page');
            $this->load->view('admin/assets/footer');
        }       
    }

    public function profile_page()
    {
        $result['profile_data'] = $this->AdminDashboardModel->fetch_admin_detail();
        $this->load->view('admin/assets/header');
        $this->load->view('admin/assets/sidebar');
        $this->load->view('admin/admin_profile_password/admin_profile_page',$result);
        $this->load->view('admin/assets/footer');
    }

    public function update_profile()
    {
        $this->form_validation->set_rules('name', 'Name','required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('phone', 'Phone No.', 'required');
        $this->form_validation->set_rules('admin_address', 'Address', 'required');

        $file = [
                    'upload_path' =>'./assets/adminimg/admin_logo',
                    'allowed_types' =>'jpg|jpeg|png|gif'
                ];
        $this->load->library('upload',$file);
        if($this->form_validation->run())
        {
            if($this->upload->do_upload('new_file'))
                {
                    $dlt_file = $this->input->post('delete_file');
                        if($dlt_file)
                        {
                            unlink("./assets/adminimg/admin_logo/".$dlt_file);
                        }
                        $image = $this->upload->data('file_name');
                }

                else
                {
                    $image = $this->input->post('old_file');
                }

        $data = array('name' => $this->input->post('name'),
                      'email' => $this->input->post('email'),
                      'phone' => $this->input->post('phone'),
                      'admin_address' => $this->input->post('admin_address'),
                      'image_logo' => $image);
             
                $result = $this->AdminDashboardModel->admin_update_profile($data);
                if($result)
                {
                    $this->session->set_flashdata('sccess_msg','Profile is Successfully Updated.');
                    redirect(base_url('profile.html'));
                }
                else
                {
                    $this->session->set_flashdata('error_msg','Profile is not Updated.');
                    redirect(base_url('profile.html'));
                }
        }   
        else
        {
            $this->session->set_flashdata('validation_msg','All Field Required.');
            redirect(base_url('profile.html'));
        
        }
    }
}
