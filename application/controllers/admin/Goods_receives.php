<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Goods_receives extends Admin_controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['items_in_tx_model', 'suppliers_model', 'customer_warehouses_model', 'items_in_tx_detail_model', 'purchase_orders_model']);
    }

    public function index()
    {
        $this->load->view('admin/goods_receives/manage');
    }
    public function goods($id = '')
    {
        if ($this->input->post()) {
            $purchase_order_data = $this->input->post();
            if ($id == '') {
                $id = $this->items_in_tx_detail_model->add($purchase_order_data);
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('goods_receive')));
                }
            } else {
                $success = $this->items_in_tx_detail_model->update($purchase_order_data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('purchase_order')));
                }
            }

            redirect(admin_url('goods_receives'));
        }

        if ($id != '') {
            $goods_detail = $this->items_in_tx_detail_model->get_goods_receive_detail($id);

            $data['goods_detail'] = $goods_detail;
            $data['edit'] = true;
        }

        $data['suppliers'] = $this->suppliers_model->get();
        $data['warehouse'] = $this->customer_warehouses_model->get('');

        $this->load->view('admin/goods_receives/goods', $data);
    }

    public function table()
    {
        $this->app->get_table_data('goods_receives');
    }

    /* Get item by id / ajax */
    public function get_item_by_id($id)
    {
        if ($this->input->is_ajax_request()) {
            $item = $this->items_in_tx_model->get($id);
            echo json_encode($item);
        }
    }

    public function view($number)
    {
        $newData = [];
        if (!$number) {
            redirect(admin_url('goods_receives'));
        }
//        $order = $this->purchase_orders_model->get_goods_receive_detail($number);
        $order = $this->items_in_tx_detail_model->get_goods_receive_detail($number);
        foreach ($order as $v) {
            $newData[$v['rel_id']][] = $v;
        }

//        foreach ($newData as $k => &$v) {
//            array_unshift($v,$v[0]);
//        }
//        print_r($newData);die;
        $data['order'] = $newData;
        $data['title'] = _l('goods_receive');

        $this->load->view('admin/goods_receives/view', $data);
    }

    public function view1($number)
    {
        if (!$number) {
            redirect(admin_url('goods_receives'));
        }
        $order = $this->purchase_orders_model->get_goods_receive_detail($number);
        $data['order'] = $order;
        $data['title'] = _l('goods_receive');

        $this->load->view('admin/goods_receives/view1', $data);
    }

    public function approve($poNumber)
    {
        $this->items_in_tx_detail_model->approve($poNumber);
        redirect(admin_url('goods_receives'));
    }

    public function remove($poNumber)
    {
        $this->items_in_tx_detail_model->remove($poNumber);
        redirect(admin_url('goods_receives'));
    }

}
