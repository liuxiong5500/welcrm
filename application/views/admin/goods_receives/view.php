<?php init_head(); ?>
<div id="wrapper">
    <div class="panel_s">
<!--        <div class="panel-body">-->
<!--            <table style="width: 100%" border="1">-->
<!--                <tbody>-->
<!--                <tr>-->
<!--                    <td>--><?php //echo _l('goods_receives_po_no'); ?><!--:</td>-->
<!--                    <td>--><?php //echo $order->order_number; ?><!--</td>-->
<!--                </tr>-->
<!--                <tr>-->
<!--                    <td>--><?php //echo _l('goods_receives_batch_seq'); ?><!--:</td>-->
<!--                    <td>--><?php //echo date('Y-m-d', strtotime($order->po_date)); ?><!--</td>-->
<!--                </tr>-->
<!--                <tr>-->
<!--                    <td>--><?php //echo _l('goods_receives_batch_no'); ?><!--:</td>-->
<!--                    <td>--><?php //echo get_supplier_name_by_id($order->supplier); ?><!--</td>-->
<!--                </tr>-->
<!--                <tr>-->
<!--                    <td>--><?php //echo _l('purchase_order_qty'); ?><!--:</td>-->
<!--                    <td>--><?php //echo $order->currency_name; ?><!--</td>-->
<!--                </tr>-->
<!--                <tr>-->
<!--                    <td>--><?php //echo _l('goods_receives_in'); ?><!--:</td>-->
<!--                    <td>--><?php //echo get_payment_term_name_by_id($order->payment_term); ?><!--</td>-->
<!--                </tr>-->
<!--                <tr>-->
<!--                    <td>--><?php //echo _l('goods_receives_out'); ?><!--:</td>-->
<!--                    <td>--><?php //echo get_shipment_term_name_by_id($order->shipment_term); ?><!--</td>-->
<!--                </tr>-->
<!--                <tr>-->
<!--                    <td>--><?php //echo _l('goods_receives_reference_no'); ?><!--:</td>-->
<!--                    <td>--><?php //echo $order->confirmed_at; ?><!--</td>-->
<!--                </tr>-->
<!--                <tr>-->
<!--                    <td>--><?php //echo _l('goods_receives_ware_house'); ?><!--:</td>-->
<!--                    <td>--><?php //echo $order->finished_at; ?><!--</td>-->
<!--                </tr>-->
<!--                </tbody>-->
<!--            </table>-->
<!--        </div>-->
    </div>
    <div class="panel_s">
        <div class="panel-body">
            <table class="table dt-table" data-order-col="2" data-order-type="desc">
                <thead>
                <th><?php echo _l('goods_receives_po_no'); ?></th>
                <th><?php echo _l('goods_receives_batch_seq'); ?></th>
                <th><?php echo _l('goods_receives_batch_no'); ?></th>
                <th><?php echo _l('purchase_order_qty'); ?></th>
                <th><?php echo _l('goods_receives_in'); ?></th>
<!--                <th>--><?php //echo _l('goods_receives_out'); ?><!--</th>-->
                <th><?php echo _l('goods_receives_reference_no'); ?></th>
                <th><?php echo _l('goods_receives_ware_house'); ?></th>
                </thead>
                <tbody>
                <?php foreach ($order as $item) { ?>
                    <?php foreach ($item as $k => $v) {?>
                    <tr>
                        <td><a href='/admin/goods_receives/view1/<?php echo $v['rel_id']?>'><?php echo get_po_no_by_item_id($v['item_id']) ?></a></td>
                        <td><?php echo 1; ?></td>
                        <td><?php echo $v['tx_marzoni']; ?></td>
                        <td><?php echo $v['tx_qty']; ?></td>
                        <td><?php if ($v['type'] == 1) {echo $v['qty'];} ?></td>
<!--                        <td>--><?php //if ($v['type'] == 2) {echo $v['qty'];} ?><!--</td>-->
                        <td><?php echo $v['reference_no']; ?></td>
                        <td><?php echo $v['house_name']; ?></td>
                    </tr>
                    <?php } ?>
                <?php }?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<?php init_tail(); ?>
<script>
    $(function () {

    });
</script>
</body>
</html>
