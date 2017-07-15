<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-featured" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
            <h1><?php echo $heading_title; ?></h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="container-fluid">
        <?php if ($error_warning) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-featured" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
                            <?php if ($error_name) { ?>
                            <div class="text-danger"><?php echo $error_name; ?></div>
                            <?php } ?>
                        </div>
                    </div>          
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-product"><span data-toggle="tooltip" title="<?php echo $help_product; ?>"><?php echo $entry_product; ?></span></label>
                        <div class="col-sm-10">
                            <input type="text" name="category_name" value="" placeholder="<?php echo $entry_product; ?>" id="input-product" class="form-control" />
                            <div id="featured-product" class="well well-sm" style="height: 150px; overflow: auto;">
                                <?php if(isset($categories)) { foreach ($categories as $product) { ?>
                                <div id="featured-product<?php echo $product['category_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $product['name']; ?>
                                    <input type="hidden" name="category[]" value="<?php echo $product['category_id']; ?>" />
                                </div>
                                <?php }} ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-limit"><?php echo $entry_limit; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="limit" value="<?php echo $limit; ?>" placeholder="<?php echo $entry_limit; ?>" id="input-limit" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                        <div class="col-sm-10">
                            <select name="status" id="input-status" class="form-control">
                                <?php if ($status) { ?>
                                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                <option value="0"><?php echo $text_disabled; ?></option>
                                <?php } else { ?>
                                <option value="1"><?php echo $text_enabled; ?></option>
                                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript"><!--
  $('input[name=\'category_name\']').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: 'index.php?route=module/blog_category/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request),
                    dataType: 'json',
                    success: function (json) {
                        response($.map(json, function (item) {
                            return {
                                label: item['category_title'],
                                value: item['category_id']
                            }
                        }));
                    }
                });
            },
            select: function (item) {


                if ($.isNumeric(item['value'])) {
                    $('input[name=\'category_name\']').val('');

                    $('#featured-product' + item['value']).remove();

                    $('#featured-product').append('<div id="featured-product' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="category[]" value="' + item['value'] + '" /></div>');
                } else {

                    var valnew = item['value'].split(',');

                    for (i = 0; i < valnew.length; i++) {
                        $.ajax({
                            url: 'index.php?route=module/blog_category/getCategoryName&token=<?php echo $token; ?>&category_id=' + valnew[i],
                            dataType: 'json',
                            success: function (json) {

                                $('input[name=\'category_name\']').val('');

                                $('#featured-product' + json.category_id).remove();
                                $('#featured-product').append('<div id="featured-product' + json.category_name + '"><i class="fa fa-minus-circle"></i> ' + json.category_name + '<input type="hidden" name="category[]" value="' + json.category_id + '" /></div>');

                            }
                        });

                    }

                }
            }
        });

        $('#featured-product').delegate('.fa-minus-circle', 'click', function () {
            $(this).parent().remove();
        });
        //--></script></div>
<?php echo $footer; ?>
