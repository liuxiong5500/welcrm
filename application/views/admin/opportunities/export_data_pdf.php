<?php

$pdf = new Pdf('L', 'mm', 'landscape', true, 'UTF-8', false);
$pdf->SetTitle($opportunity->name);
$this->pdf->SetMargins(PDF_MARGIN_LEFT, 26, PDF_MARGIN_RIGHT);
$this->pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$this->pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$this->pdf->SetAutoPageBreak(TRUE, 30);
$pdf->SetAuthor(get_option('company'));
$pdf->SetFont(get_option('pdf_font'), '', get_option('pdf_font_size'));
$pdf->AddPage();
$dimensions = $pdf->getPageDimensions();
$custom_fields = get_custom_fields('opportunities');

$divide_document_overview = 3;
// If custom fields found divide the overview in 4 parts not in 3 to include the custom fields too
if(count($custom_fields) > 0){
    $divide_document_overview = 4;
}

// Like heading opportunity name
$html = '<h1>'._l('opportunity_name').': '.$opportunity->name.'</h1>';
// opportunity overview heading
$html .= '<h3>'.ucwords(_l('opportunity_overview')).'</h3>';
if(!empty($opportunity->description)){
    // opportunity description
    $html .= '<p><b style="background-color:#f0f0f0;">' . _l('opportunity_description') . '</b><br /><br /> ' . $opportunity->description . '</p>';
}

$pdf->writeHTML($html, true, false, false, false, '');
$pdf->Ln(10);
$html = '';
// opportunity overview
// Billing type
if($opportunity->billing_type == 1){
  $type_name = 'opportunity_billing_type_fixed_cost';
} else if($opportunity->billing_type == 2){
  $type_name = 'opportunity_billing_type_opportunity_hours';
} else {
  $type_name = 'opportunity_billing_type_opportunity_task_hours';
}
$html .= '<b style="background-color:#f0f0f0;">'._l('opportunity_overview').'</b><br /><br />';

$html .= '<b>'._l('opportunity_billing_type').': </b>' . _l($type_name) . '<br />';

if($opportunity->billing_type == 1 || $opportunity->billing_type == 2){
  if($opportunity->billing_type == 1){
      $html .= '<b>'._l('opportunity_total_cost').': </b>' . format_money($opportunity->opportunity_cost,$opportunity->currency_data->symbol) . '<br />';
  } else {
    $html .= '<b>'._l('opportunity_rate_per_hour').': </b>' . format_money($opportunity->opportunity_rate_per_hour,$opportunity->currency_data->symbol) . '<br />';
  }
}
$status = get_opportunity_status_by_id($opportunity->status);
// opportunity status
$html .= '<b>' . _l('opportunity_status') . ': </b>' . $status['name'] . '<br />';
// Date created
$html .= '<b>' . _l('opportunity_datecreated') . ': </b>' . _d($opportunity->opportunity_created) . '<br />';
// Start date
$html .= '<b>' . _l('opportunity_start_date') . ': </b>' . _d($opportunity->start_date) . '<br />';
// Deadline
$d = $opportunity->deadline ? _d($opportunity->deadline) : '/';
$html .= '<b>' . _l('opportunity_deadline') . ': </b>' . $d  . '<br /><br />';
// Total Days
$html .= '<b>' . _l('total_opportunity_worked_days') . ': </b>' . $total_days . '<br />';
// Total logged hours for this opportunity
$html .= '<b>' . _l('opportunity_overview_total_logged_hours') . ': </b>' . $total_logged_time . '<br />';
// Total members
$html .= '<b>' . _l('total_opportunity_members') . ': </b>' . $total_members . '<br />';
// Total files
$html .= '<b>' . _l('total_opportunity_files') . ': </b>' . $total_files_attached . '<br />';
// Total Discussions
$html .= '<b>' . _l('total_opportunity_discussions_created') . ': </b>' . $total_files_attached . '<br />';
// Total Milestones
$html .= '<b>' . _l('total_milestones') . ': </b>' . $total_milestones . '<br />';
// Total Tickets
$html .= '<b>' . _l('total_tickets_related_to_opportunity') . ': </b>' . $total_tickets . '<br />';
// Write opportunity overview data
$pdf->MultiCell(($dimensions['wk'] / $divide_document_overview) - $dimensions['lm'], 0, $html, 0, 'L', 0, 0, '', '', true, 0, true);

