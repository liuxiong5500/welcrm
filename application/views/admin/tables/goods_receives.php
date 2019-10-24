<?php
defined('BASEPATH') or exit('No direct script access allowed');

$this->ci->load->model('items_in_tx_detail_model');

$aColumns = [
    'reference_no',
    'gr_date',
    'suppliers.company as supplier_company',
    'prepared_by',
    'is_approve',
    'approved_by',
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
    $url = admin_url('goods_receives/view/' . $aRow['reference_no']);
    $order_number = '<a href="' . $url . '">' . $aRow['reference_no'] . '</a>';
    $order_number .= '<div class="row-options">';

    if ($aRow['is_approve'] == 1) {
        $order_number .= '<a href="' . admin_url('goods_receives/goods/' . $aRow['reference_no']) . '">' . _l('edit') . '</a>';
        $order_number .= ' | <a href="' . admin_url('goods_receives/delete/' . $aRow['reference_no']) . '">' . _l('delete') . '</a>';
        $order_number .= ' | <a href="' . admin_url('goods_receives/approve/' . $aRow['reference_no']) . '">' . _l('approve') . '</a>';
    } else {
        $order_number .= '<a href="' . admin_url('goods_receives/remove/' . $aRow['reference_no']) . '">' . _l('haha') . '</a>';
    }

    $order_number .= '</div>';
    $row[] = $order_number;
    $row[] = $aRow['gr_date'];
    $row[] = $aRow['supplier_company'];
    $row[] = $aRow['is_approve'] == 2 ? 'Yes' : 'No';
    $row[] = get_staff_full_name($aRow['prepared_by']);
    $row[] = get_staff_full_name($aRow['approved_by']);


    $hook = do_action('customers_table_row_data', [
        'output' => $row,
        'row' => $aRow,
    ]);

    $row = $hook['output'];

    $output['aaData'][] = $row;
}

