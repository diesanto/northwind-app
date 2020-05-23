<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');

class Shippers_model extends MY_Model
{
	protected $column_order = array(null, 'ShipperID','CompanyName','Phone'); 
    protected $column_search = array('ShipperID','CompanyName','Phone');
    protected $order = array('ShipperID' => 'asc');
        
	public function __construct()
	{
        $this->table       = 'shippers';
        $this->primary_key = 'ShipperID';
        $this->fillable    = $this->column_search;
        $this->timestamps  = FALSE;

        $this->has_many['orders'] = array('Orders_model', 'ShipperID', 'ShipperID');

		parent::__construct();
	}

    public function get_fields()
    {
        return $this->column_search;
    }

    private function _get_datatables_query()
    {
        
        $this->db->from($this->table);

        $i = 0;
        
        if(!empty($_POST['search']['value']))
        {
            foreach ($this->column_search as $item)
            {
                if(isset($_POST['search']['value']))
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

}
/* End of file '/Shipper_model.php' */
/* Location: ./application/models/Shipper_model.php */