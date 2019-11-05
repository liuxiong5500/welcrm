<div class="panel-body mtop10">
    <div class="row">
        <div class="col-md-4">
            <?php $this->load->view('admin/invoice_items/item_select'); ?>
        </div>
        <div class="col-md-8 text-right show_quantity_as_wrapper">
            <div class="mtop10">
                <span><?php echo _l('show_quantity_as'); ?></span>
                <div class="radio radio-primary radio-inline">
                    <input type="radio" value="1" id="1" name="show_quantity_as"
                           data-text="<?php echo _l('estimate_table_quantity_heading'); ?>" <?php if (isset($estimate) && $estimate->show_quantity_as == 1) {
                        echo 'checked';
                    } else {
                        echo 'checked';
                    } ?>>
                    <label for="1"><?php echo _l('quantity_as_qty'); ?></label>
                </div>
                <div class="radio radio-primary radio-inline">
                    <input type="radio" value="2" id="2" name="show_quantity_as"
                           data-text="<?php echo _l('estimate_table_hours_heading'); ?>" <?php if (isset($estimate) && $estimate->show_quantity_as == 2) {
                        echo 'checked';
                    } ?>>
                    <label for="2"><?php echo _l('quantity_as_hours'); ?></label>
                </div>
                <div class="radio radio-primary radio-inline">
                    <input type="radio" id="3" value="3" name="show_quantity_as"
                           data-text="<?php echo _l('estimate_table_quantity_heading'); ?>/<?php echo _l('estimate_table_hours_heading'); ?>" <?php if (isset($estimate) && $estimate->show_quantity_as == 3) {
                        echo 'checked';
                    } ?>>
                    <label for="3"><?php echo _l('estimate_table_quantity_heading'); ?>
                        /<?php echo _l('estimate_table_hours_heading'); ?></label>
                </div>
            </div>
        </div>
    </div>
    <div class="table-responsive s_table">
        <table class="table estimate-items-table items table-main-estimate-edit no-mtop">
            <thead>
            <tr>
                <th></th>
                <th width="6%" align="center" style="min-width : 40px">
                    <i class="fa fa-exclamation-circle" aria-hidden="true"
                       data-toggle="tooltip"
                       data-title="<?php echo _l('item_description_new_lines_notice'); ?>">
                    </i> <?php echo _l('purchase_order_marzoni'); ?>
                </th>
                <th width="6%" align="center" style="min-width : 40px"><?php echo _l('purchase_order_art'); ?></th>
                <th width="5%" align="center" style="min-width : 40px"><?php echo _l('purchase_order_dis'); ?></th>
                <th width="5%" align="center" style="min-width : 40px"><?php echo _l('purchase_order_col'); ?></th>
                <th width="8%" align="center" style="min-width : 40px"><?php echo _l('purchase_order_composition'); ?></th>
                <th width="6%" align="center" style="min-width : 40px"><?php echo _l('purchase_order_weight'); ?></th>
                <th width="6%" align="center" style="min-width : 40px"><?php echo _l('purchase_order_width'); ?></th>
                <th width="7%" align="center" style="min-width : 40px"><?php echo _l('purchase_order_color'); ?></th>
                <th width="7%" align="center" style="min-width : 40px"><?php echo _l('purchase_order_style'); ?></th>
                <th width="7%" align="center" style="min-width : 40px"><?php echo _l('purchase_order_unit_price'); ?></th>
                <?php
                $custom_fields = get_custom_fields('items');
                foreach ($custom_fields as $cf) {
                    echo '<th width="15%" align="center" class="custom_field" style="min-width : 40px">' . $cf['name'] . '</th>';
                }

                $qty_heading = _l('estimate_table_quantity_heading');
                if (isset($estimate) && $estimate->show_quantity_as == 2) {
                    $qty_heading = _l('estimate_table_hours_heading');
                } else if (isset($estimate) && $estimate->show_quantity_as == 3) {
                    $qty_heading = _l('estimate_table_quantity_heading') . '/' . _l('estimate_table_hours_heading');
                }
                ?>
                <th width="7%" align="center" style="min-width : 40px"><?php echo _l('purchase_order_amount'); ?></th>
                <th width="7%" class="qty" align="center" style="min-width : 40px"><?php echo $qty_heading; ?></th>
                <th width="7%" align="center" style="min-width : 40px"><?php echo _l('purchase_order_not_shipped'); ?></th>
