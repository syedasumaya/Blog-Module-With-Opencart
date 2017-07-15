<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-blog-settings" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary save-btn"><i class="fa fa-save"></i></button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
            <h1><?php echo $heading_editComment; ?></h1>
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
                <h3><?php echo $heading_editComment;?></h3>
            </div>

            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-blog-settings" class="form-horizontal settings">

                <div class="panel-body"> 

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-height"><?php echo $text_created_date;?></label>
                        <div class="col-sm-10">
                            <input type="text" name="comment_created_date" value="<?php echo $comment_created_date;?>" placeholder="<?php echo $text_created_date;?>" id="input-height" class="form-control" readonly />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-height"><?php echo $text_user_name;?></label>
                        <div class="col-sm-10">
                            <input type="text" name="comment_user_name" value="<?php echo $comment_user_name; ?>" placeholder="<?php echo $text_user_name;?>" id="input-height" class="form-control" readonly/>
                        </div>
                    </div>                    

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-height"><?php echo $text_user_email; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="comment_user_email" value="<?php echo $comment_user_email; ?>" placeholder="<?php echo $text_user_email; ?>" id="input-height" class="form-control" readonly/>                          
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-status"><?php echo $text_status;?></label>
                        <div class="col-sm-10">
                            <select name="comment_status" id="input-status" class="form-control">
                                <?php if ($comment_status) { ?>
                                <option value="1" selected="selected">Publish</option>
                                <option value="0">Disable</option>
                                <?php } else { ?>
                                <option value="1">Enable</option>
                                <option value="0" selected="selected">Unpublish</option>
                                <?php }?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-height"><?php echo $text_comment; ?></label>
                        <div class="col-sm-10">
                            <textarea  name="comment" class="form-control" cols="90" rows="6"><?php echo $comment;?></textarea> 
                        </div>
                    </div>

                </div>
        </div>
    </div>
</div>
<?php echo $footer; ?>
