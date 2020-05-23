<?php
defined('BASEPATH') OR exit('No direct script access allowed');

ini_set('max_execution_time', 0);
ini_set('memory_limit', '2048M');

class Data extends CI_Controller {

   public function __construct()
   {
      parent::__construct();


      $this->load->model('data_model', 'data');
      $this->load->library(array('ion_auth', 'template', 'table', 'pagination'));
   }

	public function index()
	{  
      if (!$this->ion_auth->logged_in()){            
         redirect('auth/login', 'refresh');
      }

      $this->page();
	}

   public function page()
   {
      if (!$this->ion_auth->logged_in()){            
         redirect('auth/login', 'refresh');
      }

      $data['page_header']  = 'Data Dummy';
      $data['page']         = '';
      $data['table']        = $this->generate_table();
      $data['elapsed_time'] = $this->benchmark->elapsed_time('code_start', 'code_end');
      $data['count_rows']   = $this->data->count_rows();

      $this->template->backend('data_v', $data);
   }


   private function generate_table()
   {
      $offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
      $total_rows = $this->data->count_rows();

      /*
      $config['full_tag_open']    = '<div class="box-tools"><ul class="pagination pagination-sm no-margin pull-left">';
      $config['full_tag_close']   = '</ul></div>';
      $config['num_tag_open']     = '<li>';
      $config['num_tag_close']    = '</li>';
      $config['cur_tag_open']     = '<li class="disabled"><li class="active"><a href="#"">';
      $config['cur_tag_close']    = '<span class="sr-only"></span></a></li>';
      $config['next_tag_open']    = '<li>';
      $config['next_tagl_close']  = '</li>';
      $config['prev_tag_open']    = '<li>';
      $config['prev_tag_close']   = '</li>';
      $config['first_tag_open']   = '<li>';
      $config['first_tagl_close'] = '</li>';
      $config['last_tag_open']    = '<li>';
      $config['last_tagl_close']  = '</li>';
      $config['next_link']  = '&raquo; ';
      $config['prev_link']  = '&laquo; ';
      */

      $config['first_link']       = 'First';
      $config['last_link']        = 'Last';
      $config['next_link']        = '&raquo; ';
      $config['prev_link']        = '&laquo; ';
      $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
      $config['full_tag_close']   = '</ul></nav></div>';
      $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
      $config['num_tag_close']    = '</span></li>';
      $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
      $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
      $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
      $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
      $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
      $config['prev_tagl_close']  = '</span>Next</li>';
      $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
      $config['first_tagl_close'] = '</span></li>';
      $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
      $config['last_tagl_close']  = '</span></li>';

      $config['base_url']   = base_url() . 'index.php/data/page/';
      $config['total_rows'] = $total_rows;
      $config['per_page']   = 10;
      $config['uri_segment'] = 3;
             
      $this->pagination->initialize($config);

      $query = $this->data->limit(10, $offset)->get_all();

      $template = array(
         'table_open' => '<table cellpadding="2" cellspacing="1" class="table table-striped table-bordered table-hover">'
      );
      $this->table->set_template($template);
      
      $this->table->set_heading('ID', 'Name', 'Phone');

      foreach ($query as $row) {
         $this->table->add_row($row->id, $row->name, $row->phone);
      }

      $generate_table = $this->table->generate().br(1).$this->pagination->create_links();
      
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
