<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_server extends CI_Controller {

   public function __construct()
   {
      parent::__construct();


      $this->load->model('data_model', 'data');
      $this->load->library(array('ion_auth', 'template'));
   }

	public function index()
	{  
      
      if (!$this->ion_auth->logged_in()){            
         redirect('auth/login', 'refresh');
      }

      $data['page_header']  = 'Datatables Server Side';
      $data['page']         = '';

      $this->template->backend('data_server_v', $data);
	}

   public function get_data()
   {
      if (!$this->ion_auth->logged_in()){            
         redirect('auth/login', 'refresh');
      }

      $list = $this->data->get_datatables();
      $data = array();
      $no = $_POST['start'];
      foreach ($list as $field) {
         $no++;
         $row = array();
         $row[] = $no;
         $row[] = $field->id;
         $row[] = $field->name;
         $row[] = $field->phone;

         $data[] = $row;
      }

      $output = array(
         "draw" => $_POST['draw'],
         "recordsTotal" => $this->data->count_rows(),
         "recordsFiltered" => $this->data->count_filtered(),
         "data" => $data,
      );
      //output dalam format JSON
      echo json_encode($output);
   }

}
