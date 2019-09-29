<?php init_head(); ?>
<div id="wrapper">
    <div class="panel_s">
        <div class="panel-body">
            <table style="width: 100%" border="1">
                <tbody>
                <tr>
                    <td><?php echo _l('order_number'); ?>:</td>
                    <td><?php echo $order->order_number; ?></td>
                    <td><?php echo _l('client'); ?>:</td>
                    <td><?php echo $order->client_company; ?></td>
                </tr>
                <tr>
                    <td><?php echo _l('purchase_order_proposal_estimate_number'); ?>:</td>
                    <td><?php echo $order->pe_number; ?></td>
                    <td><?php echo _l('warehouse'); ?>:</td>
                    <td><?php echo $order->warehouse_name; ?></td>
                </tr>
                <tr>
                    <td><?php echo _l('purchase_order_date'); ?>:</td>
                    <td><?php echo date('Y-m-d', strtotime($order->po_date)); ?></td>
                    <td><?php echo _l('purchase_order_status'); ?>:</td>
                    <td><?php echo get_purchase_order_status_by_id($order->status); ?></td>
                </tr>
                <tr>
                    <td><?php echo _l('purchase_order_currency'); ?>:</td>
                    <td><?php echo $order->currency_name; ?></td>
                    <td><?php echo _l('purchase_order_currency_rate'); ?>:</td>
                    <td><?php echo $order->currency_rate; ?></td>
                </tr>
                <tr>
                    <td><?php echo _l('purchase_order_payment_term'); ?>:</td>
                    <td><?php echo get_payment_term_name_by_id($order->payment_term); ?></td>
                    <td><?php echo _l('purchase_order_shipment_term'); ?>:</td>
                    <td><?php echo get_shipment_term_name_by_id($order->shipment_term); ?></td>
                </tr>
                <tr>
                    <td><?php echo _l('purchase_order_confirmed_at'); ?>:</td>
                    <td><?php echo $order->confirmed_at; ?></td>
                    <td><?php echo _l('purchase_order_production_at'); ?>:</td>
                    <td><?php echo $order->production_at; ?></td>
                </tr>
                <tr>
                    <td><?php echo _l('purchase_order_finished_at'); ?>:</td>
                    <td><?php echo $order->finished_at; ?></td>
                    <td><?php echo _l('purchase_order_departure_at'); ?>:</td>
                    <td><?php echo $order->departure_at; ?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="panel_s">
        <div class="panel-body">
            <table class="table dt-table" data-order-col="2" data-order-type="desc">
                <thead>
                <th><?php echo _l('purchase_order_marzoni'); ?></th>
                <th><?php echo _l('purchase_order_art'); ?></th>
                <th><?php echo _l('purchase_order_dis'); ?></th>
                <th><?php echo _l('purchase_order_col'); ?></th>
                <th><?php echo _l('purchase_order_composition'); ?></th>
                <th><?php echo _l('purchase_order_weight'); ?></th>
                <th><?php echo _l('purchase_order_width'); ?></th>
                <th><?php echo _l('purchase_order_color'); ?></th>
                <th><?php echo _l('purchase_order_style'); ?></th>
                <th><?php echo _l('purchase_order_unit_price'); ?></th>
                <th><?php echo _l('estimate_table_quantity_heading'); ?></th>
                <th><?php echo _l('purchase_order_amount'); ?></th>
                <th><?php echo _l('purchase_order_ex_mill'); ?></th>
                <th><?php echo _l('purchase_order_eta_date'); ?></th>
                </thead>
                <tbody>
                <?php foreach ($order->items as $key => $item) { ?>
                    <tr>
                        <td><?php echo $item['marzoni']; ?></td>
                        <td><?php echo $item['art']; ?></td>
                        <td><?php echo $item['dis']; ?></td>
                        <td><?php echo $item['col']; ?></td>
                        <td><?php echo $item['description']; ?></td>
                        <td><?php echo $item['weight']; ?></td>
                        <td><?php echo $item['width']; ?></td>
                        <td><?php echo $item['color']; ?></td>
                        <td><?php echo $item['style']; ?></td>
                        <td><?php echo $item['unit_price']; ?></td>
                        <td><?php echo $item['qty']; ?></td>
                        <td><?php echo $item['qty'] * $item['unit_price']; ?></td>
                        <td><?php echo $item['ex_mill']; ?></td>
                        <td><?php echo $item['eta_date']; ?></td>
                        <!--                    <td>--><?php //echo get_purchase_order_item_finished($item['id']); ?><!--</td>-->
                        <!--                    <td>--><?php //echo get_purchase_order_item_shipped($item['id']); ?><!--</td>-->
                        <!--                    <td>-->
                        <!--                        <a href="--><?php //echo admin_url('purchase_orders/item_logs/' . $item['id']); ?><!--">--><?php //echo _l('view'); ?><!--</a>-->
                        <!--                    </td>-->
                    </tr>

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
