<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');

class Data_model extends MY_Model
{
	var $column_order = array(null, 'id','name','phone'); //field yang ada di table user
    var $column_search = array('id','name','phone'); //field yang diizin untuk pencarian 
    var $order = array('id' => 'asc'); // default order 


    public function __construct()
	{
        $this->table = 'data';
        $this->primary_key = 'id';

        $this->timestamps = FALSE;

		parent::__construct();
	}

    //Start Data Tables
    private function _get_datatables_query()
    {
        
        $this->db->from($this->table);

        $i = 0;
    
        foreach ($this->column_search as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        
        if(isset($_POST['order'])) // here order processing
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
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    //End Data Tables

    public function get_by($key = '', $limit = '', $offset = 0) 
    {
        if (!empty($limit)) {
            $this->db->limit($limit, $offset);
        }

        $this->db->from($this->table);

        if (!empty($key)) {
            $where = array();
            $fields = $this->db->field_data($this->table);
            //$this->db->like('data.name', $key);
            
            foreach ($fields as $field) {
                $where[$this->table . '.' . $field->name] = $key;
            }

            $this->db->or_like($where);
        }

        $query = $this->db->get();

        return $query;
    }	

}
/* End of file '/Data_model.php' */
/* Location: ./application/models//Data_model.php */