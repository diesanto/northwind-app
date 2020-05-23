<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CI_Controller {

   private $page_header = 'Customers Management';

   public function __construct()
   {
      parent::__construct();


      $this->load->model('customers_model', 'customers');
      $this->load->library(array('ion_auth', 'form_validation', 'template'));
      $this->load->helper('bootstrap_helper');
   }

	public function index()
	{  
      
      if (!$this->ion_auth->logged_in()){            
         redirect('auth/login', 'refresh');
      }

      $data['page_header']   = $this->page_header;
      $data['panel_heading'] = 'Customer List';
      $data['page']         = '';

      $this->template->backend('customers_v', $data);
	}

   public function get_customers()
   {
      if (!$this->ion_auth->logged_in()){            
         redirect('auth/login', 'refresh');
      }

      $list = $this->customers->get_datatables();
      $data = array();
      $no = isset($_POST['start']) ? $_POST['start'] : 0;
      foreach ($list as $field) { 
         $id = $field->CustomerID;

         $url_view   = site_url('customers/view/'.$id);
         $url_update = site_url('customers/update/'.$id);
         $url_delete = site_url('customers/delete/'.$id);

         $no++;
         $row = array();
         $row[] = action_button($url_view, $url_update, $url_delete);
         $row[] = $no;
         $row[] = $id;
         $row[] = $field->CompanyName;
         $row[] = $field->ContactName;
         $row[] = $field->ContactTitle;
         $row[] = $field->Address;
         $row[] = $field->City;
         $row[] = $field->Region;
         $row[] = $field->PostalCode;
         $row[] = $field->Country;
         $row[] = $field->Phone;
         $row[] = $field->Fax;

         $data[] = $row;
      }
      
      $draw = isset($_POST['draw']) ? $_POST['draw'] : null;

      $output = array(
         "draw" => $draw,
         "recordsTotal" => $this->customers->count_rows(),
         "recordsFiltered" => $this->customers->count_filtered(),
         "data" => $data,
      );
      //output dalam format JSON
      echo json_encode($output);
   }


   public function view($id = null)
   {
      $query = $this->customers->where('CustomerID', $id)->get();
      if($query){
         $data = array('CustomerID' => $query->CustomerID,
             'CompanyName' => $query->CompanyName,
             'ContactName' => $query->ContactName,
             'ContactTitle' => $query->ContactTitle,
             'Address'      => $query->Address,
             'City'         => $query->City,
             'Region'     => $query->Region,
             'PostalCode' => $query->PostalCode,
             'Country'    => $query->Country,
             'Phone'    => $query->Phone,
             'Fax'      => $query->Fax);
      }

      $data['page_header']   = $this->page_header;
      $data['panel_heading'] = anchor(site_url('customers'), 'Customer List') . ' / Customer View';
      $data['page']          = 'view';
      $this->template->backend('customers_v', $data);
   }

   public function create()
   {
      $row = array('CustomerID' => $this->input->post('CustomerID'),
             'CompanyName' => $this->input->post('CompanyName'),
             'ContactName' => $this->input->post('ContactName'),
             'ContactTitle' => $this->input->post('ContactTitle'),
             'Address'      => $this->input->post('Address'),
             'City'         => $this->input->post('City'),
             'Region'     => $this->input->post('Region'),
             'PostalCode' => $this->input->post('PostalCode'),
             'Country'    => $this->input->post('Country'),
             'Phone'    => $this->input->post('Phone'),
             'Fax'      => $this->input->post('Fax'));

      if (isset($_POST['submit'])) {
         $rule =  array(
                     array('field' => 'CustomerID', 'label' => 'Customer ID', 'rules' => 'required|is_unique[customers.CustomerID]|max_length[5]'),
                     array('field' => 'CompanyName', 'label' => 'Company Name', 'rules' => 'trim|callback_alpha_dash_space|required|max_length[40]'),                      
                     array('field' => 'ContactTitle', 'label' => 'Contact Title', 'rules' => 'callback_alpha_dash_space|max_length[30]'),
                     array('field' => 'Address', 'label' => 'Address', 'rules' => 'max_length[60]'),
                     array('field' => 'City', 'label' => 'City', 'rules' => 'max_length[15]'),
                     array('field' => 'Region', 'label' => 'Region', 'rules' => 'callback_alpha_dash_space|max_length[15]'),
                     array('field' => 'Country', 'label' => 'Country', 'rules' => 'max_length[15]'),
                     array('field' => 'PostalCode', 'label' => 'PostalCode', 'rules' => 'max_length[10]'),
                     array('field' => 'Phone', 'label' => 'Phone', 'rules' => 'max_length[24]'),
                     array('field' => 'Fax', 'label' => 'Fax', 'rules' => 'max_length[24]')
                  );

         $this->form_validation->set_rules($rule);
         if ($this->form_validation->run() == true) {
            $this->customers->insert($row);
            
            $error =  $this->db->error();
            if($error['code'] <> 0){
               $this->session->set_flashdata('error', $error['code'].' : '.$error['message']);
            }
            else{
               $this->session->set_flashdata('success', 'Success Insert Data');
               redirect(site_url('customers'));
            }
            
         }
         else{
            $data = $row;
         }
      }

      $data['page_header']   = $this->page_header;
      $data['action']        = site_url('customers/create/');
      $data['panel_heading'] = anchor(site_url('customers'), 'Customer List') . ' / Customer Add';
      $data['page']          = 'add';
      $this->template->backend('customers_v', $data);
   }

   public function update($id = null)
   {

      if (isset($_POST['submit'])) {
         $rule =  array(
                     array('field' => 'CustomerID', 'label' => 'Customer ID', 'rules' => 'required|max_length[5]'),
                     array('field' => 'CompanyName', 'label' => 'Company Name', 'rules' => 'trim|callback_alpha_dash_space|required|max_length[40]'),                      
                     array('field' => 'ContactTitle', 'label' => 'Contact Title', 'rules' => 'callback_alpha_dash_space|max_length[30]'),
                     array('field' => 'Address', 'label' => 'Address', 'rules' => 'max_length[60]'),
                     array('field' => 'City', 'label' => 'City', 'rules' => 'max_length[15]'),
                     array('field' => 'Region', 'label' => 'Region', 'rules' => 'callback_alpha_space|max_length[15]'),
                     array('field' => 'Country', 'label' => 'Country', 'rules' => 'max_length[15]'),
                     array('field' => 'PostalCode', 'label' => 'PostalCode', 'rules' => 'max_length[10]'),
                     array('field' => 'Phone', 'label' => 'Phone', 'rules' => 'max_length[24]'),
                     array('field' => 'Fax', 'label' => 'Fax', 'rules' => 'max_length[24]')
                  );

         $this->form_validation->set_rules($rule);
         if ($this->form_validation->run() == true) {
            $row = array('CustomerID' => $this->input->post('CustomerID'),
                'CompanyName' => $this->input->post('CompanyName'),
                'ContactName' => $this->input->post('ContactName'),
                'ContactTitle' => $this->input->post('ContactTitle'),
                'Address'      => $this->input->post('Address'),
                'City'         => $this->input->post('City'),
                'Region'     => $this->input->post('Region'),
                'PostalCode' => $this->input->post('PostalCode'),
                'Country'    => $this->input->post('Country'),
                'Phone'    => $this->input->post('Phone'),
                'Fax'      => $this->input->post('Fax'));

            $result = $this->customers->where('CustomerID', $id)->update($row);
            if ($result) {
               $this->session->set_flashdata('success', 'Success Update Data');
               redirect(site_url('customers'));
            }
         }
      }
      $query = $this->customers->where('CustomerID', $id)->get();
      if($query){
         $data = array('CustomerID' => $query->CustomerID,
             'CompanyName' => $query->CompanyName,
             'ContactName' => $query->ContactName,
             'ContactTitle' => $query->ContactTitle,
             'Address'      => $query->Address,
             'City'         => $query->City,
             'Region'     => $query->Region,
             'PostalCode' => $query->PostalCode,
             'Country'    => $query->Country,
             'Phone'    => $query->Phone,
             'Fax'      => $query->Fax);
      }

      $data['action']        = site_url('customers/update/'.$id);
      $data['page_header']   = $this->page_header;
      $data['panel_heading'] = anchor(site_url('customers'), 'Customer List') . ' / Customer Add';
      $data['page']          = 'update';
      $this->template->backend('customers_v', $data);
   }

   public function delete($id = null)
   {
         if (!$this->ion_auth->logged_in()){            
            redirect('auth/login', 'refresh');
        }

        $result = $this->customers->where('CustomerID', $id)->delete();
        if(!$result){
            $this->session->set_flashdata('error', 'Error Delete Data');
        }
        else{
            $this->session->set_flashdata('success', 'Success Delete Data');            
        }
        redirect(site_url('customers'));
   }
   //^ and $ Tells that it is the beginning and the end of the string a-z are lowercase letters, A-Z are uppercase letters \s is whitespace and + means 1 or more times.

   public function alpha_dash_space($str)
   {
      if($str != null){
         if (! preg_match('/^[a-zA-Z\s]+$/', $str)) {
            $this->form_validation->set_message('alpha_dash_space', 'The %s field may only contain alpha characters & White spaces');
            return FALSE;
         }  
         else {
           return TRUE;
         }
      }
   }

   public function alpha_space($str) 
   {
      if($str != null){
         if (preg_match('/^[a-zA-Z\s]+$/', $str) !== 0) {
            return true;
         } else {
            $this->form_validation->set_message('alpha_space', '%s is not valid.');
            return false;
         }
      }
      return true;
   }

   //This RegEx expression will ensure that first_name contains letters, dashes and spaces only, must start with upper case letter and must not start with a dash
   function validate_name($str) 
   {
      if (preg_match("/^[A-Z][a-zA-Z -]+$/", $str) !== 0) {
         return true;
      } else {
         $this->form_validation->set_message("validate_name", '%s is not valid.');
         return false;
      }
   }

   function alpha_numeric_space($str)
   {
      return ( ! preg_match('/^([a-z0-9 ])+$/i', $str)) ? FALSE : TRUE;
   }
}