<!--                <th width="6%" align="center">--><?php //echo _l('estimate_table_tax_heading'); ?><!--</th>-->
                <th width="8%" align="center" style="min-width : 40px"><?php echo _l('purchase_order_ex_mill'); ?></th>
                <th width="8%" align="center" style="min-width : 40px"><?php echo _l('purchase_order_eta_date'); ?></th>
                <th align="center"><i class="fa fa-cog"></i></th>
            </tr>
            </thead>
            <tbody>
            <tr class="main">
                <td></td>
                <td>
                    <input type="text" name="marzoni" class="form-control"
                           placeholder="<?php echo _l('purchase_order_marzoni'); ?>">
                </td>
                <td>
                    <input type="text" placeholder="<?php echo _l('purchase_order_art'); ?>" name="art"
                           class="form-control">
                </td>
                <td>
                    <input type="text" placeholder="<?php echo _l('purchase_order_dis'); ?>" name="dis"
                           class="form-control">
                </td>
                <td>
                    <input type="text" placeholder="<?php echo _l('purchase_order_col'); ?>" name="col"
                           class="form-control">
                </td>
                <td>
                    <input type="text" placeholder="<?php echo _l('purchase_order_composition'); ?>" name="description"
                           class="form-control">
                </td>
                <td>
                    <input type="number" name="weight" min="0" class="form-control"
                           placeholder="<?php echo _l('purchase_order_weight'); ?>">
                </td>
                <td>
                    <input type="number" name="width" min="0" class="form-control"
                           placeholder="<?php echo _l('purchase_order_width'); ?>">
                </td>
                <td>
                    <input type="text" placeholder="<?php echo _l('purchase_order_color'); ?>" name="color"
                           class="form-control">
                </td>
                <td>
                    <input type="text" placeholder="<?php echo _l('purchase_order_style'); ?>" name="style"
                           class="form-control">
                </td>
                <td>
                    <input type="number" name="unit_price" class="form-control"
                           placeholder="<?php echo _l('purchase_order_unit_price'); ?>">
                </td>
                <?php echo render_custom_fields_items_table_add_edit_preview(); ?>
                <td>
                    <input type="number" name="amount" class="form-control" disabled="disabled"
                           placeholder="<?php echo _l('purchase_order_amount'); ?>">
                </td>
                <td>
                    <input type="number" name="qty" class="form-control"
                           placeholder="<?php echo _l('purchase_order_qty'); ?>">
                </td>
                <td style="display:none;">
                    <?php
                    $default_tax = unserialize(get_option('default_tax'));
                    $select = '<select class="selectpicker display-block tax main-tax" data-width="100%" name="taxname" multiple data-none-selected-text="' . _l('no_tax') . '">';
                    foreach ($taxes as $tax) {
                        $selected = '';
                        if (is_array($default_tax)) {
                            if (in_array($tax['name'] . '|' . $tax['taxrate'], $default_tax)) {
                                $selected = ' selected ';
                            }
                        }
                        $select .= '<option value="' . $tax['name'] . '|' . $tax['taxrate'] . '"' . $selected . 'data-taxrate="' . $tax['taxrate'] . '" data-taxname="' . $tax['name'] . '" data-subtext="' . $tax['name'] . '">' . $tax['taxrate'] . '%</option>';
                    }
                    $select .= '</select>';
                    echo $select;
                    ?>
                </td>
                <td>
                    <input type="number" name="not_shipped" class="form-control" disabled="disabled"
                           placeholder="<?php echo _l('purchase_order_not_shipped'); ?>">
                </td>

                <td>
                    <input type="text" id="po_date" placeholder="<?php echo _l('purchase_order_ex_mill'); ?>" name="ex_mill"
                           class="form-control" readonly="readonly">
                </td>
                <td>
                    <input type="text" placeholder="<?php echo _l('purchase_order_eta_date'); ?>" name="eta_date"
                           class="form-control" readonly="readonly">
                </td>
                <td>
                    <?php
                    $new_item = 'undefined';
                    if (isset($estimate)) {
                        $new_item = true;
                    }
                    ?>
                    <button type="button"
                            onclick="add_item_to_table2('undefined','undefined',<?php echo $new_item; ?>); return false;"
                            class="btn pull-right btn-info"><i class="fa fa-check"></i></button>
                </td>
            </tr>
            <?php if (isset($estimate) || isset($add_items)) {
                $i = 1;
                $items_indicator = 'newitems';
                if (isset($estimate)) {
                    $add_items = $estimate->items;
                    $items_indicator = 'items';
                } 
                foreach ($add_items as $item) {
                    $readonly = '';
                    $manual = false;
                    $table_row = '<tr class="sortable item">';
                    $table_row .= '<td class="dragger">';
                    if ($item['qty'] == '' || $item['qty'] == 0) {
                        $item['qty'] = 1;
                    }
                    if (!isset($is_proposal)) {
                        $estimate_item_taxes = get_estimate_item_taxes($item['id']);
                    } else {
                        $estimate_item_taxes = get_proposal_item_taxes($item['id']);
                    }
                    if ($item['id'] == 0) {
                        $estimate_item_taxes = $item['taxname'];
                        $manual = true;
                    }
//                    print_r($items_indicator);die;
                    $table_row .= form_hidden('' . $items_indicator . '[' . $i . '][itemid]', $item['id']);
                    $amount = $item['unit_price'] * $item['qty'];
                    $amount = _format_number($amount);
                    $table_row .= form_hidden('isedit');
                    // order input
                    $table_row .= '<input type="hidden" class="order" name="' . $items_indicator . '[' . $i . '][order]">';
                    $table_row .= '<input type="hidden" class="not_shipped" value="' . $item['not_shipped']  . '">';
                    $table_row .= '</td>';

                    if (!empty($item['children'])) {
                        $readonly = 'readonly="readonly"';
                    }
                    $table_row .= '<td class="bold"><input type="text" '.$readonly.' name="' . $items_indicator . '[' . $i . '][marzoni]" value="' . $item['marzoni'] . '" data-toggle="tooltip" title="' . $item['marzoni'] . '" class="form-control marzoni">';

                    if (!empty($item['children'])) {
                        foreach ($item['children'] as $k => $v) {
                            $table_row .= '<input type="hidden" name="itemschildren['. $item['id'] .']['.$k.'][item_id]" value="'.$v['item_id'].'"  class="form-control children'.$v['item_id'].$k.'">';
                            $table_row .= '<input type="hidden" name="itemschildren['. $item['id'] .']['.$k.'][id]" value="'.$v['id'].'"  class="form-control children'.$v['item_id'].$k.'">';
                        }
                        
                    }
                    $table_row .= '</td>';

                    $table_row .= '<td><input type="text" name="' . $items_indicator . '[' . $i . '][art]" value="' . $item['art'] . '" data-toggle="tooltip" title="' . $item['art'] . '" class="form-control" readonly="readonly"></td>';

                    $table_row .= '<td><input type="text" name="' . $items_indicator . '[' . $i . '][dis]" min="0"  value="' . $item['dis'] . '" data-toggle="tooltip" title="' . $item['dis'] . '" class="form-control" readonly="readonly"></td>';

                    $table_row .= '<td><input type="text" name="' . $items_indicator . '[' . $i . '][col]" min="0"  value="' . $item['col'] . '" data-toggle="tooltip" title="' . $item['col'] . '" class="form-control" readonly="readonly"></td>';

                    $table_row .= '<td><input type="text" name="' . $items_indicator . '[' . $i . '][description]" class="form-control" data-toggle="tooltip" title="' . clear_textarea_breaks($item['description']) . '" readonly="readonly" value="' . clear_textarea_breaks($item['description']) . '"></td>';

                    $table_row .= '<td><input type="number" name="' . $items_indicator . '[' . $i . '][weight]" min="0"  value="' . $item['weight'] . '" data-toggle="tooltip" title="' . $item['weight'] . '" class="form-control" readonly="readonly"></td>';

                    $table_row .= '<td><input type="number" name="' . $items_indicator . '[' . $i . '][width]" min="0"  value="' . $item['width'] . '" data-toggle="tooltip" title="' . $item['width'] . '" class="form-control" readonly="readonly"></td>';

                    $table_row .= '<td><input type="text" name="' . $items_indicator . '[' . $i . '][color]" class="form-control" data-toggle="tooltip" title="' . clear_textarea_breaks($item['color']) . '" readonly="readonly" value="' . clear_textarea_breaks($item['color']) . '"></td>';

                    $table_row .= '<td><input type="text" name="' . $items_indicator . '[' . $i . '][style]" class="form-control" data-toggle="tooltip" title="' . clear_textarea_breaks($item['style']) . '" readonly="readonly" value="' . clear_textarea_breaks($item['style']) . '"></td>';

                    $table_row .= render_custom_fields_items_table_in($item, $items_indicator . '[' . $i . ']');

                    $table_row .= '<td><input type="number" min="0" onblur="calculate_total();" readonly="readonly" onchange="calculate_total();" data-quantity name="' . $items_indicator . '[' . $i . '][unit_price]" value="' . $item['unit_price'] . '" data-toggle="tooltip" title="' . $item['unit_price'] . '" class="form-control">';
                    
                    $table_row .= '<td class="amount" align="right"><input type="text" class="amount_total form-control" value=" '.$amount.' "  readonly="readonly" data-toggle="tooltip" title="' . $amount . '">';

                    if (!empty($item['children'])) {
                        foreach ($item['children'] as $k => $v) {
                            $table_row .= '<input style="margin:5px 0px 0px 0px;" type="text" name="itemschildren['. $item['id'] .']['.$k.'][marzine]" value="'.$v['marzoni'].'" data-toggle="tooltip" title="' . $v['marzoni'] . '" class="form-control children_marzine children'.$v['item_id'].$k.' children_mar_each'.$v['item_id'].'" style="">';
                        }
                        
                    }
                    $table_row .= '</td>';
                    
                    $table_row .= '<td class="rate"><input type="number" readonly="readonly" class="qty form-control" data-toggle="tooltip" title="' . $item['qty'] . '" onblur="calculate_total();" onchange="calculate_total();" name="' . $items_indicator . '[' . $i . '][qty]" value="' . $item['qty'] . '" >';

                    if (!empty($item['children'])) {
                        foreach ($item['children'] as $k => $v) {
                            $table_row .= '<input style="margin:5px 0px 0px 0px;" type="number" min="0" onchange="check_not_shipped(this,'.$v['item_id'].');" data-quantity name="itemschildren['. $item['id'] .']['.$k.'][qty]" value="'.$v['qty'].'" class="form-control children_qty'.$v['item_id'].' children'.$v['item_id'].$k.'">';
                        }
                        
                    }
                    $table_row .= '</td>';
                    
                    $table_row .= '<td class="taxrate" style="display:none;">' . $this->misc_model->get_taxes_dropdown_template('' . $items_indicator . '[' . $i . '][taxname][]', $estimate_item_taxes, (isset($is_proposal) ? 'proposal' : 'estimate'), $item['id'], true, $manual) . '</td>';
                    
                    $table_row .= '<td class="shipped" align="right"><input class="shipped form-control" name="' . $items_indicator . '[' . $i . '][not_shipped]" value="' . $item['not_shipped'] . '" data-toggle="tooltip" title="' . $item['not_shipped'] . '" readonly="readonly"></td>';
                    
                    $table_row .= '<td class="ex_mill"><input type="text" id="po_date" name="' . $items_indicator . '[' . $i . '][ex_mill]" data-toggle="tooltip" title="' . $item['ex_mill'] . '" value="' . $item['ex_mill'] . '" class="form-control ex_mill" readonly="readonly">';
                    
                    if (!empty($item['children'])) {
                        foreach ($item['children'] as $k => $v) {
                            $table_row .= '<input style="margin:5px 0px 0px 0px;" onchange="check_max_ex_mill(this,'.$v['item_id'].');" type="text" id="po_date" name="itemschildren['. $item['id'] .']['.$k.'][ex_mill]" class="form-control datepicker ex_mill_children children'. $v['item_id'].$k .' children_ex_mill'.$v['item_id'].'" value="'.$v['ex_mill'].'" data-toggle="tooltip" title="' . $v['ex_mill'] . '">';
                        }
                        
                    }
                    $table_row .= '</td>';

                    $table_row .= '<td class="eta_date"><input type="text" name="' . $items_indicator . '[' . $i . '][eta_date]" data-toggle="tooltip" title="' . $item['eta_date'] . '" value="' . $item['eta_date'] . '" class="form-control eta_date" readonly="readonly">';
                    
                    if (!empty($item['children'])) {
                        foreach ($item['children'] as $k => $v) {
                            $table_row .= '<input style="margin:5px 0px 0px 0px;" type="text" onchange="check_max_eta_date(this,'.$v['item_id'].');" name="itemschildren['. $item['id'] .']['.$k.'][eta_date]" class="form-control datepicker eta_date_children children'. $v['item_id'].$k .' children_eta_date'.$v['item_id'].'"  value="'.$v['eta_date'].'" data-toggle="tooltip" title="' . $v['eta_date'] . '">';
                        }
                        
                    }
                    $table_row .= '</td>';

                    $table_row .= '<td class="children_del"><a href="#" class="btn pull-right btn-info"  onclick="add_item(this,' . $item['id'] . '); return false;"><i class="fa fa-plus"></i></a>';

                    if (!empty($item['children'])) {
                        foreach ($item['children'] as $k => $v) {
                            $table_row .= '<a style="margin:8px 0px 0px 0px;" href="#" class="btn btn-danger pull-left" onclick="delete_children(this, '. $k .','.$v['item_id'].', '.$v['id'].'); return false;"><i class="fa fa-times"></i></a>';
                        }
                        
                    }
                    $table_row .= '</td>';

                    $table_row .= '<td><a href="#" class="btn btn-danger pull-left" onclick="delete_item(this,' . $item['id'] . '); return false;"><i class="fa fa-times"></i></a></td>';

                    $table_row .= '</tr>';

                    echo $table_row;
                    $i++;
                }
            }
            ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-8 col-md-offset-4">
        <table class="table text-right">
            <tbody>
            <tr id="subtotal">
                <td><span class="bold"><?php echo _l('estimate_subtotal'); ?> :</span>
                </td>
                <td class="subtotal">
                </td>
            </tr>
            <tr id="discount_area">
                <td>
                    <div class="row">
                        <div class="col-md-7">
                            <span class="bold"><?php echo _l('estimate_discount'); ?></span>
                        </div>
                        <div class="col-md-5">
                            <div class="input-group" id="discount-total">

                                <input type="number"
                                       value="<?php echo(isset($estimate) ? $estimate->discount_percent : 0); ?>"
                                       class="form-control pull-left input-discount-percent<?php if (isset($estimate) && !is_sale_discount($estimate, 'percent') && is_sale_discount_applied($estimate)) {
                                           echo ' hide';
                                       } ?>" min="0" max="100" name="discount_percent">

                                <input type="number" data-toggle="tooltip"
                                       data-title="<?php echo _l('numbers_not_formatted_while_editing'); ?>"
                                       value="<?php echo(isset($estimate) ? $estimate->discount_total : 0); ?>"
                                       class="form-control pull-left input-discount-fixed<?php if (!isset($estimate) || (isset($estimate) && !is_sale_discount($estimate, 'fixed'))) {
                                           echo ' hide';
                                       } ?>" min="0" name="discount_total">

                                <div class="input-group-addon">
                                    <div class="dropdown">
                                        <a class="dropdown-toggle" href="#" id="dropdown_menu_tax_total_type"
                                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                 <span class="discount-total-type-selected">
                                  <?php if (!isset($estimate) || isset($estimate) && (is_sale_discount($estimate, 'percent') || !is_sale_discount_applied($estimate))) {
                                      echo '%';
                                  } else {
                                      echo _l('discount_fixed_amount');
                                  }
                                  ?>
                                 </span>
                                            <span class="caret"></span>
                                        </a>
                                        <ul class="dropdown-menu" id="discount-total-type-dropdown"
                                            aria-labelledby="dropdown_menu_tax_total_type">
                                            <li>
                                                <a href="#"
                                                   class="discount-total-type discount-type-percent<?php if (!isset($estimate) || (isset($estimate) && is_sale_discount($estimate, 'percent')) || (isset($estimate) && !is_sale_discount_applied($estimate))) {
                                                       echo ' selected';
                                                   } ?>">%</a>
                                            </li>
                                            <li>
                                                <a href="#"
                                                   class="discount-total-type discount-type-fixed<?php if (isset($estimate) && is_sale_discount($estimate, 'fixed')) {
                                                       echo ' selected';
                                                   } ?>">
                                                    <?php echo _l('discount_fixed_amount'); ?>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="discount-total"></td>
            </tr>
            <tr>
                <td>
                    <div class="row">
                        <div class="col-md-7">
                            <span class="bold"><?php echo _l('estimate_adjustment'); ?></span>
                        </div>
                        <div class="col-md-5">
                            <input type="number" data-toggle="tooltip"
                                   data-title="<?php echo _l('numbers_not_formatted_while_editing'); ?>"
                                   value="<?php if (isset($estimate)) {
                                       echo $estimate->adjustment;
                                   } else {
                                       echo 0;
                                   } ?>" class="form-control pull-left" name="adjustment">
                        </div>
                    </div>
                </td>
                <td class="adjustment"></td>
            </tr>
            <?php if ($type == 'estimate') { ?>
                <tr>
                    <td>
                        <div class="row">
                            <div class="col-md-7">
                                <span class="bold"><?php echo _l('estimate_lcycost'); ?></span>
                            </div>
                            <div class="col-md-5">
                                <input type="number" data-toggle="tooltip"
                                       data-title="<?php echo _l('numbers_not_formatted_while_editing'); ?>"
                                       value="<?php if (isset($estimate)) {
                                           echo $estimate->lcycost;
                                       } else {
                                           echo 0;
                                       } ?>" class="form-control pull-left" name="lcycost">
                            </div>
                        </div>
                    </td>
                    <td><?php echo _l('estimate_profit'); ?>: <span class="lcyprofit"></span></td>
                </tr>
            <?php } ?>
            <tr>
                <td><span class="bold"><?php echo _l('estimate_total'); ?> :</span>
                </td>
                <td class="total">
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <div id="removed-items"></div>
</div>
