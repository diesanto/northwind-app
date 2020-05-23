<?php
/*
Jquery menyebabkan pagging, pencaraian gak mau jalan -> Jquery pindah atas
bootsrap menyebabkan form jadi jelek -> flexigrid.css line 308 matikan height
*/
defined('BASEPATH') OR exit('No direct script access allowed');

ini_set('max_execution_time', 0);
ini_set('memory_limit', '2048M');

class Data_grocery extends CI_Controller {

   public function __construct()
   {
      parent::__construct();


      $this->load->model('data_model', 'data');
      $this->load->library(array('ion_auth', 'template', 'grocery_CRUD'));
   }

	public function index()
	{  
      if (!$this->ion_auth->logged_in()){            
         redirect('auth/login', 'refresh');
      }
      
      $crud = new grocery_CRUD();

      //$crud->set_theme('twitter-bootstrap');
      //$crud->limit(10000);
      $crud->set_table('data');          

      $grocery = (array)$crud->render();

      $data['page_header']  = 'Grocery Crud';
      $data['elapsed_time'] = $this->benchmark->elapsed_time('code_start', 'code_end');

      $data = array_merge($data, $grocery);
      //$data = $data + $grocery;

      $this->template->backend('data_grocery_v', $data);
	}
}
