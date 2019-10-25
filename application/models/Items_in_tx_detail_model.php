<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Items_in_tx_detail_model extends CRM_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function add($data)
    {
        $addData = [];

        if (isset($data['add_new']) && !empty($data['add_new'])) {
            foreach ($data['add_new'] as $k => $v) {
                if (!isset($v['in_tx_id'])) {
                    continue;
                }
                $addData['reference_no'] = $data['peference_no'];
                $addData['qty'] = $v['qty'];
                $addData['type'] = 1;
                $addData['in_tx_id'] = $v['in_tx_id'];
                $addData['item_id'] = $v['item_id'];
                $addData['ware_house'] = $data['ware_house'];
                $addData['gr_date'] = $data['gr_date'];
                $addData['prepared_by'] = get_staff_user_id();
                $addData['supplier'] = $data['supplier'];
                $this->db->insert('tblitems_in_tx_detail', $addData);
            }
        }

        return true;
    }

    public function update($data, $id)
    {
        $addData = [];
        $this->db->where('reference_no', $id)->delete('tblitems_in_tx_detail');

        if (isset($data['add_new']) && !empty($data['add_new'])) {
            foreach ($data['add_new'] as $k => $v) {
                if (!isset($v['in_tx_id'])) {
                    continue;
                }
                $addData['reference_no'] = $data['peference_no'];
                $addData['qty'] = $v['qty'];
                $addData['type'] = 1;
                $addData['in_tx_id'] = $v['in_tx_id'];
                $addData['item_id'] = $v['item_id'];
                $addData['ware_house'] = $data['ware_house'];
                $addData['gr_date'] = $data['gr_date'];
                $addData['prepared_by'] = get_staff_user_id();
                $addData['supplier'] = $data['supplier'];
                $this->db->insert('tblitems_in_tx_detail', $addData);
            }
        }

        return true;
    }

    public function get_goods_receive_detail($id = '')
    {
        $this->db->select(['tblitems_in_tx_detail.*', 'tblitems_in.rel_id as rel_id', 'tblitems_in_tx.marzoni as tx_marzoni', 'tblitems_in_tx.qty as tx_qty', 'tblcustomerwarehouses.name as house_name']);
        $this->db->from('tblitems_in_tx_detail');
        $this->db->join('tblitems_in_tx', 'tblitems_in_tx.id = tblitems_in_tx_detail.in_tx_id', 'left');
        $this->db->join('tblitems_in', 'tblitems_in.id = tblitems_in_tx_detail.item_id', 'left');
        $this->db->join('tblcustomerwarehouses', 'tblcustomerwarehouses.id = tblitems_in_tx_detail.ware_house', 'left');
        $this->db->where('tblitems_in_tx_detail.reference_no', $id);
        if (is_numeric($id)) {

            $purchase_order = $this->db->get()->row();

            return $purchase_order;
        }
        return $this->db->get()->result_array();
    }


    public function get($id = '')
    {
        $this->db->select();
        $this->db->from('tblitems_in_tx_detail');
        $this->db->where('tblitems_in_tx_detail.reference_no', $id);
        return $this->db->get()->result_array();
    }

    public function approve($poNumber)
    {
        $addData['is_approve'] = 2;
        $addData['approved_by'] = get_staff_user_id();
        $addData['approved_date'] = date('Y-m-d');
        $this->db->where('reference_no', $poNumber)->update('tblitems_in_tx_detail', $addData);
    }

    public function remove($poNumber)
    {
        $addData['is_approve'] = 1;
        $addData['approved_by'] = 0;
        $addData['approved_date'] = '';
        $this->db->where('reference_no', $poNumber)->update('tblitems_in_tx_detail', $addData);
    }

    public function delete($poNumber)
    {
        $this->db->where('reference_no', $poNumber);
        $this->db->delete('tblitems_in_tx_detail');
    }


}
