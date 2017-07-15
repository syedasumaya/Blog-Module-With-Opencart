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
        <ul class="nav nav-tabs">
            <li><a href="<?php echo $dashboard?>"><?php echo $blog_dashboard;?></a></li>
            <li><a href="<?php echo $categories?>"><?php echo $blog_categories;?></a></li>
            <li class="active"><a href="<?php echo $articles;?>"><?php echo $blog_articles;?></a></li>
            <li><a href="<?php echo $comments;?>"><?php echo $blog_comments;?></a></li>
            <li><a href="<?php echo $settings;?>"><?php echo $blog_settings;?></a></li>
        </ul> 
        <div class="panel panel-default">
            <!------------------------------Settings Start----------------------------------->

            <div class="panel-heading">
                <h3><?php echo $heading_article;?></h3>
            </div>
            <div class="panel-body">  
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#general"><?php echo $tab_general;?></a></li>
                    <li><a data-toggle="tab" href="#blog"><?php echo $tab_blog;?></a></li>
                    <li><a data-toggle="tab" href="#image"><?php echo $tab_image;?></a></li>
                </ul>

                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-blog-settings" class="form-horizontal settings">
                    <div class="tab-content">
                        <!-------------------------------------General Start-------------------------------------------------------------------------------------------------->
                        <div id="general" class="tab-pane fade in active">
                            <div class="panel-body"> <?php  //echo '<pre>';print_r($category);?>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-status"><span style="color:red">*</span><?php echo $text_blog_category;?></label>
                                    <div class="col-sm-10">
                                        <select name="blog_category" id="input-status" class="form-control">
                                            <option value="">Select Category</option>
                                            <?php if ($blog_category) { 
                                            foreach($blog_category as $cat){
                                            ?>
                                            <option value="<?php echo $cat['blog_category_id']?>" <?php if($cat['blog_category_id'] == $category){ echo 'selected'; }?>><?php echo $cat['blog_category_name']?></option>                                           
                                            <?php } } ?>
                                        </select>
                                        <?php if ($error_category) { ?>
                                        <div class="text-danger"><?php echo $error_category; ?></div>
                                        <?php } ?>
                                    </div>
                                </div>                               


                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-status"><?php echo $text_tags;?></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="blog_tags" value="<?php echo $blog_tags; ?>" placeholder="<?php echo $text_tags_example;?>" id="input-height" class="form-control" />                                       
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-status"><?php echo $text_hits;?></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="blog_hits" value="<?php if($blog_hits == ''){ echo 0;}else { echo $blog_hits;} ?>" placeholder="<?php echo $text_hits;?>" id="input-height" class="form-control" />                                       
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-status"><?php echo $text_featured;?></label>
                                    <div class="col-sm-10">
                                        <select name="blog_featured" id="input-status" class="form-control">
                                            <?php if ($blog_featured) { ?>
                                            <option value="1" selected="selected"><?php echo $text_yes?></option>
                                            <option value="0"><?php echo $text_no?></option>
                                            <?php } else { ?>
                                            <option value="1"><?php echo $text_yes?></option>
                                            <option value="0" selected="selected"><?php echo $text_no?></option>
                                            <?php }?>
                                        </select>                                
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-related"><span data-toggle="tooltip" title="<?php echo $help_related; ?>"><?php echo $entry_related; ?></span></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="related" value="" placeholder="<?php echo $entry_related; ?>" id="input-related" class="form-control" />
                                        <div id="blog-related" class="well well-sm" style="height: 150px; overflow: auto;">
                                            <?php foreach ($blog_relateds as $blog_related) { ?>
                                            <div id="blog-related<?php echo $blog_related['blog_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $blog_related['blog_title']; ?>
                                                <input type="hidden" name="blog_related[]" value="<?php echo $blog_related['blog_id']; ?>" />
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-status"><span style="color:red">*</span><?php echo $text_seo_keyword;?></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="blog_seo_keyword" value="<?php echo $blog_seo_keyword; ?>" placeholder="<?php echo $text_seo_keyword;?>" id="input-height" class="form-control" />                                       
                                        <?php if ($error_seo) { ?>
                                        <div class="text-danger"><?php echo $error_seo; ?></div>
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-height"><?php echo $text_created_date;?></label>
                                    <div class="col-sm-3">
                                        <div class="input-group datetime">
                                            <?php $currentDate = date("Y-m-d H:m:s");?>
                                            <input type="text" name="blog_created_date" value="<?php if($blog_created_date == ''){ echo $currentDate;}else{ echo $blog_created_date;} ?>" placeholder="<?php echo $text_created_date;?>" data-date-format="YYYY-MM-DD HH:mm:ss" id="input-date-available" class="form-control" />
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                                            </span></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-status"><?php echo $text_creator;?></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="blog_creator_name" value="<?php echo $blog_creator_name; ?>" placeholder="<?php echo $text_blog_creator;?>" id="input-height" class="form-control" readonly />
                                        <input type="hidden" name="blog_creator" value="<?php echo $blog_creator; ?>" placeholder="Blog Creator" id="input-height" class="form-control" readonly />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-status"><?php echo $text_status;?></label>
                                    <div class="col-sm-10">
                                        <select name="blog_status" id="input-status" class="form-control">
                                            <?php if($blog_status){ ?>
                                            <option value="1" selected="selected"><?php echo $text_enabled;?></option>
                                            <option value="0"><?php echo $text_disabled;?></option>
                                            <?php } else{ ?>
                                            <option value="1"><?php echo $text_enabled;?></option>
                                            <option value="0" selected="selected"><?php echo $text_disabled;?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-status"><?php echo $text_sort_order;?></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="blog_sort_order" value="<?php echo $blog_sort_order; ?>" placeholder="<?php echo $text_sort_order;?>" id="input-height" class="form-control" />                                       
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!----------------------------------------------Blog Start------------------------------------------------------------------------->
                        <div id="blog" class="tab-pane fade">
                            <div class="panel-body">  

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-status"><span style="color:red">*</span><?php echo $text_blog_title;?></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="blog_title" value="<?php echo $blog_title; ?>" placeholder="<?php echo $text_blog_title;?>" id="input-height" class="form-control" />                                 
                                        <?php if ($error_title) { ?>
                                        <div class="text-danger"><?php echo $error_title; ?></div>
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-status"><?php echo $text_blog_decription;?></label>
                                    <div class="col-sm-10">
                                        <textarea name="blog_description" placeholder="" id="input-description" class="form-control summernote"><?php echo $blog_description;?></textarea>                                 
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!------------------------------------------------Image start----------------------------------------------------------------->
                        <div id="image" class="tab-pane fade">
                            <div class="panel-body"> 
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <td class="text-left"><?php echo $text_image;?></td>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td class="text-left">
                                                    <a href="" id="thumb-image" data-toggle="image" class="img-thumbnail">
                                                        <img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" />
                                                    </a>
                                                    <input type="hidden" name="blog_image" value="<?php echo $blog_image; ?>" id="input-image" />
                                                </td>
                                            </tr>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>

            <!------------------------------Settings End----------------------------------->
        </div>
    </div>
</div>
</div>
</div>
<?php echo $footer; ?>
<script type="text/javascript">

    $('.datetime').datetimepicker({
        pickDate: true,
        pickTime: true
    });


    // Related
    $('input[name=\'related\']').autocomplete({
        'source': function (request, response) {
            $.ajax({
                url: 'index.php?route=module/blog/blog_articles/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request),
                dataType: 'json',
                success: function (json) {
                    response($.map(json, function (item) {
                        return {
                            label: item['blog_title'],
                            value: item['blog_id']
                        }
                    }));
                }
            });
        },
        'select': function (item) {
            $('input[name=\'related\']').val('');

            $('#blog-related' + item['value']).remove();

            $('#blog-related').append('<div id="blog-related' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="blog_related[]" value="' + item['value'] + '" /></div>');
        }
    });

    $('#blog-related').delegate('.fa-minus-circle', 'click', function () {
        $(this).parent().remove();
    });
</script>