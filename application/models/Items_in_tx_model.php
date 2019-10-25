<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Items_in_tx_model extends CRM_Model
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
        $order = array_column(get_order(), null, 'id');
        $itemsIn = array_column(get_items_in(), null, 'id');
        $this->db->select();
        $this->db->from('tblitems_in_tx');
        $this->db->where('item_id IN (SELECT id from tblitems_in where rel_id IN (SELECT id from tblpurchaseorders WHERE supplier="' . $id . '"))');

        $tx = $this->db->get()->result_array();
        if ($tx) {
            foreach ($tx as $k => &$val) {
                $po_no = $order[$itemsIn[$val['item_id']]['rel_id']]['order_number'];
                $val['po_no'] = $po_no;
                $detail = $this->get_tx_detail($val['id']);
                if (!empty($detail)) {
                    $qty = 0;
                    foreach ($detail as $v) {
                        $qty += $v['qty'];
                    }
                    if ($qty == $val['qty']) {
                        unset($tx[$k]);
                    }
                    $val['qty'] -= $qty;
                }
            }
        }

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

    public function get_sum_qty($id, $in_tx_id)
    {
        $this->db->select_sum('qty');
        $this->db->from('tblitems_in_tx_detail');

        $this->db->where('in_tx_id', $in_tx_id);
        $this->db->where('id!=', $id);
        return $this->db->get()->row();
    }

    public function get_qty_by_id($id)
    {
        $this->db->select('qty');
        $this->db->from('tblitems_in_tx');
        $this->db->where('id', $id);
        return $this->db->get()->row();
    }

}
