<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Management extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');

		$this->load->library(array('ion_auth', 'template', 'grocery_CRUD'));

		if (!$this->ion_auth->logged_in() && !$this->ion_auth->is_admin()){            
			redirect('auth/login', 'refresh');
		}
	}

	public function users()
	{
		$crud = new grocery_CRUD();
		
		$crud->set_theme('adminlte'); 

		$crud->set_table('users');
		$crud->set_subject('Pengguna');        
		
		//$crud->set_relation('id', 'groups', 'name');

		$crud->columns('username','email','real_name','active', 'group_id');
		$crud->fields('username','email','password', 'real_name','active', 'group_id');

		$crud->display_as('real_name','Nama Lengkap')
			->display_as('group_id','Grup');		

		$crud->change_field_type('password', 'password');
		//$crud->field_type('group_id','set',array('banana','orange','apple','lemon'));



		$state = $crud->getState();
		
		if($state != 'edit' && $state != 'update' && $state != 'update_validation'){
		 	$crud->required_fields('username');
		 	$crud->set_rules('email', 'Email', 'required|email|is_unique[users.email]');

		 	$query  = $this->ion_auth->groups()->result();
	        $groups = array();
	        foreach ($query as $row) {
	            $groups[$row->id] = $row->name;
	        }

			$crud->field_type('group_id','dropdown', $groups);
		}
		else{
			$crud->field_type('username', 'readonly')
				->field_type('email', 'readonly');
				 
			$crud->callback_edit_field('group_id', function ($value, $primary_key) {
					$query  = $this->ion_auth->groups()->result();
			        $groups = array();
			        foreach ($query as $row) {
			            $groups[$row->id] = $row->name;
			        }

					return form_dropdown('group_id', $groups, $value, 'class="form-control" id="group"');
			});

		}
		
		$crud->callback_before_insert(array($this,'encrypt_password_callback'));
		$crud->callback_before_update(array($this,'encrypt_password_callback'));

		/*
		$crud->callback_add_field('group_id', function () {
		   	$query  = $this->ion_auth->groups()->result();
	        $groups = array();
	        foreach ($query as $row) {
	            $groups[$row->id] = $row->name;
	        }

			return form_dropdown('group_id', '', 'class="form-control" id="group"');
		});
		

		*/
		$crud->callback_edit_field('password', function ($value, $primary_key) {
			return '<input type="password" name="password" value="" class="form-control" />';
		});

		$crud->callback_after_insert(array($this, 'callback_create_group'));
		$crud->callback_after_update(array($this, 'callback_create_group'));

		$grocery = (array)$crud->render();

		$data['page_header']  = ' Data Pengguna';

		$data = array_merge($data, $grocery);

		$this->template->backend('data_grocery_v', $data);
	}
	 
	function encrypt_password_callback($post_array, $primary_key = null)
	{
		if(!empty($post_array['password'])){
			$post_array['password']	= md5($post_array['password']);	
		}
		else{
			unset($post_array['password']);
		}

		return $post_array;
	}

	function callback_create_group($post_array,$primary_key)
	{		 
		$this->ion_auth->remove_from_group('', $primary_key);
		$this->ion_auth->add_to_group($post_array['group_id'], $primary_key);
		//$this->db->insert('users_groups',array('user_id'=>$primary_key,'group_id'=>$post_array['id']));
		return true;
	}


	public function groups()
	{  
		$crud = new grocery_CRUD();

		$crud->set_theme('adminlte');

		$crud->set_table('groups');
		$crud->set_subject('Grup Pengguna'); 

		$crud->display_as('name','Nama Grup')
			->display_as('description','Deskripsi');

		$crud->columns('name', 'description');

		$grocery = (array)$crud->render();

		$data['page_header']  = ' Data Grup Pengguna';

		$data = array_merge($data, $grocery);

		$this->template->backend('data_grocery_v', $data);
	}

	public function kategori_wisata()
	{  
		$crud = new grocery_CRUD();

		$crud->set_theme('adminlte');

		$crud->set_table('kategori_wisata');
		$crud->set_subject('Kategori Wisata'); 

		$crud->display_as('nama_kategori','Nama Kategori');

		$crud->columns('id_kategori', 'nama_kategori');

		$grocery = (array)$crud->render();

		$data['page_header']  = ' Data Kategori Wisata';

		$data = array_merge($data, $grocery);

		$this->template->backend('data_grocery_v', $data);
	}

	public function objek_wisata()
	{
		$crud = new grocery_CRUD();

		$crud->set_theme('adminlte');
		$crud->set_table('objek_wisata');
		$crud->set_subject('Objek Wisata');

		$crud->set_relation('id_kategori', 'kategori_wisata', 'nama_kategori');
		$crud->set_relation('id_kecamatan', 'master_kecamatan', 'nama_kecamatan');
		$crud->set_relation('id_desa', 'master_desa', 'nama_desa');
		$crud->set_relation('id_dusun', 'master_dusun', 'nama_dusun');

		$crud->display_as('nama_objek_wisata','Nama Wisata')
			->display_as('id_kategori','Kategori Wisata')
			->display_as('alamat','Alamat')
			->display_as('id_kecamatan','Kecamatan')
			->display_as('id_desa','Desa')
			->display_as('id_dusun','Dusun')
			->display_as('lat','Latitude')
			->display_as('lng','Longitude')
			->display_as('deskripsi','Deskripsi');

		$crud->unset_texteditor('alamat', 'full_text');
		$crud->set_field_upload('foto1','assets/uploads/photo', 'jpg|jpeg|png');
		$crud->set_field_upload('foto2','assets/uploads/photo', 'jpg|jpeg|png');
		$crud->set_field_upload('foto3','assets/uploads/photo', 'jpg|jpeg|png');
		//$crud->callback_after_upload(array($this,'callback_after_upload'));

		$state = $crud->getState();

		if ($state == 'export' || $state == 'print') {
		 $crud->columns('nama_objek_wisata', 'id_kategori','alamat', 'id_dusun', 'id_desa', 'id_kecamatan', 'lat', 'lng', 'deskripsi');
		} else {
		 $crud->columns('nama_objek_wisata', 'id_kategori','alamat','id_kecamatan');
		} 

		$crud->required_fields('nama_objek_wisata');

		$grocery = (array)$crud->render();

		$data['page_header']  = ' Data Objek Wisata';

		$data = array_merge($data, $grocery);

		$this->template->backend('data_grocery_v', $data);
	}


	public function callback_after_upload($uploader_response, $field_info, $files_to_upload)
	{
		$this->load->library('image_moo');
	 	
		//Is only one file uploaded so it ok to use it with $uploader_response[0].
		for ($i=0; $i < count($uploader_response) ; $i++) { 
			$file_uploaded = $field_info->upload_path.'/'.$uploader_response[$i]->name; 
		 	
		 	$parts = explode('.', $uploader_response[$i]->name);
	      	$new_filename = (count($parts) == 2) ? $parts[0] . '_thumb.' . $parts[1] : $img_name;
			$new_fileuploded = $field_info->upload_path.'/'.$new_filename;
			
			$this->image_moo->load($file_uploaded)->resize(800, 600)->save($new_fileuploded, true);
		}

		return true;
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

	public function index()
	{
		$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}


}
