<?php
defined('BASEPATH') OR exit('No direct script access allowed');

ini_set('max_execution_time', 0);
ini_set('memory_limit', '2048M');

class Datatables extends CI_Controller {

   public function __construct()
   {
      parent::__construct();


      $this->load->model('data_model', 'data');
      $this->load->library(array('ion_auth', 'template', 'table'));
   }

	public function index()
	{  
      if (!$this->ion_auth->logged_in()){            
         redirect('auth/login', 'refresh');
      }
      
      $data['page_header']  = 'Data Dummy';
      $data['page']         = '';
      $data['table']        = $this->generate_table();
      $data['elapsed_time'] = $this->benchmark->elapsed_time('code_start', 'code_end');

      $this->template->backend('datatables_v', $data);
	}

   public function page()
   {
      if (!$this->ion_auth->logged_in()){            
         redirect('auth/login', 'refresh');
      }

      $data['page_header']  = 'DataTables';
      $data['page']         = '';
      $data['table']        = $this->generate_table();
      $data['elapsed_time'] = $this->benchmark->elapsed_time('code_start', 'code_end');
      $data['count_rows']   = $this->data->count_rows();

      $this->template->backend('datatables_v', $data);
   }


   private function generate_table()
   {
      $query = $this->data->limit(1000, 0)->get_all(); //10000 sudah kewalahan

      $template = array(
         'table_open' => '<table id="dataTables" class="table table-striped table-bordered table-hover">'
      );
      $this->table->set_template($template);
      
      $this->table->set_heading('ID', 'Name', 'Phone');

      foreach ($query as $row) {
         $this->table->add_row($row->id, $row->name, $row->phone);
      }

      $generate_table = $this->table->generate();
      
      return $generate_table;
   }

   public function create()
   {
      $this->benchmark->mark('code_start');

      for ($i=100001; $i <= 200000 ; $i++) { 
         $phone = 85647541087 + $i;
         $row = array('name'=>'Santoso '.$i, 'phone' => '+62'.$phone);

         $this->data->insert($row);
      }
      
      $this->benchmark->mark('code_end');

      redirect(site_url('data'));
   }
}
