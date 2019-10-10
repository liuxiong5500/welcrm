<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Goods_receives extends Admin_controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['items_in_children_model', 'suppliers_model', 'customer_warehouses_model']);
    }

    public function index()
    {
        $this->load->view('admin/goods_receives/manage');
    }
    public function goods()
    {
        $data['suppliers'] = $this->suppliers_model->get();
        $data['warehouse'] = $this->customer_warehouses_model->get('');

        $this->load->view('admin/goods_receives/goods', $data);
    }

    public function table()
    {
        $this->app->get_table_data('goods_receives');
    }

}
