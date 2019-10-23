<div class="panel-body mtop10">
    <div class="table-responsive s_table">
        <table class="table estimate-items-table items table-main-estimate-edit no-mtop" id="tab">
            <thead>
            <tr>
                <th><input type="checkbox" id="selectAll" class="form-control"/>全选</th>
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
                <tr class="main del'+value.id+'">
                    <td><input name="add_new['+index+'][in_tx_id]" value="'+value.id+'" type="checkbox" class="form-control"/></td>
                    <input type="hidden" name="add_new['+index+'][item_id]" class="form-control item_id'+value.id+'" value="'+value.item_id+'">
                    <input type="hidden" class="form-control hidden_qty'+value.id+'" value="'+value.qty+'">
                    <td><input type="text" name="add_new['+index+'][po_no]" class="form-control po_no'+value.id+'" disabled="disabled" value="'+value.po_no+'"></td>
                    <td><input type="text" name="add_new['+index+'][marzoni]" class="form-control marzoni'+value.id+'" disabled="disabled" value="'+value.marzoni+'"></td>
                    <td><input type="text" name="add_new['+index+'][qty]" class="form-control qty'+value.id+'" value="'+value.qty+'" onchange="check_qty(this,'+value.id+')"></td>
                    <td><a href="#" class="btn btn-danger pull-left" onclick="delete_goods(this,'+value.id+'); return false;"><i class="fa fa-times"></i></a></td>
                </tr>
            </tbody>

        </table>
    </div>
</div>
