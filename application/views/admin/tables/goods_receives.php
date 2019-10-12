<?php
defined('BASEPATH') or exit('No direct script access allowed');

$this->ci->load->model('Items_in_tx_model');

$aColumns = [
    'tblitems_in_tx.marzoni as marzoni',
    'items.rel_id as item_po_number',
    'tblitems_in_tx.qty as qty'
];
$sIndexColumn = 'id';
$sTable = 'tblitems_in_tx';
$where = [];
// Add blank where all filter can be stored
$filter = [];

$join = [
    'LEFT JOIN tblitems_in AS items ON items.id=tblitems_in_tx.item_id',
];

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [
    'tblitems_in_tx.id'
]);

$output = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    $url = admin_url('purchase_orders/view/' . $aRow['id']);
    $order_number = '<a href="' . $url . '">' . $aRow['marzoni'] . '</a>';
    $order_number .= '<div class="row-options">';
//    if ($aRow['status'] == 1) {
//        $order_number .= '<a href="' . admin_url('purchase_orders/approve/' . $aRow['id']) . '">' . _l('approve') . '</a> | ';
//    }
    $order_number .= '<a href="' . admin_url('purchase_orders/order/' . $aRow['id']) . '">' . _l('edit') . '</a>';
    $order_number .= ' | <a href="' . admin_url('purchase_orders/delete/' . $aRow['id']) . '">' . _l('delete') . '</a>';
    $order_number .= '</div>';
    $row[] = $order_number;
    $row[] = $aRow['item_po_number'];
    $row[] = $aRow['qty'];
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
