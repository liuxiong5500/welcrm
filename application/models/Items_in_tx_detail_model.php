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
                $addData['peference_no'] = $data['peference_no'];
                $addData['qty'] = $v['qty'];
                $addData['type'] = 1;
                $addData['in_tx_id'] = $v['in_tx_id'];
                $addData['item_id'] = $v['item_id'];
                $addData['ware_house'] = $data['ware_house'];
                $addData['gr_date'] = $data['gr_date'];
                $addData['prepared_by'] = get_staff_user_id();
                $this->db->insert('tblitems_in_tx_detail', $addData);
            }
        }

        return true;
    }


}
