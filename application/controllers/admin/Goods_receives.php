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
    public function goods()
    {
        if ($this->input->post()) {
            $purchase_order_data = $this->input->post();
            $id = $this->items_in_tx_detail_model->add($purchase_order_data);
            if ($id) {
                set_alert('success', _l('added_successfully', _l('goods_receive')));
            }
            redirect(admin_url('goods_receives'));
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

    public function view($id)
    {
        if (!$id) {
            redirect(admin_url('goods_receives'));
        }
        $order = $this->purchase_orders_model->get_goods_receive_detail($id);

        $data['order'] = $order;
        $data['title'] = _l('purchase_order');
//        print_r($data);die;
        $this->load->view('admin/goods_receives/view', $data);
    }

}
