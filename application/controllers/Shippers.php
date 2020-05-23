<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Shippers extends CI_Controller {

   protected $page_header = 'Shippers Management';

   public function __construct()
   {
      parent::__construct();


      $this->load->model('shippers_model', 'shippers');
      $this->load->library(array('ion_auth', 'form_validation', 'template'));
      $this->load->helper('bootstrap_helper');
   }

	public function index()
	{  
      
      if (!$this->ion_auth->logged_in()){            
         redirect('auth/login', 'refresh');
      }

      $data['page_header']   = $this->page_header;
      $data['panel_heading'] = 'Shippers List';
      $data['page']         = '';

      $this->template->backend('shippers_v', $data);
	}

   public function get_shippers()
   {
      if (!$this->ion_auth->logged_in()){            
         redirect('auth/login', 'refresh');
      }

      $list = $this->shippers->get_datatables();
      $data = array();
      $no = isset($_POST['start']) ? $_POST['start'] : 0;
      foreach ($list as $field) { 
         $id = $field->ShipperID;

         $url_view   = 'view_data('.$id.');';
         $url_update = 'update_data('.$id.');';
         $url_delete = 'delete_data('.$id.');';

         $no++;
         $row = array();
         $row[] = ajax_button($url_view, $url_update, $url_delete);
         $row[] = $no;
         $row[] = $field->CompanyName;
         $row[] = $field->Phone;

         $data[] = $row;
      }
      
      $draw = isset($_POST['draw']) ? $_POST['draw'] : null;

      $output = array(
         "draw" => $draw,
         "recordsTotal" => $this->shippers->count_rows(),
         "recordsFiltered" => $this->shippers->count_filtered(),
         "data" => $data,
      );
      echo json_encode($output);
   }


   public function view()
   {
      if (!$this->ion_auth->logged_in()){            
         redirect('auth/login', 'refresh');
      }

      $id = $this->input->post('ShipperID');

      $query = $this->shippers->where('ShipperID', $id)->get();
      if($query){
         $data = array('ShipperID' => $query->ShipperID,
             'CompanyName' => $query->CompanyName,
             'Phone' => $query->Phone);
      }

      echo json_encode($data);
   }

   public function form_data()
   {
      if (!$this->ion_auth->logged_in()){            
         redirect('auth/login', 'refresh');
      }

      $ShipperID    = '';
      $CompanyName  = '';
      $Phone   = '';
      if($this->input->post('ShipperID')){
         $id      = $this->input->post('ShipperID');
         $query   = $this->shippers->where('ShipperID', $id)->get(); 
         if($query){
            $ShipperID    = $query->ShipperID;
            $CompanyName  = $query->CompanyName;
            $Phone  = $query->Phone;
         }
      }

      $data = array('hidden'=> form_hidden('ShipperID', $ShipperID),
             'CompanyName' => form_input(array('name'=>'CompanyName', 'id'=>'CompanyName', 'class'=>'form-control', 'value'=>$CompanyName)),
             'Phone' => form_input(array('name'=>'Phone', 'id'=>'Phone', 'class'=>'form-control', 'value'=>$Phone))
            );

      echo json_encode($data);
   }


   public function save_shipper()
   {   
      if (!$this->ion_auth->logged_in()){            
         redirect('auth/login', 'refresh');
      }

      $rules = array(
            'insert' => array(array('field' => 'CompanyName', 'label' => 'Company Name', 'rules' => 'trim|is_unique[shippers.CompanyName]|required|max_length[40]'),
                        array('field' => 'Phone', 'label' => 'Phone', 'rules' => 'trim|max_length[24]')),
            'update' => array(array('field' => 'CompanyName', 'label' => 'Company Name', 'rules' => 'trim|required|max_length[40]'), 
                        array('field' => 'Phone', 'label' => 'Phone', 'rules' => 'trim|max_length[24]'))                  
            );
        
      $row  = array('CompanyName' => $this->input->post('CompanyName'),
             'Phone' => $this->input->post('Phone'));

      $code = 0;

      if($this->input->post('ShipperID') == null){

         $this->form_validation->set_rules($rules['insert']);

         if ($this->form_validation->run() == true) {
            
            $this->shippers->insert($row);

            $error =  $this->db->error();
            if($error['code'] <> 0){
               $code = 1;
               $notifications = $error['code'].' : '.$error['message'];
            }
            else{
               $notifications = 'Success Insert Data';
            }
         }
         else{
            $code = 1;
            $notifications = validation_errors('<p>', '</p>'); 
         }

      }

      else{
         
         $this->form_validation->set_rules($rules['update']);

         if ($this->form_validation->run() == true) {

            $id = $this->input->post('ShipperID');

            $this->shippers->where('ShipperID', $id)->update($row);
            
            $error =  $this->db->error();
            if($error['code'] <> 0){               
               $code = 1;               
               $notifications = $error['code'].' : '.$error['message'];
            }
            else{               
               $notifications = 'Success Update Data';
            }
         }
         else{
            $code = 1;
            $notifications = validation_errors('<p>', '</p>'); 
         }
      }

      $notifications = ($code == 0) ? notifications('success', $notifications) : notifications('error', $notifications);
      
      echo json_encode(array('message' => $notifications, 'code' => $code));
   }

   public function delete()
   {
      if (!$this->ion_auth->logged_in()){            
         redirect('auth/login', 'refresh');
      }

      $code = 0;

      $id = $this->input->post('ShipperID');

      $this->shippers->where('ShipperID', $id)->delete();

      $error =  $this->db->error();
      if($error['code'] <> 0){
         $code = 1;
         $notifications = $error['code'].' : '.$error['message'];
      }
      else{
         $notifications = 'Success Delete Data';
      }

      $notifications = ($code == 0) ? notifications('success', $notifications) : notifications('error', $notifications);
      
      echo json_encode(array('message' => $notifications, 'code' => $code));
   }

}
