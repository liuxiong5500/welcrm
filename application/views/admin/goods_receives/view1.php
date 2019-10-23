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
                <th><?php echo _l('goods_receives_out'); ?></th>
                <th><?php echo _l('goods_receives_reference_no'); ?></th>
                <th><?php echo _l('goods_receives_ware_house'); ?></th>
                </thead>
                <tbody>
                <?php foreach ($order->items as $item) { ?>

                <?php foreach ($item['children'] as   $children) { ?>
                <?php foreach ($children['detail'] as $key => $detail) { ?>
                    <tr>
                        <td><?php echo $order->order_number; ?></td>
                        <td><?php echo $key + 1; ?></td>
                        <td><?php echo $children['marzoni']; ?></td>
                        <td><?php if ($key == 0) { echo $children['qty']; } else { echo '';} ?></td>
                        <td><?php if ($detail['type'] == 1) {echo $detail['qty'];} else { echo '';} ?></td>
                        <td><?php if ($detail['type'] == 2) {echo $detail['qty'];} else { echo '';}?></td>
                        <td><?php if ($key != 0) {echo $detail['reference_no'];} else { echo '';} ?></td>
                        <td><?php if ($key != 0) {echo get_house_name_by_id($detail['ware_house']);} else { echo '';} ?></td>
<!--                        <td>--><?php //echo $item['style']; ?><!--</td>-->
<!--                        <td>--><?php //echo $item['unit_price']; ?><!--</td>-->
<!--                        <td>-->
<!--                            --><?php //echo $item['qty'] * $item['unit_price']; ?>
<!--                            --><?php //if (isset($item['children'])) { ?>
<!--                            <div>&nbsp;</div>-->
<!--                            --><?php //foreach ($item['children'] as $v) {?>
<!--                            <div>--><?php //echo $v['marzoni']?><!--</div>-->
<!--                            --><?php //}?>
<!--                            --><?php //}?>
<!--                        </td>-->
<!--                        <td>-->
<!--                            --><?php //echo $item['qty']; ?>
<!--                            --><?php //if (isset($item['children'])) { ?>
<!--                            <div>&nbsp;</div>-->
<!--                            --><?php //foreach ($item['children'] as $v) {?>
<!--                            <div>--><?php //echo $v['qty']?><!--</div>-->
<!--                            --><?php //}?>
<!--                            --><?php //}?>
<!--                        </td>-->
<!--                        <td>--><?php //echo $item['not_shipped']; ?><!--</td>-->
<!--                        <td>-->
<!--                            --><?php //echo $item['ex_mill']; ?>
<!--                            --><?php //if (isset($item['children'])) { ?>
<!--                            <div>&nbsp;</div>-->
<!--                            --><?php //foreach ($item['children'] as $v) {?>
<!--                            <div>--><?php //echo $v['ex_mill']?><!--</div>-->
<!--                            --><?php //}?>
<!--                            --><?php //}?>
<!--                        </td>-->
<!--                        <td>-->
<!--                            --><?php //echo $item['eta_date']; ?>
<!--                            --><?php //if (isset($item['children'])) { ?>
<!--                            <div>&nbsp;</div>-->
<!--                            --><?php //foreach ($item['children'] as $v) {?>
<!--                            <div>--><?php //echo $v['eta_date']?><!--</div>-->
<!--                            --><?php //}?>
<!--                            --><?php //}?>
<!--                        </td>-->
                    </tr>
                    <?php } ?>
                    <?php } ?>
                <?php } ?>
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
