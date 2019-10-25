<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <?php echo form_open($this->uri->uri_string(), array('id' => 'goods-receive-form', 'class' => '_transaction_form goods-receive-form')); ?>            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6 border-right">
                                <?php $value = (isset($estimate) ? $estimate->order_number : ''); $gr_number = isset($goods_detail[0]['reference_no']) ? $goods_detail[0]['reference_no'] : 'GR'.date('Ymd').mt_rand(1000, 9999)?>
<!--                                --><?php //echo render_input('peference_no', 'goods_gr_number', $gr_number, 'text'); ?>
                                <div class="form-group" app-field-wrapper="peference_no">
                                    <label for="peference_no" class="control-label"><?php echo _l('goods_gr_number'); ?></label>
                                    <input type="text" id="peference_no" name="peference_no" class="form-control" value="<?php echo $gr_number?>" readonly="readonly">
                                </div>
                                <?php

                                $selected = '';
                                $s_attrs = array('data-show-subtext' => true);
                                foreach ($suppliers as $supplier) {
                                    if (isset($goods_detail)) {
                                        if ($supplier['id'] == $goods_detail[0]['supplier']) {
                                            $selected = $supplier['id'];
                                        }
                                    }
                                }
                                ?>
                                <?php
                                if (!isset($goods_detail[0]['supplier'])) {
                                    echo render_select('supplier', $suppliers, array('id', 'company'), 'purchase_order_supplier', $selected, do_action('purchase_order_supplier_disabled', $s_attrs));
                                } else {?>
                                <div class="form-group" app-field-wrapper="peference_no">
                                    <label for="peference_no" class="control-label"><?php echo _l('purchase_order_supplier'); ?></label>
                                    <input type="text" id="" name="" class="form-control" value="<?php echo get_supplier_name_by_id($goods_detail[0]['supplier'])?>" readonly="readonly">
                                    <input type="hidden" id="" name="supplier" class="form-control" value="<?php echo $goods_detail[0]['supplier']?>">
                                </div>
                                <?php }?>
                            </div>
                            <div class="col-md-6">
<!--                                <div class="form-group select-placeholder warehouses-wrapper">-->
<!--                                    <label for="warehouse">--><?php //echo _l('purchase_order_warehouse'); ?><!--</label>-->
<!--                                    <div id="warehouse_ajax_search_wrapper">-->
<!--                                        <select name="ware_house" id="warehouse" class="warehouses ajax-search"-->
<!--                                                data-live-search="true" data-width="100%"-->
<!--                                                data-none-selected-text="--><?php //echo _l('dropdown_non_selected_tex'); ?><!--">-->
<!--                                            <option value="0"></option>-->
<!--                                            --><?php
//                                            if (!empty($warehouse)) {
//                                                foreach ($warehouse as $v) {
//                                                    echo '<option value="' . $v['id'] . '">' . get_warehouse_name_by_id($v['id']) . '</option>';
//                                                }
//                                            }
//                                            ?>
<!--                                        </select>-->
<!--                                    </div>-->
<!--                                </div>-->
                                <?php
                                if (!isset($goods_detail[0])) {
                                    $house_selected = '';
                                    $s_attrs = array('data-show-subtext' => true);
                                    foreach ($warehouse as $supplier) {
                                        if (isset($goods_detail)) {
                                            if ($supplier['id'] == $goods_detail[0]['ware_house']) {
                                                $house_selected = $supplier['id'];
                                            }
                                        }
                                    }

                                    echo render_select('ware_house', $warehouse, array('id', 'name'), 'purchase_order_warehouse', $house_selected, do_action('purchase_order_warehouse_disabled', $s_attrs));
                                    $value = (isset($goods_detail) ? _d(date('Y-m-d', strtotime($goods_detail[0]['gr_date']))) : _d(date('Y-m-d')));
                                    echo render_date_input('gr_date', 'goods_gr_date', $value);
                                }elseif ($goods_detail[0]['is_approve'] == 1) {
                                    $house_selected = '';
                                    $s_attrs = array('data-show-subtext' => true);
                                    foreach ($warehouse as $supplier) {
                                        if (isset($goods_detail)) {
                                            if ($supplier['id'] == $goods_detail[0]['ware_house']) {
                                                $house_selected = $supplier['id'];
                                            }
                                        }
                                    }

                                    echo render_select('ware_house', $warehouse, array('id', 'name'), 'purchase_order_warehouse', $house_selected, do_action('purchase_order_warehouse_disabled', $s_attrs));
                                    $value = (isset($goods_detail) ? _d(date('Y-m-d', strtotime($goods_detail[0]['gr_date']))) : _d(date('Y-m-d')));
                                    echo render_date_input('gr_date', 'goods_gr_date', $value);
                                } else {?>
                                    <div class="form-group" app-field-wrapper="peference_no">
                                        <label for="peference_no" class="control-label"><?php echo _l('purchase_order_warehouse'); ?></label>
                                        <input type="text" id="" name="" class="form-control" value="<?php echo get_house_name_by_id($goods_detail[0]['ware_house'])?>" readonly="readonly">
                                        <input type="hidden" id="" name="ware_house" class="form-control" value="<?php echo $goods_detail[0]['ware_house']?>">
                                    </div>
                                    <div class="form-group" app-field-wrapper="peference_no">
                                        <label for="peference_no" class="control-label"><?php echo _l('goods_gr_date'); ?></label>
                                        <input type="text" id="" name="" class="form-control" value="<?php echo $goods_detail[0]['gr_date']?>" readonly="readonly">
                                    </div>
                                <?php }?>
                            </div>
                        </div>
                        <div class="btn-bottom-toolbar bottom-transaction text-right">
                            <p class="no-mbot pull-left mtop5 btn-toolbar-notice"><?php echo _l('include_purchase_order_items_merge_field_help', '<b>{purchase_order_items}</b>'); ?></p>
                            <button type="button"
                                    class="btn btn-info mleft10 proposal-form-submit save-and-send transaction-submit">
                                <?php echo _l('save_and_send'); ?>
                            </button>
                            <button class="btn btn-info mleft5 proposal-form-submit transaction-submit" type="button">
                                <?php echo _l('submit'); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
