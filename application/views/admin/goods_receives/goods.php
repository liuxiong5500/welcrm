<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <?php echo form_open($this->uri->uri_string(), array('id' => 'purchase-order-form', 'class' => '_transaction_form purchase-order-form')); ?>
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6 border-right">
                                <?php $value = (isset($estimate) ? $estimate->order_number : ''); $gr_number = 'GR'.date('Ymd').mt_rand(1000, 9999);?>
                                <?php echo render_input('gr_number', 'goods_gr_number', $gr_number, 'text'); ?>
                                <?php

                                $selected = '';
                                $s_attrs = array('data-show-subtext' => true);
                                foreach ($suppliers as $supplier) {
                                    if (isset($estimate)) {
                                        if ($supplier['id'] == $estimate->supplier) {
                                            $selected = $supplier['id'];
                                        }
                                    }
                                }
                                ?>
                                <?php
                                echo render_select('supplier', $suppliers, array('id', 'company'), 'purchase_order_supplier', $selected, do_action('purchase_order_supplier_disabled', $s_attrs));
                                ?>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group select-placeholder warehouses-wrapper">
                                    <label for="warehouse"><?php echo _l('purchase_order_warehouse'); ?></label>
                                    <div id="warehouse_ajax_search_wrapper">
                                        <select name="warehouse" id="warehouse" class="warehouses ajax-search"
                                                data-live-search="true" data-width="100%"
                                                data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                            <option value=""></option>
                                            <?php
                                            if (!empty($warehouse)) {
                                                foreach ($warehouse as $v) {
                                                    echo '<option value="' . $v['id'] . '">' . get_warehouse_name_by_id($v['id']) . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <?php $value = (isset($estimate) ? _d(date('Y-m-d', strtotime($estimate->po_date))) : _d(date('Y-m-d'))); ?>
                                <?php echo render_date_input('gr_date', 'goods_gr_date', $value); ?>
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

            <div class="col-md-12 table_goods" style="display:none;">
                <div class="panel_s">
                    <?php $this->load->view('admin/goods_receives/items_in_tx', ['type' => 'purchase-order']); ?>
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
        validate_purchase_order_form();
        init_currency_symbol();
        init_ajax_warehouse_search_by_customer_id();
        $('#supplier').change(function(){
            add_item_in_tx_to_preview($(this).val());
            $('.table_goods').show();

        })

    });
</script>
</body>
</html>
