<div class="panel-body mtop10">
    <div class="table-responsive s_table">
        <table class="table estimate-items-table items table-main-estimate-edit no-mtop">
            <thead>
            <tr>
                <th></th>
                <th width="33%" align="center">
                    <i class="fa fa-exclamation-circle" aria-hidden="true"
                       data-toggle="tooltip"
                       data-title="<?php echo _l('goods_receives_po_no'); ?>">
                    </i> <?php echo _l('goods_receives_po_no'); ?>
                </th>
                <th width="33%" align="center"><?php echo _l('goods_receives_batch_no'); ?></th>
                <th width="33%" align="center"><?php echo _l('goods_receives_in_qty'); ?></th>
            </tr>
            </thead>
            <tbody>
            <tr class="main">
                <td></td>
                <td>
                    <input type="number" name="marzoni" min="0" class="form-control"
                           placeholder="<?php echo _l('goods_receives_po_no'); ?>">
                </td>
                <td>
                    <input type="text" placeholder="<?php echo _l('goods_receives_batch_no'); ?>" name="art"
                           class="form-control">
                </td>
                <td>
                    <input type="text" placeholder="<?php echo _l('goods_receives_in_qty'); ?>" name="dis"
                           class="form-control">
                </td>

            </tr>
            </tbody>
        </table>
    </div>
    <div id="removed-items"></div>
</div>