$html = '';
$html .= '<b style="background-color:#f0f0f0;">'.ucwords(_l('finance_overview')) . '</b><br /><br />';
$html .= '<b>' . _l('opportunities_total_invoices_created') . ' </b>' . $total_invoices .'<br />';
// Not paid invoices total
$html .= '<b>' . _l('outstanding_invoices') . ' </b>' . format_money($invoices_total_data['due'],$opportunity->currency_data->symbol) .'<br />';
// Due invoices total
$html .= '<b>' . _l('past_due_invoices') . ' </b>' . format_money($invoices_total_data['overdue'],$opportunity->currency_data->symbol) .'<br />';
// Paid invoices
$html .= '<b>' . _l('paid_invoices') . ' </b>' . format_money($invoices_total_data['paid'],$opportunity->currency_data->symbol) .'<br /><br />';

// Finance Overview
if($opportunity->billing_type == 2 || $opportunity->billing_type == 3) {
    // Total logged time + money
    $logged_time_data = $this->opportunities_model->total_logged_time_by_billing_type($opportunity->id);
    $html .= '<b>' . _l('opportunity_overview_logged_hours') . ' </b>' . $logged_time_data['logged_time'] . ' - ' . format_money($logged_time_data['total_money'],$opportunity->currency_data->symbol) .'<br />';
    // Total billable time + money
    $logged_time_data = $this->opportunities_model->data_billable_time($opportunity->id);
    $html .= '<b>' . _l('opportunity_overview_billable_hours') . ' </b>' . $logged_time_data['logged_time'] . ' - ' . format_money($logged_time_data['total_money'],$opportunity->currency_data->symbol) .'<br />';
    // Total billed time + money
    $logged_time_data = $this->opportunities_model->data_billed_time($opportunity->id);
    $html .= '<b>' . _l('opportunity_overview_billed_hours') . ' </b>' . $logged_time_data['logged_time'] . ' - ' . format_money($logged_time_data['total_money'],$opportunity->currency_data->symbol) .'<br />';
    // Total unbilled time + money
    $logged_time_data = $this->opportunities_model->data_unbilled_time($opportunity->id);
    $html .= '<b>' . _l('opportunity_overview_unbilled_hours') . ' </b>' . $logged_time_data['logged_time'] . ' - ' . format_money($logged_time_data['total_money'],$opportunity->currency_data->symbol) .'<br /><br/>';
}

// Total expenses + money
$html .= '<b>' . _l('opportunity_overview_expenses') . ': </b>' . format_money(sum_from_table('tblexpenses',array('where'=>array('opportunity_id'=>$opportunity->id),'field'=>'amount')),$opportunity->currency_data->symbol) . '<br />';
// Billable expenses + money
$html .= '<b>' . _l('opportunity_overview_expenses_billable') . ': </b>' . format_money(sum_from_table('tblexpenses',array('where'=>array('opportunity_id'=>$opportunity->id,'billable'=>1),'field'=>'amount')),$opportunity->currency_data->symbol) . '<br />';
// Billed expenses + money
$html .= '<b>' . _l('opportunity_overview_expenses_billed') . ': </b>' . format_money(sum_from_table('tblexpenses',array('where'=>array('opportunity_id'=>$opportunity->id,'invoiceid !='=>'NULL','billable'=>1),'field'=>'amount')),$opportunity->currency_data->symbol) . '<br />';
// Unbilled expenses + money
$html .= '<b>' . _l('opportunity_overview_expenses_unbilled') . ': </b>' . format_money(sum_from_table('tblexpenses',array('where'=>array('opportunity_id'=>$opportunity->id,'invoiceid IS NULL','billable'=>1),'field'=>'amount')),$opportunity->currency_data->symbol) . '<br />';
// Write finance overview
$pdf->MultiCell(($dimensions['wk'] / $divide_document_overview) - $dimensions['lm'], 0, $html, 0, 'L', 0, 0, '', '', true, 0, true);

