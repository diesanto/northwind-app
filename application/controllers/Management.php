<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Management extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');

		$this->load->library(array('ion_auth', 'template', 'grocery_CRUD'));
	}

	public function data()
	{  
		if (!$this->ion_auth->logged_in() && !$this->ion_auth->is_admin()){            
		 redirect('auth/login', 'refresh');
		}

		$crud = new grocery_CRUD();

		$crud->set_theme('adminlte');

		$crud->set_table('data');
		$crud->set_subject('Dummy Data'); 

		$crud->display_as('name','Name')
		    ->display_as('phone','Phone');

		$crud->columns('id', 'name', 'phone');

		$grocery = (array)$crud->render();

		$data['page_header']  = ' Data Management';

		$data = array_merge($data, $grocery);

		$this->template->backend('data_grocery_v', $data);
	}

	public function employees()
	{
		$crud = new grocery_CRUD();

		$crud->set_theme('flexigrid');
		$crud->set_table('employees');
		$crud->set_subject('Employee');

		$crud->display_as('EmployeeID','Employee ID')
			->display_as('FirstName','First Name')
			->display_as('LastName','Last Name')
			->display_as('TitleOfCourtesy','Title Of Courtesy')
			->display_as('BirthDate','Birth Date')
			->display_as('HireDate','Hire Date')
			->display_as('PostalCode','Postal Code')
			->display_as('ReportsTo','Reports To')
			->display_as('HomePhone','Home Phone');

		$crud->set_field_upload('Photo','assets/uploads/photo');

		$crud->field_type('Sex','dropdown', array('M'=>'Male', 'F'=>'Female'));

		$state = $crud->getState();

		if ($state == 'export' || $state == 'print') {
		 $crud->columns('EmployeeID', 'FirstName','LastName', 'Title', 'TitleOfCourtesy', 'BirthDate', 'HireDate', 'Address', 'Region', 'Country', 'PostalCode', 'Country', 'HomePhone', 'Sex', 'Notes', 'ReportsTo');
		} else {
		 $crud->columns('FirstName', 'LastName', 'Title', 'HireDate', 'HomePhone', 'Sex');
		} 

		if($state != 'edit' && $state != 'update' && $state != 'update_validation'){
		 $crud->required_fields('EmployeeID', 'FirstName','LastName');
		}
		else{
		 $crud->required_fields('FirstName', 'LastName');
		 $crud->field_type('EmployeeID', 'readonly');
		}

		$grocery = (array)$crud->render();

		$data['page_header']  = ' Employees Management';

		$data = array_merge($data, $grocery);

		$this->template->backend('data_grocery_v', $data);
	}

	public function orders()
	{
		$crud = new grocery_CRUD();
		
		$crud->set_theme('adminlte');
		$crud->set_table('orders');
		$crud->set_subject('Order');

		$state = $crud->getState();

		if ($state == 'export' || $state == 'print') {
			$crud->columns('OrderID', 'OrderDate','RequiredDate', 'ShippedDate', 'ShipName', 'ShipAddress', 'ShipCity', 'ShipRegion', 'ShipPostalCode', 'ShipCountry');
		} else {
			$crud->columns('OrderID', 'CustomerID', 'OrderDate','RequiredDate', 'ShippedDate', 'ShipName');
		} 

		$crud->set_relation('CustomerID', 'customers', 'CompanyName');
		$crud->set_relation('EmployeeID', 'employees', '{FirstName} {LastName}');
		$crud->set_relation('ShipperID', 'shippers', 'CompanyName');

		$crud->display_as('OrderID','Order ID')
			->display_as('CustomerID','Customer')
			->display_as('EmployeeID','Employee Name')
			->display_as('OrderDate','Order Date')
			->display_as('RequiredDate','Required Date')
			->display_as('ShippedDate','Shipped Date')
			->display_as('ShipperID','Shipper')
			->display_as('ShipName','Ship Name')
			->display_as('ShipAddress','Ship Address')
			->display_as('ShipCity','Ship City')
			->display_as('ShipRegion','Ship Region')
			->display_as('ShipPostalCode','Ship Postal Code')
			->display_as('ShipCountry','Ship Country');
		
		$crud->add_action('Order Detail', '', site_url('management/order_details/'), 'fa fa-eye');
		$crud->add_action('Print', '', '', 'fa-print', array($this, 'url_callback_print'));

		$grocery = (array)$crud->render();

		$data['page_header']  	= ' Orders Management';

		$data = array_merge($data, $grocery);

		$this->template->backend('data_grocery_v', $data);
	}


	public function url_callback_print($primary_key, $row)
	{
	    return "javascript:openBlank('" . site_url('management/action_print') . '/' . $primary_key . "')";
	}

	public function action_print($id){
		echo (int) $id;
		exit;
	}

	public function order_details($id)
	{
		$crud = new grocery_CRUD();
		
		$crud->set_theme('adminlte');

		$crud->where('OrderID', (int) $id);
		$crud->set_table('order_details');
		$crud->set_subject('Order Details');

		$crud->set_relation('ProductID', 'products', 'ProductName');

		$crud->display_as('OrderID','Order ID')
			->display_as('ProductID','Product Name')
			->display_as('UnitPrice','Unit Pricee');

		$crud->field_type('OrderID', 'hidden', (int) $id);

		$state = $crud->getState();

		if ($state == 'list' || $state='success') {
			$data['custom_header'] = nbs(6).anchor(site_url('management/orders'), 'Back to Order', array('class'=>'btn btn-default'));
		}  

		$grocery = $crud->render();
 
		$data['page_header']   = 'Order ID : '.(int) $id;
		
		$data = array_merge($data, (array)$grocery);

		$this->template->backend('data_grocery_v', $data);
	}

	public function set_OrderID($value, $row){
		return form_input(array('name'=>'OrderID', 'value'=>$value, 'class'=>'form-control', 'readonly'=>'readonly'));
	}

	public function _example_output($output = null)
	{
		$this->load->view('example.php',(array)$output);
	}

	public function offices()
	{
		$output = $this->grocery_crud->render();

		$this->_example_output($output);
	}

	public function index()
	{
		$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}

	public function offices_management()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('offices');
			$crud->set_subject('Office');
			$crud->required_fields('city');
			$crud->columns('city','country','phone','addressLine1','postalCode');

			$output = $crud->render();

			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}



	public function customers_management()
	{
			$crud = new grocery_CRUD();

			$crud->set_table('customers');
			$crud->columns('customerName','contactLastName','phone','city','country','salesRepEmployeeNumber','creditLimit');
			$crud->display_as('salesRepEmployeeNumber','from Employeer')
				 ->display_as('customerName','Name')
				 ->display_as('contactLastName','Last Name');
			$crud->set_subject('Customer');
			//Fields asal, tabel, fields diambil
			$crud->set_relation('salesRepEmployeeNumber','employees','lastName');

			$output = $crud->render();

			$this->_example_output($output);
	}



	public function products_management()
	{
			$crud = new grocery_CRUD();

			$crud->set_table('products');
			$crud->set_subject('Product');
			$crud->unset_columns('productDescription');
			$crud->callback_column('buyPrice',array($this,'valueToEuro'));

			$output = $crud->render();

			$this->_example_output($output);
	}

	public function valueToEuro($value, $row)
	{
		return $value.' &euro;';
	}

	public function film_management()
	{
		$crud = new grocery_CRUD();

		$crud->set_table('film');
		$crud->set_relation_n_n('actors', 'film_actor', 'actor', 'film_id', 'actor_id', 'fullname','priority');
		$crud->set_relation_n_n('category', 'film_category', 'category', 'film_id', 'category_id', 'name');
		$crud->unset_columns('special_features','description','actors');

		$crud->fields('title', 'description', 'actors' ,  'category' ,'release_year', 'rental_duration', 'rental_rate', 'length', 'replacement_cost', 'rating', 'special_features');

		$output = $crud->render();

		$this->_example_output($output);
	}

	public function film_management_twitter_bootstrap()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('twitter-bootstrap');
			$crud->set_table('film');
			$crud->set_relation_n_n('actors', 'film_actor', 'actor', 'film_id', 'actor_id', 'fullname','priority');
			$crud->set_relation_n_n('category', 'film_category', 'category', 'film_id', 'category_id', 'name');
			$crud->unset_columns('special_features','description','actors');

			$crud->fields('title', 'description', 'actors' ,  'category' ,'release_year', 'rental_duration', 'rental_rate', 'length', 'replacement_cost', 'rating', 'special_features');

			$output = $crud->render();
			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}

	function multigrids()
	{
		$this->config->load('grocery_crud');
		$this->config->set_item('grocery_crud_dialog_forms',true);
		$this->config->set_item('grocery_crud_default_per_page',10);

		$output1 = $this->offices_management2();

		$output2 = $this->employees_management2();

		$output3 = $this->customers_management2();

		$js_files = $output1->js_files + $output2->js_files + $output3->js_files;
		$css_files = $output1->css_files + $output2->css_files + $output3->css_files;
		$output = "<h1>List 1</h1>".$output1->output."<h1>List 2</h1>".$output2->output."<h1>List 3</h1>".$output3->output;

		$this->_example_output((object)array(
				'js_files' => $js_files,
				'css_files' => $css_files,
				'output'	=> $output
		));
	}

	public function offices_management2()
	{
		$crud = new grocery_CRUD();
		$crud->set_table('offices');
		$crud->set_subject('Office');

		$crud->set_crud_url_path(site_url(strtolower(__CLASS__."/".__FUNCTION__)),site_url(strtolower(__CLASS__."/multigrids")));

		$output = $crud->render();

		if($crud->getState() != 'list') {
			$this->_example_output($output);
		} else {
			return $output;
		}
	}

	public function employees_management2()
	{
		$crud = new grocery_CRUD();

		$crud->set_theme('datatables');
		$crud->set_table('employees');
		$crud->set_relation('officeCode','offices','city');
		$crud->display_as('officeCode','Office City');
		$crud->set_subject('Employee');

		$crud->required_fields('lastName');

		$crud->set_field_upload('file_url','assets/uploads/files');

		$crud->set_crud_url_path(site_url(strtolower(__CLASS__."/".__FUNCTION__)),site_url(strtolower(__CLASS__."/multigrids")));

		$output = $crud->render();

		if($crud->getState() != 'list') {
			$this->_example_output($output);
		} else {
			return $output;
		}
	}

	public function customers_management2()
	{
		$crud = new grocery_CRUD();

		$crud->set_table('customers');
		$crud->columns('customerName','contactLastName','phone','city','country','salesRepEmployeeNumber','creditLimit');
		$crud->display_as('salesRepEmployeeNumber','from Employeer')
			 ->display_as('customerName','Name')
			 ->display_as('contactLastName','Last Name');
		$crud->set_subject('Customer');
		$crud->set_relation('salesRepEmployeeNumber','employees','lastName');

		$crud->set_crud_url_path(site_url(strtolower(__CLASS__."/".__FUNCTION__)),site_url(strtolower(__CLASS__."/multigrids")));

		$output = $crud->render();

		if($crud->getState() != 'list') {
			$this->_example_output($output);
		} else {
			return $output;
		}
	}

}