<!--            style="display:none;"-->
            <div class="col-md-12 table_goods">
                <div class="panel_s">
                <?php if (isset($goods_detail)) {?>
                    <div class="panel-body mtop10">
                        <div class="table-responsive s_table">
                            <table class="table estimate-items-table items table-main-estimate-edit no-mtop" id="tab">
                                <thead>
                                <tr>
                                    <th class="sorting_disabled not-export" rowspan="1" colspan="1" aria-label=" - ">
                                        <span class="hide"> - </span>
                                        <div class="checkbox mass_select_all_wrap">
                                            <input type="checkbox" id="selectAll" data-to-table="tasks"><label></label>
                                        </div>
                                    </th>
<!--                                    <th>-->
<!--                                        <div class="checkbox">-->
<!--                                            <input type="checkbox" id="selectAll"/>全选-->
<!--                                        </div>-->
<!--                                    </th>-->
                                    <th width="32%" align="center">
                                        <i class="fa fa-exclamation-circle" aria-hidden="true"
                                           data-toggle="tooltip"
                                           data-title="<?php echo _l('goods_receives_po_no'); ?>">
                                        </i> <?php echo _l('goods_receives_po_no'); ?>
                                    </th>
                                    <th width="32%" align="center"><?php echo _l('goods_receives_batch_no'); ?></th>
                                    <th width="32%" align="center"><?php echo _l('goods_receives_in_qty'); ?></th>
                                    <th width="4%" align="center"><i class="fa fa-cog"></i></th>
                                </tr>
                                </thead>
                                <tbody class="table_goods_detail">
                                <?php foreach ($goods_detail as $k => $v) { ?>
                                        <tr class="main del<?php echo $v['id'] ?>">
                                            <td>
                                                <div class="checkbox">
                                                    <input name="add_new[<?php echo $k ?>][in_tx_id]" value="<?php echo $v['in_tx_id'] ?>" type="checkbox"/><label></label>
                                                </div>
                                            </td>
                                            <input type="hidden" name="add_new[<?php echo $k ?>][item_id]" class="form-control item_id<?php echo $v['id'] ?>" value="<?php echo $v['item_id'] ?>">
                                            <input type="hidden" class="form-control hidden_qty<?php echo $v['id'] ?>" value="<?php echo $v['surplus_qty'] ?>">
                                            <td>
                                                <input type="text" name="add_new[<?php echo $k ?>][po_no]" class="form-control po_no<?php echo $v['id'] ?>" disabled="disabled" value="<?php echo get_po_no_by_id($v['rel_id'])?>">
                                            </td>
                                            <td>
                                                <input type="text" name="add_new[<?php echo $k ?>][marzoni]" class="form-control marzoni<?php echo $v['id'] ?>" disabled="disabled" value="<?php echo $v['tx_marzoni']?>">
                                            </td>
                                            <td>
                                                <input type="text" name="add_new[<?php echo $k ?>][qty]" class="form-control qty<?php echo $v['id'] ?>" value="<?php echo $v['qty'] ?>" onchange="check_qty(this,<?php echo $v['id'] ?>)">
                                            </td>
                                        </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php } else {
                    $this->load->view('admin/goods_receives/items_in_tx', ['type' => 'purchase-order']);
                }?>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
        <div class="btn-bottom-pusher"></div>
    </div>
</div>
<?php init_tail(); ?>
<script>
    $(function () {
        validate_goods_receive_form();
        init_ajax_warehouse_search_by_customer_id();
        $('#supplier').change(function(){
            add_item_in_tx_to_preview($(this).val());
            $('.table_goods').show();
        })

    });
</script>
</body>
</html>
