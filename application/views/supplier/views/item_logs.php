<div class="panel_s">
    <div class="panel-body">
        <?php echo form_open_multipart('suppliers/add_item', array('autocomplete' => 'off')); ?>
        <?php echo form_hidden('item_id', $id); ?>
        <?php echo render_date_input('p_date', 'purchase_order_date'); ?>
        <?php echo render_input('finished', 'finished', '', 'number'); ?>
        <?php echo render_input('shipped', 'shipped', '', 'number'); ?>
        <div class="form-group">
            <button type="submit"
                    class="btn btn-info"><?php echo _l('item_logs_add'); ?></button>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<div class="panel_s">
    <div class="panel-body">
        <table class="table dt-table" data-order-col="2" data-order-type="desc">
            <thead>
            <th><?php echo _l('purchase_order_date'); ?></th>
            <th><?php echo _l('finished'); ?></th>
            <th><?php echo _l('shipped'); ?></th>
            </thead>
            <tbody>
            <?php foreach ($logs as $log) { ?>
                <tr>
                    <td><?php echo date('Y-m-d', strtotime($log['p_date'])) ?></td>
                    <td><?php echo $log['finished']; ?></td>
                    <td><?php echo $log['shipped']; ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
