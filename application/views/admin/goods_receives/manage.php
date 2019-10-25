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
                                    _l('goods_receives'),
                                    _l('goods_receives_date'),
                                    _l('goods_receives_supplier'),
                                    _l('goods_is_approved'),
                                    _l('goods_prepared_by'),
                                    _l('goods_approved_by'),
                                    _l('goods_approved_date'),
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
        initDataTable('.table-goods-receives', admin_url + 'goods_receives/table', [5], [5]);
    });
</script>
</body>
</html>
