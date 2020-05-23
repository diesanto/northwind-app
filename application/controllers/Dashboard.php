<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model(array('customers_model'=>'customers', 'suppliers_model'=>'suppliers', 'data_model'=>'data'));
        $this->load->library(array('ion_auth', 'template'));
    }

    public function index()
    {
        if (!$this->ion_auth->logged_in()){
            
            redirect('auth/login', 'refresh');
        }

        $data['count_customers'] = $this->customers->count_rows();
        $data['count_suppliers'] = $this->suppliers->count_rows();
        $data['count_data']      = $this->data->count_rows();

        $this->template->backend('dashboard_v', $data);
    }
}
