<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Purchase_orders_model extends CRM_Model
{
    private $statuses;

    public function __construct()
    {
        parent::__construct();
        $this->statuses = do_action('before_set_purchase_order_statuses', [
            [
                'id' => 1,
                'name' => _l('purchase_order_status_created')
            ],
            [
                'id' => 2,
                'name' => _l('purchase_order_status_approved')
            ],
            [
                'id' => 3,
                'name' => _l('purchase_order_status_no_ready')
            ],
            [
                'id' => 4,
                'name' => _l('purchase_order_status_accepted')
            ],
            [
                'id' => 5,
                'name' => _l('purchase_order_status_production')
            ],
            [
                'id' => 6,
                'name' => _l('purchase_order_status_finished')
            ],
            [
                'id' => 7,
                'name' => _l('purchase_order_status_departured')
            ]
        ]);
    }

    public function update_status($id, $status)
    {
        $data = $this->set_status_date($status);
        $data['status'] = $status;
        $this->db->where('id', $id);
        $this->db->update('tblpurchaseorders', $data);
    }

    public function set_status_date($status)
    {
        $data = [];
        $key = '';
        if ($status == 3 || $status == 4) {
            $key = 'confirmed_at';
        } elseif ($status == 5) {
            $key = 'production_at';
        } elseif ($status == 6) {
            $key = 'finished_at';
        } elseif ($status == 7) {
            $key = 'departure_at';
        }
        if ($key != '') {
            $data[$key] = date('Y-m-d H:i:s');
        }
        return $data;
    }

    public function get($id = '', $where = [])
    {
        $this->db->select(['tblpurchaseorders.*', 'tblcurrencies.name as currency_name', 'tblclients.company as client_company', 'tblcustomerwarehouses.name as warehouse_name']);
        $this->db->from('tblpurchaseorders');
        $this->db->join('tblcurrencies', 'tblcurrencies.id = tblpurchaseorders.currency', 'left');
        $this->db->join('tblclients', 'tblclients.userid = tblpurchaseorders.clientid', 'left');
        $this->db->join('tblcustomerwarehouses', 'tblcustomerwarehouses.id = tblpurchaseorders.warehouse', 'left');
        $this->db->where($where);
        if (is_numeric($id)) {
            $this->db->where('tblpurchaseorders.id', $id);
            $purchase_order = $this->db->get()->row();
            if ($purchase_order) {
                $purchase_order->items = get_items_by_type('purchase_order', $id);
                foreach ($purchase_order->items as &$v) {
                    $v['children'] = get_items_children_by_item($v['id']);
                }
                $purchase_order->client = $this->clients_model->get($purchase_order->clientid);
            }

            return $purchase_order;
        }
        return $this->db->get()->result_array();
    }

    public function add($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['addedfrom'] = get_staff_user_id();
        if (isset($data['custom_fields'])) {
            $custom_fields = $data['custom_fields'];
            unset($data['custom_fields']);
        }

        $items = [];
        if (isset($data['newitems'])) {
            $items = $data['newitems'];
            unset($data['newitems']);
        }

        $newChildrenItem = [];
        if (isset($data['newItemschildren'])) {
            $newChildrenItem = $data['newItemschildren'];
            unset($data['newItemschildren']);
        }

        if (isset($data['item_id'])) {
            unset($data['item_id']);
        }

        if (isset($data['marzoni'])) {
            unset($data['marzoni']);
        }

        if (isset($data['art'])) {
            unset($data['art']);
        }

        if (isset($data['dis'])) {
            unset($data['dis']);
        }

        if (isset($data['col'])) {
            unset($data['col']);
        }

        if (isset($data['description'])) {
            unset($data['description']);
        }

        if (isset($data['weight'])) {
            unset($data['weight']);
        }

        if (isset($data['width'])) {
            unset($data['width']);
        }

        if (isset($data['color'])) {
            unset($data['color']);
        }

        if (isset($data['style'])) {
            unset($data['style']);
        }

        if (isset($data['unit_price'])) {
            unset($data['unit_price']);
        }

        if (isset($data['qty'])) {
            unset($data['qty']);
        }

        if (isset($data['amount'])) {
            unset($data['amount']);
        }

        if (isset($data['ex_mill'])) {
            unset($data['ex_mill']);
        }

        if (isset($data['eta_date'])) {
            unset($data['eta_date']);
        }

        $hook_data = do_action('before_purchase_order_added', [
            'data' => $data,
            'items' => $items,
        ]);

        $data = $hook_data['data'];
        $items = $hook_data['items'];
        $data['year'] = date('Y');

        $this->db->insert('tblpurchaseorders', $data);
        $insert_id = $this->db->insert_id();

        if ($insert_id) {
            if (isset($custom_fields)) {
                handle_custom_fields_post($insert_id, $custom_fields);
            }
            foreach ($items as $key => $item) {
                if ($itemid = add_new_sales_item_post($item, $insert_id, 'purchase_order')) {
                    _maybe_insert_post_item_tax($itemid, $item, $insert_id, 'purchase_order');
                }
                update_item_marzoni($item);
                $newChildren = $newChildrenItem[$key];
                foreach ($newChildren as $val) {
                    if (empty($val['marzine'])) {
                        continue;
                    }
                    $new_item_added = add_new_children_item_post($val, $itemid);
                }
            }
            
            do_action('after_purchase_order_added', $insert_id);

            return $insert_id;
        }
        return false;
    }

    public function update($data, $id)
    {
        $affectedRows = 0;

        $items = [];
        if (isset($data['items'])) {
            $items = $data['items'];
            unset($data['items']);
        }

        $newitems = [];
        if (isset($data['newitems'])) {
            $newitems = $data['newitems'];
            unset($data['newitems']);
        }
        $childrenItem = [];
        if (isset($data['itemschildren'])) {
            $childrenItem = $data['itemschildren'];
            unset($data['itemschildren']);
        }

        $newChildrenItem = [];
        if (isset($data['newItemschildren'])) {
            $newChildrenItem = $data['newItemschildren'];
            unset($data['newItemschildren']);
        }

        if (isset($data['custom_fields'])) {
            $custom_fields = $data['custom_fields'];
            if (handle_custom_fields_post($id, $custom_fields)) {
                $affectedRows++;
            }
            unset($data['custom_fields']);
        }

        if (isset($data['item_id'])) {
            unset($data['item_id']);
        }

        if (isset($data['marzoni'])) {
            unset($data['marzoni']);
        }

        if (isset($data['art'])) {
            unset($data['art']);
        }

        if (isset($data['dis'])) {
            unset($data['dis']);
        }

        if (isset($data['col'])) {
            unset($data['col']);
        }

        if (isset($data['description'])) {
            unset($data['description']);
        }

        if (isset($data['weight'])) {
            unset($data['weight']);
        }

        if (isset($data['width'])) {
            unset($data['width']);
        }

        if (isset($data['color'])) {
            unset($data['color']);
        }

        if (isset($data['style'])) {
            unset($data['style']);
        }

        if (isset($data['unit_price'])) {
            unset($data['unit_price']);
        }

        if (isset($data['qty'])) {
            unset($data['qty']);
        }

        if (isset($data['amount'])) {
            unset($data['amount']);
        }

        if (isset($data['ex_mill'])) {
            unset($data['ex_mill']);
        }

        if (isset($data['eta_date'])) {
            unset($data['eta_date']);
        }


        $hook_data = do_action('before_purchase_order_updated', [
            'data' => $data,
            'id' => $id,
            'items' => $items,
            'newitems' => $newitems,
            'removed_items' => isset($data['removed_items']) ? $data['removed_items'] : [],
        ]);

        $data = $hook_data['data'];
        $data['removed_items'] = $hook_data['removed_items'];
        $items = $hook_data['items'];
        $newitems = $hook_data['newitems'];
        
        foreach ($data['removed_items'] as $remove_item_id) {
            $purchase_order_item = $this->get_purchase_order_item($remove_item_id);
            if (handle_removed_sales_item_post($remove_item_id, 'purchase_order')) {
                $affectedRows++;
            }
        }

        unset($data['removed_items']);
        if (isset($data['removed_items_chilrden'])) {
            foreach ($data['removed_items_chilrden'] as $remove_children_item_id) {
                if (handle_removed_children_item_post($remove_children_item_id)) {
                    $affectedRows++;
                }
            }
            
            unset($data['removed_items_chilrden']);
        }
        

        $this->db->where('id', $id);
        $this->db->update('tblpurchaseorders', $data);
        if ($this->db->affected_rows() > 0) {
            $affectedRows++;
        }

        foreach ($items as $key => $item) {
            if (update_sales_item_post($item['itemid'], $item, 'item_order')) {
                $affectedRows++;
            }

            if (update_sales_item_post($item['itemid'], $item, 'marzoni')) {
                $affectedRows++;
            }

            if (update_sales_item_post($item['itemid'], $item, 'art')) {
                $affectedRows++;
            }

            if (update_sales_item_post($item['itemid'], $item, 'dis')) {
                $affectedRows++;
            }

            if (update_sales_item_post($item['itemid'], $item, 'col')) {
                $affectedRows++;
            }

            if (update_sales_item_post($item['itemid'], $item, 'description')) {
                $affectedRows++;
            }

            if (update_sales_item_post($item['itemid'], $item, 'weight')) {
                $affectedRows++;
            }

            if (update_sales_item_post($item['itemid'], $item, 'width')) {
                $affectedRows++;
            }

            if (update_sales_item_post($item['itemid'], $item, 'color')) {
                $affectedRows++;
            }

            if (update_sales_item_post($item['itemid'], $item, 'style')) {
                $affectedRows++;
            }

            if (update_sales_item_post($item['itemid'], $item, 'unit_price')) {
                $affectedRows++;
            }

            if (update_sales_item_post($item['itemid'], $item, 'qty')) {
                $affectedRows++;
            }

            if (update_sales_item_post($item['itemid'], $item, 'ex_mill')) {
                $affectedRows++;
            }

            if (update_sales_item_post($item['itemid'], $item, 'eta_date')) {
                $affectedRows++;
            }

            if (update_sales_item_post($item['itemid'], $item, 'not_shipped')) {
                $affectedRows++;
            }

            if (isset($item['custom_fields'])) {
                if (handle_custom_fields_post($item['itemid'], $item['custom_fields'])) {
                    $affectedRows++;
                }
            }

            if (!isset($item['taxname']) || (isset($item['taxname']) && count($item['taxname']) == 0)) {
                if (delete_taxes_from_item($item['itemid'], 'purchase_order')) {
                    $affectedRows++;
                }
            } else {
                $item_taxes = get_purchase_order_item_taxes($item['itemid']);
                $_item_taxes_names = [];
                foreach ($item_taxes as $_item_tax) {
                    array_push($_item_taxes_names, $_item_tax['taxname']);
                }

                $i = 0;
                foreach ($_item_taxes_names as $_item_tax) {
                    if (!in_array($_item_tax, $item['taxname'])) {
                        $this->db->where('id', $item_taxes[$i]['id'])
                            ->delete('purchase_order');
                        if ($this->db->affected_rows() > 0) {
                            $affectedRows++;
                        }
                    }
                    $i++;
                }
                if (_maybe_insert_post_item_tax($item['itemid'], $item, $id, 'purchase_order')) {
                    $affectedRows++;
                }
            }
            update_item_marzoni($item);
        }

        $newChildrenItems = [];
        foreach ($childrenItem as $v) {
            foreach ($v as $val) {
                $newChildrenItems[] = $val;
            }
        }
   
        foreach ($newChildrenItems as $k => $v) {
            if (update_children_item_post($v['id'], $v)) {
                $affectedRows++;
            }
        }
        $new_item_added = 0;
        foreach ($newitems as $key => $item) {
            if ($new_item_added = add_new_sales_item_post($item, $id, 'purchase_order')) {
                _maybe_insert_post_item_tax($new_item_added, $item, $id, 'purchase_order');
                $affectedRows++;
            }
        }
        
        $newChildren = [];
        foreach ($newChildrenItem as $v) {
            foreach ($v as $val) {
                if (empty($val['marzine'])) {
                    continue;
                }
                $newChildren[] = $val;
            }
        }

        foreach ($newChildren as $key => $item) {
            if (add_new_children_item_post($item, $new_item_added)) {
                $affectedRows++;
            }
        }

        if ($affectedRows > 0) {
            update_sales_total_tax_column($id, 'purchase_order', 'tblpurchaseorders');
        }

        if ($affectedRows > 0) {
            do_action('after_purchase_order_updated', $id);

            return true;
        }

        return false;
    }

    public function delete($id)
    {
        do_action('before_estimate_deleted', $id);
        $this->db->where('id', $id);
        $this->db->delete('tblpurchaseorders');
        if ($this->db->affected_rows() > 0) {
            $this->db->where('relid IN (SELECT id from tblitems_in WHERE rel_type="purchase_order" AND rel_id="' . $id . '")');
            $this->db->where('fieldto', 'items');
            $this->db->delete('tblcustomfieldsvalues');

            $this->db->where('item_id IN (SELECT id from tblitems_in WHERE rel_id="' . $id . '")');
            $this->db->delete('tblitems_in_tx_detail');

            $this->db->where('item_id IN (SELECT id from tblitems_in WHERE rel_id="' . $id . '")');
            $this->db->delete('tblitems_in_tx');

            $this->db->where('rel_id', $id);
            $this->db->where('rel_type', 'purchase_order');
            $this->db->delete('tblitems_in');

            $this->db->where('rel_id', $id);
            $this->db->where('rel_type', 'purchase_order');
            $this->db->delete('tblitemstax');

            $this->db->where('relid', $id);
            $this->db->where('fieldto', 'purchase_order');
            $this->db->delete('tblcustomfieldsvalues');


            return true;
        }
        return false;
    }

    public function get_purchase_order_item($id)
    {
        $this->db->where('id', $id);

        return $this->db->get('tblitems_in')->row();
    }

    public function get_statuses()
    {
        return $this->statuses;
    }

    public function get_status_name($id)
    {
        foreach ($this->statuses as $status) {
            if ($status['id'] == $id) {
                return $status['name'];
            }
        }

        return null;
    }

    public function set_status($id, $status)
    {
        $data['status'] = $status;
        $this->db->where('id', $id);
        $this->db->update('tblpurchaseorders', $data);
        return true;
    }

    public function get_goods_receive_detail($id = '', $where = [])
    {
        $this->db->select(['tblpurchaseorders.id', 'tblpurchaseorders.order_number']);
        $this->db->from('tblpurchaseorders');
//        $this->db->join('tblcustomerwarehouses', 'tblcustomerwarehouses.id = tblpurchaseorders.warehouse', 'left');
        $this->db->where($where);
        if (is_numeric($id)) {
            $this->db->where('tblpurchaseorders.id', $id);
            $purchase_order = $this->db->get()->row();
            if ($purchase_order) {
                $purchase_order->items = get_items_by_type('purchase_order', $id);
                foreach ($purchase_order->items as &$v) {
                    $v['children'] = get_items_children_by_item($v['id']);
                    foreach ($v['children'] as &$val) {
                        $val['detail'] = get_tx_detail($val['id'], $val['item_id']);
                        array_unshift($val['detail'], ['type' => 0]);
                    }
                }
            }

            return $purchase_order;
        }
        return $this->db->get()->result_array();
    }

    public function get_order_number()
    {
        $this->db->select(['tblpurchaseorders.id', 'tblpurchaseorders.order_number']);
        $this->db->from('tblpurchaseorders');
//        $this->db->join('tblcustomerwarehouses', 'tblcustomerwarehouses.id = tblpurchaseorders.warehouse', 'left');
        $this->db->where('year', date('Y'));

        return $this->db->get()->result_array();
    }
}
