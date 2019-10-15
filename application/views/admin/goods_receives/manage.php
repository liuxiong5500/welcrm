<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s mbot10">
                    <div class="panel-body">
                        <div class="_buttons">
                            <a href="<?php echo admin_url('goods_receives/goods'); ?>"
                               class="btn btn-info mright5 test pull-left display-block">
                                <?php echo _l('new_goods_receive'); ?></a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" id="small-table">
                        <div class="panel_s">
                            <div class="panel-body">
                                <?php
                                $table_data = array();
                                $_table_data = array(
                                    _l('goods_receives_po_no'),
//                                    _l('goods_receives_batch_no'),
//                                    _l('goods_receives_in_qty'),
//                                    _l('warehouse'),
//                                    _l('purchase_order_proposal_estimate_number'),
//                                    _l('purchase_order_date'),
//                                    _l('currency'),
//                                    _l('purchase_order_currency_rate'),
//                                    _l('purchase_order_status'),
//                                    _l('total'),
//                                    _l('created_at'),
                                );

                                foreach ($_table_data as $_t) {
                                    array_push($table_data, $_t);
                                }

                                render_datatable($table_data, 'goods-receives');
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script>
    $(function () {
        initDataTable('.table-goods-receives', admin_url + 'goods_receives/table', [0], [0]);
    });
</script>
</body>
</html>
