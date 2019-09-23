<?php

class Production_logs_model extends CRM_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($item_id = '')
    {
        if (is_numeric($item_id)) {
            $this->db->where('item_id', $item_id);

            return $this->db->get('tblproductionlogs')->result_array();
        }
        return [];
    }

    public function add($data)
    {
        unset($data['id']);
        $this->db->insert('tblproductionlogs', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            return true;
        }

        return false;
    }

    public function get_finished_count($item_id = '')
    {
        $this->db->select_sum('finished');
        if (is_numeric($item_id)) {
            $this->db->where('item_id', $item_id);

            return $this->db->get('tblproductionlogs')->row();
        }
        return 0;
    }

    public function get_shipped_count($item_id = '')
    {
        $this->db->select_sum('shipped');
        if (is_numeric($item_id)) {
            $this->db->where('item_id', $item_id);

            return $this->db->get('tblproductionlogs')->row();
        }
        return 0;
    }
}
