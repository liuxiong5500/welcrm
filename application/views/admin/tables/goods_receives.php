<?php
defined('BASEPATH') or exit('No direct script access allowed');

$this->ci->load->model('items_in_tx_detail_model');

$aColumns = [
    'peference_no',
    'gr_date',
    'suppliers.company as supplier_company',
];
$sIndexColumn = 'id';
$sTable = 'tblitems_in_tx_detail';
$where = [];
// Add blank where all filter can be stored
$filter = [];

$join = [
//    'LEFT JOIN tblpurchaseorders AS items ON items.id=tblitems_in_tx.item_id',
    'LEFT JOIN tblsuppliers AS suppliers ON suppliers.id=tblitems_in_tx_detail.supplier',
];

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, []);

$result['rResult'] = array_values(array_unique($result['rResult'], SORT_REGULAR));

$output = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    $url = admin_url('goods_receives/view/' . $aRow['peference_no']);
    $order_number = '<a href="' . $url . '">' . $aRow['peference_no'] . '</a>';
//    $order_number .= '<div class="row-options">';
////    if ($aRow['status'] == 1) {
////        $order_number .= '<a href="' . admin_url('purchase_orders/approve/' . $aRow['id']) . '">' . _l('approve') . '</a> | ';
////    }
//    $order_number .= '<a href="' . admin_url('purchase_orders/order/' . $aRow['id']) . '">' . _l('edit') . '</a>';
//    $order_number .= ' | <a href="' . admin_url('purchase_orders/delete/' . $aRow['id']) . '">' . _l('delete') . '</a>';
//    $order_number .= '</div>';
    $row[] = $order_number;
    $row[] = $aRow['gr_date'];
    $row[] = $aRow['supplier_company'];
//    $row[] = $aRow['warehouse_name'];
//    $row[] = $aRow['pe_number'];
//    $row[] = _d(date('Y-m-d', strtotime($aRow['po_date'])));
//    $row[] = $aRow['currency_name'];
//    $row[] = $aRow['currency_rate'];
//    $row[] = $this->ci->purchase_orders_model->get_status_name($aRow['status']);
//    $row[] = $aRow['total'];
//    $row[] = $aRow['created_at'];


    $hook = do_action('customers_table_row_data', [
        'output' => $row,
        'row' => $aRow,
    ]);

    $row = $hook['output'];

    $output['aaData'][] = $row;
}
