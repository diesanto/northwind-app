<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employeesx extends CI_Controller {

   protected $page_header = 'Employees Management';

   public function __construct()
   {
      parent::__construct();


      $this->load->model('employeesx_model', 'employees');
      $this->load->library(array('ion_auth', 'form_validation', 'template'));
      $this->load->helper('bootstrap_helper');
   }

	public function index()
	{  
      
      if (!$this->ion_auth->logged_in()){            
         redirect('auth/login', 'refresh');
      }

      $data['page_header']   = $this->page_header;
      $data['panel_heading'] = 'Employee List : ' . $this->session->flashdata('iDisplayStart');
      $data['page']         = '';

      $this->template->backend('employeesx_v', $data);
	}

   public function get_employees()
   {
      if (!$this->ion_auth->logged_in()){            
         redirect('auth/login', 'refresh');
      }
      

      $list = $this->employees->get_datatables();
      $data = array();
      $no   = isset($_POST['start']) ? $_POST['start'] : 0;

      foreach ($list as $field) { 
         $id = $field->EmployeeID;

         $url_view   = site_url('employeesx/view/'.$id);
         $url_update = site_url('employeesx/update/'.$id);
         $url_delete = site_url('employeesx/delete/'.$id);

         $no++;
         $row = array();
         $row[] = action_button($url_view, $url_update, $url_delete);
         $row[] = $no;
         //$row[] = $id;
         $row[] = $field->LastName;
         $row[] = $field->FirstName;
         $row[] = $field->Title;
         $row[] = $field->TitleOfCourtesy;
         $row[] = $field->BirthDate;
         $row[] = $field->HireDate;
         $row[] = $field->Address;
         $row[] = $field->City;
         $row[] = $field->Region;
         $row[] = $field->PostalCode;
         $row[] = $field->Country;
         $row[] = $field->HomePhone;
         $row[] = $field->Extension;
         $row[] = $field->Photo;
         $row[] = word_limiter($field->Notes, 5);
         $row[] = $field->ReportsTo;
         $row[] = $field->Sex;

         $data[] = $row;
      }
      
      $draw = isset($_POST['draw']) ? $_POST['draw'] : null;

      $output = array(
         "draw" => $draw,
         "recordsTotal" => $this->employees->count_rows(),
         "recordsFiltered" => $this->employees->count_filtered(),
         "data" => $data,
      );
      
      $this->session->set_flashdata('iDisplayStart', $_POST['start']);
      $this->session->set_flashdata('searchValue', $_POST['search']['value']);
      $this->session->set_flashdata('recordsFiltered', $output["recordsFiltered"]);
      $this->session->set_flashdata('recordsTotal', $output["recordsTotal"]);

      echo json_encode($output);
   }

   private function form_data($row = array())
   {
      $img = '';
      if(!empty($row->Photo)){
         $thumb_name = $this->get_thumb_name($row->Photo);
         $img = img(array('src' => base_url('assets/uploads/' . $thumb_name), 'alt'=>$row->FirstName, 'title'=>$row->FirstName, 'width'=>'200px', 'class'=>'img-fluid img-thumbnail'));
      }

      $all_employees = $this->employees->drop_down();

      if(!empty($row->Sex) && $row->Sex == 'F'){
         $male   = false;
         $female = true;
      }
      else{
         $male   = true;
         $female = false;
      }

      $data = array('FirstName' => form_input(array('name'=>'FirstName', 'class'=>'form-control', 'id'=>'FirstName', 'value'=>!empty($row->FirstName) ?$row->FirstName : '')),
            'LastName' => form_input(array('name'=>'LastName', 'class'=>'form-control', 'id'=>'LastName', 'value'=>!empty($row->LastName) ?$row->LastName : '')),
            'Title' => form_input(array('name'=>'Title', 'class'=>'form-control', 'id'=>'Title', 'value'=>!empty($row->Title) ?$row->Title : '')),
            'TitleOfCourtesy' => form_input(array('name'=>'TitleOfCourtesy', 'class'=>'form-control', 'id'=>'TitleOfCourtesy', 'value'=>!empty($row->TitleOfCourtesy) ? $row->TitleOfCourtesy : '')),
            'Male'=>form_radio(array('name'=>'Sex', 'id'=>'Male', 'value'=>'M', 'checked'=>$male)).' Male',
            'Female'=>form_radio(array('name'=>'Sex', 'id'=>'Female', 'value'=>'F', 'checked'=>$female)).' Female',
            'BirthDate' => form_input(array('name'=>'BirthDate', 'class'=>'form-control', 'id'=>'BirthDate', 'data-inputmask' => "'alias': 'yyyy-mm-dd'", 'data-mask'=>'data-mask','value'=>!empty($row->BirthDate) ?$row->BirthDate : '')),
            'HireDate' => form_input(array('name'=>'HireDate', 'class'=>'form-control', 'id'=>'datepicker', 'value'=>!empty($row->HireDate) ?$row->HireDate : '')),
            'Photo' => form_upload('userfile'). br(1) . $img,
            'Address' => form_input(array('name'=>'Address', 'class'=>'form-control', 'id'=>'Address', 'value'=>!empty($row->Address) ?$row->Address : '')),
            'City' => form_input(array('name'=>'City', 'class'=>'form-control', 'id'=>'City', 'value'=>!empty($row->City) ?$row->City : '')),
            'Region' => form_input(array('name'=>'Region', 'class'=>'form-control', 'id'=>'Region', 'value'=>!empty($row->Region) ?$row->Region : '')),
            'PostalCode' => form_input(array('name'=>'PostalCode', 'class'=>'form-control', 'id'=>'PostalCode', 'data-inputmask' => "'mask': '99999'", 'data-mask'=>'data-mask', 'value'=>!empty($row->PostalCode) ?$row->PostalCode : '')),
            'HomePhone' => form_input(array('name'=>'HomePhone', 'class'=>'form-control', 'id'=>'HomePhone', 'data-inputmask' => "'mask': '0899-9999-99999'", 'data-mask'=>'data-mask', 'value'=>!empty($row->HomePhone) ?$row->HomePhone : '')),
            'Extension' => form_input(array('name'=>'Extension', 'class'=>'form-control', 'id'=>'Extension', 'value'=>!empty($row->Extension) ?$row->Extension : '')),
            'Country' => form_input(array('name'=>'Country', 'class'=>'form-control', 'id'=>'Country', 'value'=>!empty($row->Country) ?$row->Country : '')),
            'Notes' => form_textarea(array('name'=>'Notes', 'class'=>'form-control', 'id'=>'Notes', 'value'=>!empty($row->Notes) ?$row->Notes : '')),
            'ReportsTo' => form_dropdown('ReportsTo', $all_employees, !empty($row->ReportsTo) ? $row->ReportsTo : 0, 'class="select2 form-control"')
               );

      return $data;
   }

   public function view($id = null)
   {
      if (!$this->ion_auth->logged_in()){            
         redirect('auth/login', 'refresh');
      }

      $this->session->keep_flashdata('iDisplayStart');
      $this->session->keep_flashdata('searchValue');
      $this->session->keep_flashdata('recordsFiltered');
      $this->session->keep_flashdata('recordsTotal');

      $query = $this->employees->where('EmployeeID', $id)->get();
      if($query){
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
            'Photo'    => $query->Photo,
            'Notes'    => $query->Notes,
            'ReportsTo'  => $query->ReportsTo,
            'Sex'    => $query->Sex);
      }

      $data['page_header']   = $this->page_header;
      $data['panel_heading'] = anchor(site_url('employeesx'), 'Employee List') . ' / Employee View';
      $data['page']          = 'view';
      $this->template->backend('employeesx_v', $data);
   }

   public function create()
   {
      if (!$this->ion_auth->logged_in()){            
         redirect('auth/login', 'refresh');
      }

      $this->session->keep_flashdata('iDisplayStart');
      $this->session->keep_flashdata('searchValue');
      $this->session->keep_flashdata('recordsFiltered');
      $this->session->keep_flashdata('recordsTotal');

      $row = array();
      if (isset($_POST['submit'])) {
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
               redirect(site_url('employeesx'));
            }
            
         }
         else{
            $row = (object) $row;
         }
      }


      $data = $this->form_data($row);

      $data['page_header']   = $this->page_header;
      $data['action']        = site_url('employeesx/create/');
      $data['panel_heading'] = anchor(site_url('employeesx'), 'Employee List') . ' / Employee Add';
      $data['page']          = 'add';
      $this->template->backend('employeesx_v', $data);
   }

   public function update($id = null)
   {
      if (!$this->ion_auth->logged_in()){            
         redirect('auth/login', 'refresh');
      }

      $this->session->keep_flashdata('iDisplayStart');
      $this->session->keep_flashdata('searchValue');
      $this->session->keep_flashdata('recordsFiltered');
      $this->session->keep_flashdata('recordsTotal');
      if (isset($_POST['submit'])) {
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
               redirect(site_url('employeesx'));
            }
         }
         else{
            $row = (object) $row;
         }
      }
     
      if(empty($row)){
        $row = $this->employees->where('EmployeeID', $id)->get();
      }

      $data = $this->form_data($row);

      $data['action']        = site_url('employeesx/update/'.$id);
      $data['page_header']   = $this->page_header;
      $data['panel_heading'] = anchor(site_url('employeesx'), 'Employee List') . ' / Employee Update';
      $data['page']          = 'update';
      $this->template->backend('employeesx_v', $data);
   }

   public function delete($id = null)
   {
      if (!$this->ion_auth->logged_in()){            
            redirect('auth/login', 'refresh');
      }

      $recordsFiltered = $this->session->flashdata('recordsFiltered') - 1;
      $this->session->set_flashdata('recordsFiltered', $recordsFiltered);

      $this->session->keep_flashdata('iDisplayStart');
      $this->session->keep_flashdata('searchValue');
      $this->session->keep_flashdata('recordsTotal');

      $this->employees->where('EmployeeID', $id)->delete();
      $error = $this->db->error();
      if($error['code'] <> 0){
         $this->session->set_flashdata('error', $error['code'].' : '.$error['message']);
      }
      else{
         $this->session->set_flashdata('success', 'Success Delete Data');
      }
      redirect(site_url('employeesx'));
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

   function alpha_space($str) 
   {
      if (preg_match('/^[a-zA-Z\s]+$/', $str) !== 0) {
         return true;
      } else {
         $this->form_validation->set_message('alpha_space', '%s is not valid.');
         return false;
      }
   }

   function alpha_dot_coma($str) 
   {
      if (preg_match('/^[a-zA-Z.,]+$/', $str) !== 0) {
         return true;
      } else {
         $this->form_validation->set_message('alpha_dot_coma', '%s is not valid.');
         return false;
      }
   }

   //^ and $ Tells that it is the beginning and the end of the string a-z are lowercase letters, A-Z are uppercase letters \s is whitespace and + means 1 or more times dot(.) coma(,) and dash(-)
   public function alpha_dot_coma_dash_space($str)
   {
      if (! preg_match('/^[a-zA-Z .,-]+$/', $str)) {
         $this->form_validation->set_message('alpha_dot_coma_dash_space', 'The %s field may only contain alpha characters & White spaces');
         return FALSE;
      }  
      else {
        return TRUE;
      }
   }

   public function alpha_numeric_space($str)
   {
      if (! preg_match('/^[a-zA-Z0-9 .,-]+$/', $str)) {
         $this->form_validation->set_message('alpha_numeric_space', 'The %s field may only contain alpha characters & White spaces');
         return FALSE;
      }  
      else {
        return TRUE;
      }
   }
}
