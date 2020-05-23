<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employees2 extends CI_Controller {

   protected $page_header = 'Employees Management';

   public function __construct()
   {
      parent::__construct();

      $this->load->model('employees_model', 'employees');
      $this->load->library(array('ion_auth', 'form_validation', 'template', 'jquery_pagination'));
      $this->load->helper('bootstrap_helper');
   }

	public function index()
	{  
      
      if (!$this->ion_auth->logged_in()){            
         redirect('auth/login', 'refresh');
      }

      //unset($_SESSION['employee_q']);
      ob_start();
      $this->generate_table(0);
      $initial_content = ob_get_contents();
      ob_end_clean();
      $data['table']        = $initial_content;

      $data['page_header']   = $this->page_header;
      $data['panel_heading'] = 'Employee List';
      $data['page']          = '';

      if(!empty($_POST['q'])){
         $data['panel_heading'] .= ' - Showing Search With Key : <b>' . $this->input->post('q') . '</b>';
      }
      elseif($this->session->flashdata('employee_q')){
         $data['panel_heading'] .= ' - Showing Search With Key : <b>' . $this->session->flashdata('employee_q') . '</b>';
      }

      
      $this->template->backend('employees2_v', $data);
	}

   public function generate_table($offset = 0)
   {
      $limit = 5; 

      if(isset($_POST['q'])){
         $q = $this->input->post('q');
         $this->session->set_flashdata('employee_q', $q);
      }
      else{
         $q = $this->session->flashdata('employee_q');
      }

      if($this->session->flashdata('page')){
         $offset = $this->session->flashdata('employee_offset');
         $config['cur_page']    = $offset;
      }

      $this->session->set_flashdata('employee_offset', $offset);
      
      if(!empty($q)){
         $where = array();
         foreach ($this->employees->get_fields() as $value) {
             $where[$value] = $q;
         }

         $query = $this->employees->limit($limit)->offset($offset)->or_where($where)->get_all();         
         $total_rows = $this->employees->or_where($where)->count_rows();           
      }
      else{
         $query = $this->employees->limit($limit)->offset($offset)->get_all();
         $total_rows = $this->employees->count_rows();
      }
      
      $config['div']          = '#table-responsive';
      $config['base_url']     = base_url() . 'index.php/employees2/generate_table/';
      $config['total_rows']   = $total_rows;
      $config['per_page']     = $limit;
      $config['uri_segment']  = !empty($config['cur_page']) ? 0 : 3;      
      $config['additional_param'] = "$('#search-form').serialize()";

      $this->jquery_pagination->initialize($config);

      set_pagging($config);

      set_table(false);

      $this->table->set_heading('Action', 'No ', 'LastName', 'FirstName', 'Title', 'TitleOfCourtesy', 'BirthDate', 'HireDate', 'Address', 'City', 'Region', 'PostalCode', 'Country', 'HomePhone', 'Extension', 'Photo', 'Notes', 'ReportsTo', 'Sex');

      
      $no   = $offset + 1;

      foreach ($query as $row) {
         $url_view   = site_url('employees2/view/'.$row->EmployeeID);
         $url_update = site_url('employees2/update/'.$row->EmployeeID);
         $url_delete = site_url('employees2/delete/'.$row->EmployeeID);
         $action     = action_button($url_view, $url_update, $url_delete);

         $this->table->add_row($action, $no++, $row->LastName, $row->FirstName, $row->Title, $row->TitleOfCourtesy, $row->BirthDate, $row->HireDate, $row->Address, $row->City, $row->Region, $row->PostalCode, $row->Country, $row->HomePhone, $row->Extension, $row->Photo, word_limiter($row->Notes, 5), $row->ReportsTo, $row->Sex);
      }

      $generate_table = $this->table->generate().br(1).$this->jquery_pagination->create_links();
      
      echo $generate_table;   
   }


   public function view($id = null)
   {
      if (!$this->ion_auth->logged_in()){            
         redirect('auth/login', 'refresh');
      }

      $this->session->set_flashdata('page', 'view');
      $this->session->keep_flashdata('employee_q');
      $this->session->keep_flashdata('employee_offset');

      $query = $this->employees->where('EmployeeID', $id)->get();
      if($query){
         
         $img = '';
         if(!empty($query->Photo)){
            $thumb_name = $this->get_thumb_name($query->Photo);
            $img = img(array('src' => base_url('assets/uploads/' . $thumb_name), 'alt'=>$query->FirstName, 'title'=>$query->FirstName, 'width'=>'200px', 'class'=>'img-fluid img-thumbnail'));
         }

         $data = array('EmployeeID' => $query->EmployeeID,
                  'LastName'        => $query->LastName,
                  'FirstName'       => $query->FirstName,
                  'Title'           => $query->Title,
                  'TitleOfCourtesy' => $query->TitleOfCourtesy,
                  'BirthDate'       => $query->BirthDate,
                  'HireDate'        => $query->HireDate,
                  'Address'         => $query->Address,
                  'City'            => $query->City,
                  'Region'          => $query->Region,
                  'PostalCode'      => $query->PostalCode,
                  'Country'         => $query->Country,
                  'HomePhone'       => $query->HomePhone,
                  'Extension'       => $query->Extension,
                  'Photo'           => $img,
                  'Notes'           => $query->Notes,
                  'ReportsTo'       => $query->ReportsTo,
                  'Sex'             => $query->Sex);
      }

      $data['page_header']   = $this->page_header;
      $data['panel_heading'] = anchor(site_url('employees2'), 'Employee List') . ' / Employee View';
      $data['page']          = 'view';
      $this->template->backend('employees2_v', $data);
      
      //$this->load->view('backend/preview_employee', $data);
   }

   public function create()
   {
      if (!$this->ion_auth->logged_in()){            
         redirect('auth/login', 'refresh');
      }
      
      $this->session->set_flashdata('page', 'create');
      $this->session->keep_flashdata('employee_q');
      $this->session->keep_flashdata('employee_offset');

      $row = array('LastName'    => $this->input->post('LastName'),
               'FirstName'       => $this->input->post('FirstName'),
               'Title'           => $this->input->post('Title'),
               'TitleOfCourtesy' => $this->input->post('TitleOfCourtesy'),
               'BirthDate'       => $this->input->post('BirthDate'),
               'HireDate'        => $this->input->post('HireDate'),
               'Address'         => $this->input->post('Address'),
               'City'            => $this->input->post('City'),
               'Region'          => $this->input->post('Region'),
               'PostalCode'      => $this->input->post('PostalCode'),
               'Country'         => $this->input->post('Country'),
               'HomePhone'       => str_replace('_', '', $this->input->post('HomePhone')),
               'Extension'       => $this->input->post('Extension'),
               'Notes'           => $this->input->post('Notes'),
               'ReportsTo'       => $this->input->post('ReportsTo'),
               'Sex'             => $this->input->post('Sex'));

      if (isset($_POST['submit'])) {
         $rule =  array(
                  array('field' => 'LastName', 'label' => 'Last Name', 'rules' => 'trim|callback_alpha_space|required|max_length[20]'),
                  array('field' => 'FirstName', 'label' => 'Firts Name', 'rules' => 'trim|callback_alpha_space|required|max_length[20]'),                       
                  array('field' => 'Title', 'label' => 'Title', 'rules' => 'max_length[30]'),
                  array('field' => 'TitleOfCourtesy', 'label' => 'Title Of Courtesy', 'rules' => 'trim|callback_alpha_dot_coma_dash_space|max_length[25]'),
                  array('field' => 'Address', 'label' => 'Address', 'rules' => 'max_length[60]'),
                  array('field' => 'City', 'label' => 'City', 'rules' => 'max_length[15]'),
                  array('field' => 'Region', 'label' => 'Region', 'rules' => 'max_length[15]'),
                  array('field' => 'Country', 'label' => 'Country', 'rules' => 'max_length[15]'),
                  array('field' => 'PostalCode', 'label' => 'PostalCode', 'rules' => 'integer|max_length[10]'),
                  array('field' => 'HomePhone', 'label' => 'HomePhone', 'rules' => 'max_length[24]'),
                  array('field' => 'Extension', 'label' => 'Extension', 'rules' => 'max_length[24]'),
                  array('field' => 'userfile', 'label' => 'Photo', 'rules' => 'callback_do_upload')
                  );

         $this->form_validation->set_rules($rule);
         if ($this->form_validation->run() == true) {
            
            if (!empty($_FILES['userfile']['tmp_name'])) {
               $upload_data     = $this->upload->data();
               $row['Photo'] = $upload_data['file_name'];
            }

            $result_id = $this->employees->insert($row);
            
            $error =  $this->db->error();
            if($error['code'] <> 0){
               $this->session->set_flashdata('error', $error['code'].' : '.$error['message']);
            }
            else{
               $this->session->set_flashdata('success', 'Success Insert Data With ID ' . $result_id);
               redirect(site_url('employees2'));
            }
            
         }
         else{
            $data = $row;
         }
      }
      $data['all_employees'] = $this->employees->drop_down();

      $data['page_header']   = $this->page_header;
      $data['action']        = site_url('employees2/create/');
      $data['panel_heading'] = anchor(site_url('employees2'), 'Employee List') . ' / Employee Add';
      $data['page']          = 'add';
      $this->template->backend('employees2_v', $data);
   }

   public function update($id = null)
   {
      if (!$this->ion_auth->logged_in()){            
         redirect('auth/login', 'refresh');
      }

      $this->session->set_flashdata('page', 'update');
      $this->session->keep_flashdata('employee_q');
      $this->session->keep_flashdata('employee_offset');

      if (isset($_POST['submit'])) {
         $rule =  array(
                  array('field' => 'LastName', 'label' => 'Last Name', 'rules' => 'trim|callback_alpha_space|required|max_length[20]'),
                  array('field' => 'FirstName', 'label' => 'Firts Name', 'rules' => 'trim|callback_alpha_space|required|max_length[20]'),                       
                  array('field' => 'Title', 'label' => 'Title', 'rules' => 'max_length[30]'),
                  array('field' => 'TitleOfCourtesy', 'label' => 'Title Of Courtesy', 'rules' => 'trim|callback_alpha_dot_coma_dash_space|max_length[25]'),
                  array('field' => 'Address', 'label' => 'Address', 'rules' => 'max_length[60]'),
                  array('field' => 'City', 'label' => 'City', 'rules' => 'max_length[15]'),
                  array('field' => 'Region', 'label' => 'Region', 'rules' => 'max_length[15]'),
                  array('field' => 'Country', 'label' => 'Country', 'rules' => 'max_length[15]'),
                  array('field' => 'PostalCode', 'label' => 'PostalCode', 'rules' => 'integer|max_length[10]'),
                  array('field' => 'HomePhone', 'label' => 'HomePhone', 'rules' => 'max_length[24]'),
                  array('field' => 'Extension', 'label' => 'Extension', 'rules' => 'max_length[24]'),
                  array('field' => 'userfile', 'label' => 'Photo', 'rules' => 'callback_do_upload')
                  );

         $this->form_validation->set_rules($rule);
         if ($this->form_validation->run() == true) {
            $row = array('LastName'    => $this->input->post('LastName'),
                     'FirstName'       => $this->input->post('FirstName'),
                     'Title'           => $this->input->post('Title'),
                     'TitleOfCourtesy' => $this->input->post('TitleOfCourtesy'),
                     'BirthDate'       => $this->input->post('BirthDate'),
                     'HireDate'        => $this->input->post('HireDate'),
                     'Address'         => $this->input->post('Address'),
                     'City'            => $this->input->post('City'),
                     'Region'          => $this->input->post('Region'),
                     'PostalCode'      => $this->input->post('PostalCode'),
                     'Country'         => $this->input->post('Country'),
                     'HomePhone'       => str_replace('_', '', $this->input->post('HomePhone')),
                     'Extension'       => $this->input->post('Extension'),
                     'Notes'           => $this->input->post('Notes'),
                     'ReportsTo'       => $this->input->post('ReportsTo'),
                     'Sex'             => $this->input->post('Sex'));

               if (!empty($_FILES['userfile']['tmp_name'])) {
                  $query = $this->employees->fields('Photo')->where('EmployeeID', $id)->get();
                  if (!empty($query->Photo)) {
                     $this->delete_img($query->Photo);
                  }

                  $upload_data  = $this->upload->data();
                  $row['Photo'] = $upload_data['file_name'];
               }

            $this->employees->where('EmployeeID', $id)->update($row);
            
            $error =  $this->db->error();
            if($error['code'] <> 0){
               $this->session->set_flashdata('error', $error['code'].' : '.$error['message']);
            }
            else{
               $this->session->set_flashdata('success', 'Success Update Data');
               redirect(site_url('employees2'));
            }
         }
      }

      $query = $this->employees->where('EmployeeID', $id)->get();
      if($query){

         $img = '';
         if(!empty($query->Photo)){
            $thumb_name = $this->get_thumb_name($query->Photo);
            $img = img(array('src' => base_url('assets/uploads/' . $thumb_name), 'alt'=>$query->FirstName, 'title'=>$query->FirstName, 'width'=>'200px', 'class'=>'img-fluid img-thumbnail'));
         }

         $data = array('EmployeeID' => $query->EmployeeID,
            'LastName' => $query->LastName,
            'FirstName' => $query->FirstName,
            'Title' => $query->Title,
            'TitleOfCourtesy' => $query->TitleOfCourtesy,
            'BirthDate' => $query->BirthDate,
            'HireDate' => $query->HireDate,
            'Address'      => $query->Address,
            'City'         => $query->City,
            'Region'     => $query->Region,
            'PostalCode' => $query->PostalCode,
            'Country'    => $query->Country,
            'HomePhone'   => $query->HomePhone,
            'Extension'   => $query->Extension,
            'Photo'    => $img,
            'Notes'    => $query->Notes,
            'ReportsTo'  => $query->ReportsTo,
            'Sex'    => $query->Sex);
      }
      $data['all_employees'] = $this->employees->drop_down();

      $data['action']        = site_url('employees2/update/'.$id);
      $data['page_header']   = $this->page_header;
      $data['panel_heading'] = anchor(site_url('employees2'), 'Employee List') . ' / Employee Update';
      $data['page']          = 'update';
      $this->template->backend('employees2_v', $data);
   }

   public function delete($id = null)
   {
      if (!$this->ion_auth->logged_in()){            
         redirect('auth/login', 'refresh');
      }
      
      $this->session->set_flashdata('page', 'delete');
      $this->session->keep_flashdata('employee_q');
      $this->session->keep_flashdata('employee_offset');

      $this->employees->where('EmployeeID', $id)->delete();
      
      $error     =  $this->db->error();
      if($error['code'] <> 0){
         $this->session->set_flashdata('error', $error['code'].' : '.$error['message']);
      }
      else{
         $this->session->set_flashdata('success', 'Success Delete Data');
      }

     redirect(site_url('employees2'));
   }

   public function do_upload()
   {
      if (!empty($_FILES['userfile']['tmp_name'])) {
         $config['max_size']      = '1000';
         $config['max_width']     = '1200';
         $config['max_height']    = '1600';
         $config['upload_path']   = FCPATH . 'assets/uploads/'; 
         $config['allowed_types'] = 'jpg|gif|png|bmp';
         $config['max_filename']  = 100;
         $config['encrypt_name']  = true;
         $config['overwrite']     = false;
         $this->load->library('upload', $config);

         if (!$this->upload->do_upload()) {
             $this->form_validation->set_message('do_upload', $this->upload->display_errors());
             return false;
         } else {
             $upload_data = $this->upload->data();
             $width  = 600;
             $height = ($width / $upload_data['image_width']) * $upload_data['image_height'];
             
            $config_thumb['source_image']    = $upload_data['full_path'];
            $config_thumb['image_library']   = 'gd2';
            $config_thumb['create_thumb']    = true;
            $config_thumb['maintain_ration'] = true;

            $this->load->library('image_lib', $config_thumb);

            if (!$this->image_lib->resize()) {
              $this->form_validation->set_message('do_upload', $this->image_lib->display_errors());
              return false;
            }
         }
         return true;
      }
   }

   private function get_thumb_name($img_name)
   {
      $parts = explode('.', $img_name);
      return (count($parts) == 2) ? $parts[0] . '_thumb.' . $parts[1] : $img_name;
   }

   private function delete_img($img_name)
   {
      $upload_path = FCPATH . 'assets/uploads/';   
      
      $tumb_name = $this->get_thumb_name($img_name);
      
      if (file_exists($upload_path . $img_name)) {
         @unlink($upload_path . $img_name);
         @unlink($upload_path . $tumb_name);

         return true;
      }

      return false;
   }

   public function _preview(){
      
   }
   
   function alpha_space($str) 
   {
      if(!empty($str)){
         if (!preg_match('/^[a-zA-Z\s]+$/', $str)) {
            $this->form_validation->set_message('alpha_space', 'The %s is not valid, only alphabetic and space allowed.');
            return false;            
         } else {
            return true;
         }
      }
      return true;
   }

   public function alpha_dot_coma($str) 
   {
      if(!empty($str)){
         if (! preg_match('/^[a-zA-Z.,]+$/', $str))  {
            $this->form_validation->set_message('alpha_dot_coma', 'The %s is not valid, only alphabetic, dot and coma allowed.');
            return false;
         } else {
            return true;
         }  
      }
      return true;
   }

   public function alpha_dot_coma_dash_space($str)
   {
      if(!empty($str)){
         if (! preg_match('/^[a-zA-Z .,-]+$/', $str)) {
            $this->form_validation->set_message('alpha_dot_coma_dash_space', 'The %s is not valid, only alphabetic, dot, coma, dash and space allowed.');
            return FALSE;
         }  
         else {
           return TRUE;
         }     
      }
      return TRUE;
   }

   //Not Working
   public function numeric_dash($str)
   {
      if(!empty($str)){
         if (! preg_match('/^[0-9- \s]+$/', $str)) {
            $this->form_validation->set_message('numeric_dash', 'The %s is not valid, only numeric and dash allowed.');
            return FALSE;
         }  
         else {
           return TRUE;
         } 
      }
      return TRUE;
   }

   public function alpha_numeric_space($str)
   {
      if(!empty($str)){
         if (! preg_match('/^[a-zA-Z0-9 .,-]+$/', $str)) {
            $this->form_validation->set_message('alpha_numeric_space', 'The %s field may only contain alpha characters & White spaces');
            return FALSE;
         }  
         else {
           return TRUE;
         } 
      }
      return TRUE;
   }
}
