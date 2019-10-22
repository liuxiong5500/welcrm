<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Items_in_model extends CRM_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get invoice item by ID
     * @param  mixed $id
     * @return mixed - array if not passed id, object if id passed
     */
    public function get($id = '')
    {
        $this->db->select('tblpurchaseorders.order_number');
        $this->db->from('tblitems_in');
        $this->db->join('tblpurchaseorders', 'tblpurchaseorders.id = tblitems_in.rel_id', 'left');
        $this->db->where('tblitems_in.id', $id);
        $tx = $this->db->get()->row();

        return $tx;
    }

    public function get_tx_detail($id = '')
    {
        $this->db->select();
        $this->db->from('tblitems_in_tx_detail');
        if (is_numeric($id)) {
            $this->db->where('in_tx_id', $id);

        }
        return $this->db->get()->result_array();
    }


}
