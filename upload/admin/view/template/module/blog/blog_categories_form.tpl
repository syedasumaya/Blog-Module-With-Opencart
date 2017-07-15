<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-blog-settings" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary save-btn"><i class="fa fa-save"></i></button>
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
        <?php if ($success) { ?>
        <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>

        <div class="panel panel-default">
            <!------------------------------Settings Start----------------------------------->

            <div class="panel-heading">
                <h3><?php echo $heading_addCat;?></h3>
            </div>

            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-blog-settings" class="form-horizontal settings">

                <div class="panel-body"> 

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-height"><span style="color:red">*</span><?php echo $text_category_title; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="category_title" value="<?php echo $category_title; ?>" placeholder="<?php echo $text_category_title; ?>" id="input-height" class="form-control" />
                            <?php if ($error_title) { ?>
                            <div class="text-danger"><?php echo $error_title; ?></div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-height"><?php echo $text_category_description;?></label>
                        <div class="col-sm-10">
                            <textarea name="category_description" placeholder="" id="input-description" class="form-control summernote"><?php echo $category_description;?></textarea>                                 
                        </div>
                    </div>                    

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-height"><?php echo $text_sort_order;?></label>
                        <div class="col-sm-10">
                            <input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $text_sort_order;?>" id="input-height" class="form-control" />                          
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-height"><span style="color:red">*</span><?php echo $text_seo_keyword;?></label>
                        <div class="col-sm-10">
                            <input type="text" name="seo_keyword" value="<?php echo $seo_keyword; ?>" placeholder="<?php echo $text_seo_keyword;?>" id="input-height" class="form-control" />
                            <?php if ($error_seo) { ?>
                            <div class="text-danger"><?php echo $error_seo; ?></div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-status"><?php echo $text_status;?></label>
                        <div class="col-sm-10">
                            <select name="blog_category_status" id="input-status" class="form-control">
                                <?php if($blog_category_status){ ?>
                                <option value="1" selected="selected"><?php echo $text_enabled;?></option>
                                <option value="0"><?php echo $text_disabled;?></option>
                                <?php } else{ ?>
                                <option value="1"><?php echo $text_enabled;?></option>
                                <option value="0" selected="selected"><?php echo $text_disabled;?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>

                </div>
        </div>
    </div>
</div>
<?php echo $footer; ?>