// Custom fields
// Check for custom fields
if(count($custom_fields) > 0) {
$html = '';
$html .= '<b style="background-color:#f0f0f0;">'.ucwords(_l('opportunity_custom_fields')) . '</b><br /><br />';

foreach($custom_fields as $field){
    $value = get_custom_field_value($opportunity->id,$field['id'],'opportunities');
    $value = $value === '' ? '/' : $value;
    $html .= '<b>' . ucfirst($field['name']) . ': </b>' . $value . '<br />';
}

// Write custom fields
$pdf->MultiCell(($dimensions['wk'] / $divide_document_overview) - $dimensions['lm'], 0, $html, 0, 'L', 0, 0, '', '', true, 0, true);
}

$html = '';
// Customer Info
$html .= '<b style="background-color:#f0f0f0;">'.ucwords(_l('opportunity_customer')) . '</b><br /><br /><b>'.$opportunity->client_data->company . '</b><br />';
$html .= $opportunity->client_data->address . '<br />';

if(!empty($opportunity->client_data->city)){
    $html .= $opportunity->client_data->city;
}
if(!empty($opportunity->client_data->state)){
    $html .=', '.$opportunity->client_data->state;
}
$country = get_country_short_name($opportunity->client_data->country);
if(!empty($country)){
    $html .= '<br />'.$country;
}
if(!empty($opportunity->client_data->zip)){
    $html .= ', ' .$opportunity->client_data->zip;
}
if(!empty($opportunity->client_data->phonenumber)){
    $html .= '<br />' .$opportunity->client_data->phonenumber;
}
if (!empty($opportunity->client_data->vat)) {
    $html .= '<br />'._l('client_vat_number') . ': ' . $opportunity->client_data->vat;
}

// Write custom info
$pdf->MultiCell(($dimensions['wk'] / $divide_document_overview) - $dimensions['lm'], 0, $html, 0, 'L', 0, 0, '', '', true, 0, true);

// Set new lines to prevent overlaping the content
$pdf->Ln(80);
// $pdf->setY(140);
// opportunity members overview
$html = '';
// Heading
$html .= '<p><b style="background-color:#f0f0f0;">'.ucwords(_l('opportunity_members_overview')).'</b></p>';
$html .= '<table width="100%" bgcolor="#fff" cellspacing="0" cellpadding="5" border="1">';
$html .= '<thead>';
$html .= '<tr bgcolor="#323a45" style="color:#ffffff;">';
$html .= '<th width="12.5%"><b>'._l('opportunity_member').'</b></th>';
$html .= '<th width="12.5%"><b>'._l('staff_total_task_assigned').'</b></th>';
$html .= '<th width="12.5%"><b>'._l('staff_total_comments_on_tasks').'</b></th>';
$html .= '<th width="12.5%"><b>'._l('total_opportunity_discussions_created').'</b></th>';
$html .= '<th width="12.5%"><b>'._l('total_opportunity_discussions_comments').'</b></th>';
$html .= '<th width="12.5%"><b>'._l('total_opportunity_files').'</b></th>';
$html .= '<th width="12.5%"><b>'._l('time_h').'</b></th>';
$html .= '<th width="12.5%"><b>'._l('time_decimal').'</b></th>';
$html .= '</tr>';
$html .= '</thead>';
$html .= '<tbody>';
foreach($members as $member){
    $html .= '<tr style="color:#4a4a4a;">';
        $html .= '<td>'.get_staff_full_name($member['staff_id']).'</td>';
        $html .= '<td>'.total_rows('tblstafftasks','rel_type="opportunity" AND rel_id="'.$opportunity->id.'" AND id IN (SELECT taskid FROM tblstafftaskassignees WHERE staffid="'.$member['staff_id'].'")').'</td>';
        $html .= '<td>'.total_rows('tblstafftaskcomments','staffid = '.$member['staff_id']. ' AND taskid IN (SELECT id FROM tblstafftasks WHERE rel_type="opportunity" AND rel_id="'.$opportunity->id.'")').'</td>';
        $html .= '<td>'.total_rows('tblopportunitydiscussions',array('staff_id'=>$member['staff_id'],'opportunity_id'=>$opportunity->id)).'</td>';
        $html .= '<td>'.total_rows('tblopportunitydiscussioncomments','staff_id='.$member['staff_id'] . ' AND discussion_id IN (SELECT id FROM tblopportunitydiscussions WHERE opportunity_id='.$opportunity->id.')').'</td>';
        $html .= '<td>'.total_rows('tblopportunityfiles',array('staffid'=>$member['staff_id'],'opportunity_id'=>$opportunity->id)).'</td>';
        $member_tasks_assigned = $this->tasks_model->get_tasks_by_staff_id($member['staff_id'],array('rel_id'=>$opportunity->id,'rel_type'=>'opportunity'));
        $seconds = 0;
        foreach($member_tasks_assigned as $member_task){
            $seconds += $this->tasks_model->calc_task_total_time($member_task['id'],' AND staff_id='.$member['staff_id']);
        }
        $html .= '<td>'.seconds_to_time_format($seconds).'</td>';
        $html .= '<td>'.sec2qty($seconds).'</td>';
    $html .= '</tr>';
}
$html .= '</tbody>';
$html .= '</table>';
// Write opportunity members table data
$pdf->writeHTML($html, true, false, false, false, '');

