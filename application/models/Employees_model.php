<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');

class Employees_model extends MY_Model
{
	protected $column_order = array(null, 'EmployeeID','LastName','FirstName', 'Title', 'TitleOfCourtesy','BirthDate', 'HireDate', 'Address', 'City', 'Region', 'PostalCode', 'Country','HomePhone', 'Extension', 'Photo', 'Notes', 'ReportsTo', 'Sex'); 
    protected $column_search = array('EmployeeID','LastName','FirstName', 'Title', 'TitleOfCourtesy','BirthDate', 'HireDate', 'Address', 'City', 'Region', 'PostalCode', 'Country','HomePhone', 'Extension', 'Photo', 'Notes', 'ReportsTo', 'Sex');
    protected $order = array('EmployeeID' => 'asc');
        
	public function __construct()
	{
        $this->table       = 'employees';
        $this->primary_key = 'EmployeeID';
        $this->fillable    = $this->column_order;
        $this->timestamps  = FALSE;

        $this->has_many['orders'] = array('Employees_model', 'EmployeeID', 'EmployeeID');

		parent::__construct();
	}

    public function get_fields()
    {
        array_shift($this->column_order);
        
        return $this->column_order;
    }

    public function drop_down($where = null)
    {
        $drop_down = array();

        $count_rows = $this->where($where)->count_rows();     

        if($count_rows > 0)
        {
            $query = $this->where($where)->get_all();
            foreach ($query as $row) {
                $drop_down[$row->EmployeeID] = $row->FirstName .' '.$row->LastName; 
            } 
        }

        return $drop_down;
    }

}
/* End of file '/Employees_model.php' */
/* Location: ./application/models/Employees_model.php */