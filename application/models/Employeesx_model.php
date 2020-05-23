<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');

class Employeesx_model extends MY_Model
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

    private function _get_datatables_query()
    {
        
        $this->db->select($this->column_search);

        $this->db->from($this->table);

        $i = 0;
        
        if(!empty($_POST['search']['value']))
        {
            foreach ($this->column_search as $item)
            {
                if($_POST['search']['value'])
                {
                    
                    if($i===0)
                    {
                        $this->db->group_start(); 
                        $this->db->like($item, $_POST['search']['value']);
                    }
                    else
                    {
                        $this->db->or_like($item, $_POST['search']['value']);
                    }

                    if(count($this->column_search) - 1 == $i)
                        $this->db->group_end();
                }
                $i++;
            }
        }
        
        if(isset($_POST['order']))
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();

        $length = isset($_POST['length']) ? $_POST['length'] : 0;
        if($length != -1){
            $start  = isset($_POST['start']) ? $_POST['start'] : 0;         
            $this->db->limit($length, $start);
        }
        $query = $this->db->get();
        
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_fields()
    {
        array_shift($this->column_order);
        
        return $this->column_order;
    }

    public function drop_down($where = null)
    {
        $query = $this->where($where)->get_all();

        $drop_down = array();
        if(count($query) > 0){
            foreach ($query as $row) {
                $drop_down[$row->EmployeeID] = $row->FirstName .' '.$row->LastName; 
            } 
        }

        return $drop_down;
    }

}
/* End of file '/Employees_model.php' */
/* Location: ./application/models/Employees_model.php */