// Tasks overview
$pdf->Ln(5);
$html = '';
$html .= '<p><b style="background-color:#f0f0f0;">'.ucwords(_l('detailed_overview')).'</b></p>';
$html .= '<table width="100%" bgcolor="#fff" cellspacing="0" cellpadding="5" border="1">';
$html .= '<thead>';
$html .= '<tr bgcolor="#323a45" style="color:#ffffff;">';
$html .= '<th width="26.12%"><b>'._l('tasks_dt_name').'</b></th>';
$html .= '<th width="12%"><b>'._l('total_task_members_assigned').'</b></th>';
$html .= '<th width="12%"><b>'._l('total_task_members_followers').'</b></th>';
$html .= '<th width="9.28%"><b>'._l('task_single_start_date').'</b></th>';
$html .= '<th width="9.28%"><b>'._l('task_single_due_date').'</b></th>';
$html .= '<th width="7%"><b>'._l('task_status').'</b></th>';
$html .= '<th width="14.28%"><b>'._l('time_h').'</b></th>';
$html .= '<th width="10%"><b>'._l('time_decimal').'</b></th>';
$html .= '</tr>';
$html .= '</thead>';
$html .= '<tbody>';
foreach($tasks as $task){
    $html .= '<tr style="color:#4a4a4a;">';
        $html .= '<td width="26.12%">'.$task['name'].'</td>';
        $html .= '<td width="12%">'.total_rows('tblstafftaskassignees',array('taskid'=>$task['id'])).'</td>';
        $html .= '<td width="12%">'.total_rows('tblstafftasksfollowers',array('taskid'=>$task['id'])).'</td>';
        $html .= '<td width="9.28%">'._d($task['startdate']).'</td>';
        $html .= '<td width="9.28%">'.(is_date($task['duedate']) ? _d($task['duedate']): '').'</td>';
        $html .= '<td width="7%">'.format_task_status($task['status'],true,true).'</td>';
        $html .= '<td width="14.28%">'.seconds_to_time_format($task['total_logged_time']).'</td>';
        $html .= '<td width="10%">'.sec2qty($task['total_logged_time']).'</td>';

    $html .= '</tr>';
}
$html .= '</tbody>';
$html .= '</table>';
// Write tasks data
$pdf->writeHTML($html, true, false, false, false, '');

