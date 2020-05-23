<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_jquery extends CI_Controller {

   public function __construct()
   {
      parent::__construct();


      $this->load->model('data_model', 'data');
      $this->load->library(array('ion_auth', 'template', 'table', 'javascript', 'jquery_pagination'));
   }

	public function index()
	{  
      
      if (!$this->ion_auth->logged_in()){            
         redirect('auth/login', 'refresh');
      }
      
      ob_start();
      $this->generate_table(0);
      $initial_content = ob_get_contents();
      ob_end_clean();
      $data['table']        = $initial_content;

      $data['page_header']  = 'Jquery Pagination';
      $data['page']         = '';

      $this->template->backend('data_jquery_v', $data);
	}

   public function generate_table($offset = 0)
   {
      if (!$this->ion_auth->logged_in()){            
         redirect('auth/login', 'refresh');
      }

      $limit = 10;
      $key        = $this->input->post('key');

      $total_rows = $this->data->get_by($key)->num_rows();
      $query      = $this->data->get_by($key, $limit, $offset)->result();
             
      $config['div']              = '#table-responsive';
      $config['base_url']         = base_url() . 'index.php/data_jquery/generate_table';
      $config['total_rows']       = $total_rows;
      $config['per_page']         = $limit;
      $config['uri_segment']      = 3;
      $config['additional_param'] = "$('#search-form').serialize()";

      $this->jquery_pagination->initialize($config);

      $template = array(
         'table_open' => '<table cellpadding="2" cellspacing="1" class="table table-striped table-bordered table-hover">'
      );
      $this->table->set_template($template);
      
      $this->table->set_heading('ID', 'Name', 'Phone');

      foreach ($query as $row) {
         $this->table->add_row($row->id, $row->name, $row->phone);
      }

      $generate_table = $this->table->generate().br(1).$this->jquery_pagination->create_links();
      
      echo $generate_table;
   }

}