// Timesheets overview
$pdf->Ln(5);
$html = '';
$html .= '<p><b style="background-color:#f0f0f0;">'.ucwords(_l('timesheets_overview')).'</b></p>';
$html .= '<table width="100%" bgcolor="#fff" cellspacing="0" cellpadding="5" border="1">';
$html .= '<thead>';
$html .= '<tr bgcolor="#323a45" style="color:#ffffff;">';
$html .= '<th width="16.66%"><b>'._l('opportunity_timesheet_user').'</b></th>';
$html .= '<th width="16.66%"><b>'._l('opportunity_timesheet_task').'</b></th>';
$html .= '<th width="16.66%"><b>'._l('opportunity_timesheet_start_time').'</b></th>';
$html .= '<th width="16.66%"><b>'._l('opportunity_timesheet_end_time').'</b></th>';
$html .= '<th width="16.66%"><b>'._l('time_h').'</b></th>';
$html .= '<th width="16.66%"><b>'._l('time_decimal').'</b></th>';
$html .= '</tr>';
$html .= '</thead>';
$html .= '<tbody>';
foreach($timesheets as $timesheet){
    $html .= '<tr style="color:#4a4a4a;">';
        $html .= '<td>'.get_staff_full_name($timesheet['staff_id']).'</td>';
        $html .= '<td>' . $timesheet['task_data']->name . '</td>';
        $html .= '<td>'._dt($timesheet['start_time'],true).'</td>';
        $html .= '<td>'.(!is_null($timesheet['end_time']) ? _dt($timesheet['end_time'],true) : '').'</td>';
        $html .= '<td>'.seconds_to_time_format($timesheet['total_spent']).'</td>';
        $html .= '<td>'.sec2qty($timesheet['total_spent']).'</td>';

    $html .= '</tr>';
}
$html .= '</tbody>';
$html .= '</table>';
// Write timesheets data
$pdf->writeHTML($html, true, false, false, false, '');

// Milestones overview
$pdf->Ln(5);
$html = '';
$html .= '<p><b style="background-color:#f0f0f0;">'.ucwords(_l('opportunity_milestones_overview')).'</b></p>';
$html .= '<table width="100%" bgcolor="#fff" cellspacing="0" cellpadding="5" border="1">';
$html .= '<thead>';
$html .= '<tr bgcolor="#323a45" style="color:#ffffff;">';
$html .= '<th width="20%"><b>'._l('milestone_name').'</b></th>';
$html .= '<th width="30%"><b>'._l('milestone_description').'</b></th>';
$html .= '<th width="15%"><b>'._l('milestone_due_date').'</b></th>';
$html .= '<th width="15%"><b>'._l('total_tasks_in_milestones').'</b></th>';
$html .= '<th width="20%"><b>'._l('milestone_total_logged_time').'</b></th>';
$html .= '</tr>';
$html .= '</thead>';
$html .= '<tbody>';
foreach($milestones as $milestone){
    $html .= '<tr style="color:#4a4a4a;">';
        $html .= '<td width="20%">'.$milestone['name'].'</td>';
        $html .= '<td width="30%">'.$milestone['description'].'</td>';
        $html .= '<td width="15%">'._d($milestone['due_date']).'</td>';
        $html .= '<td width="15%">'.total_rows('tblstafftasks',array('milestone'=>$milestone['id'],'rel_id'=>$opportunity->id,'rel_type'=>'opportunity')).'</td>';
        $html .= '<td width="20%">'.seconds_to_time_format($milestone['total_logged_time']).'</td>';
    $html .= '</tr>';
}
$html .= '</tbody>';
$html .= '</table>';
// Write milestones table data
$pdf->writeHTML($html, true, false, false, false, '');

if (ob_get_length() > 0 && ENVIRONMENT == 'production') {
    ob_end_clean();
}

// Output PDF to user
$pdf->output('#'.$opportunity->id.'_' . $opportunity->name.'_'._d(date('Y-m-d')).'.pdf','I');
