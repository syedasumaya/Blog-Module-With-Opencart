<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-blog-settings" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary save-btn"><i class="fa fa-save"></i></button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
            <h1><?php echo $blog_settings; ?></h1>
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
        <?php if ($error_sitekey) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_sitekey; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <?php if (isset($error_access_token)) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_access_token; ?>
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
            <li><a href="<?php echo $articles;?>"><?php echo $blog_articles;?></a></li>
            <li><a href="<?php echo $comments;?>"><?php echo $blog_comments;?></a></li>
            <li class="active"><a href="<?php echo $settings;?>"><?php echo $blog_settings;?></a></li>
        </ul> 

        <div class="panel panel-default">
            <!------------------------------Settings Start----------------------------------->

            <div class="panel-heading">
                <h3><?php echo $heading_settings;?></h3>
            </div>
            <div class="panel-body">  
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#general"><?php echo $tab_general;?></a></li>
                    <li><a data-toggle="tab" href="#option"><?php echo $tab_option;?></a></li>
                    <li><a data-toggle="tab" href="#image"><?php echo $tab_image;?></a></li>
                    <li><a data-toggle="tab" href="#color"><?php echo $tab_color;?></a></li>
                    <li><a data-toggle="tab" href="#social"><?php echo $tab_social;?></a></li>
                </ul>

                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-blog-settings" class="form-horizontal settings">
                    <div class="tab-content">

                        <div id="general" class="tab-pane fade in active">
                            <div class="panel-body"> 

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-height"><?php echo $blog_name;?></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="blog_blogname" value="<?php echo $blog_blogname; ?>" placeholder="<?php echo $blog_name;?>" id="input-height" class="form-control" />
                                        <?php //if ($error_blogname) { ?>
                                        <!-- <div class="text-danger"><?php echo $error_blogname; ?></div>-->
                                        <?php //} ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-height"><?php echo $seo_key;?></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="blog_seo_keyword" value="<?php echo $blog_seo_keyword; ?>" placeholder="<?php echo $seo_key;?>" id="input-height" class="form-control" />
                                        <?php //if ($error_blogname) { ?>
                                        <!-- <div class="text-danger"><?php echo $error_blogname; ?></div>-->
                                        <?php //} ?>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div id="option" class="tab-pane fade">
                            <div class="panel-body">  

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-status"><?php echo $show_title; ?></label>
                                    <div class="col-sm-10">
                                        <select name="blog_show_title" id="input-status" class="form-control">
                                            <?php if ($blog_show_title) { ?>
                                            <option value="1" selected="selected"><?php echo $text_yes;?></option>
                                            <option value="0"><?php echo $text_no;?></option>
                                            <?php } else { ?>
                                            <option value="1"><?php echo $text_yes;?></option>
                                            <option value="0" selected="selected"><?php echo $text_no;?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-status"><?php echo $show_description; ?></label>
                                    <div class="col-sm-10">
                                        <select name="blog_show_description" id="input-status" class="form-control">
                                            <?php if ($blog_show_description) { ?>
                                            <option value="1" selected="selected"><?php echo $text_yes;?></option>
                                            <option value="0"><?php echo $text_no;?></option>
                                            <?php } else { ?>
                                            <option value="1"><?php echo $text_yes;?></option>
                                            <option value="0" selected="selected"><?php echo $text_no;?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-status"><?php echo $show_readmore; ?></label>
                                    <div class="col-sm-10">
                                        <select name="blog_show_readmore" id="input-status" class="form-control">
                                            <?php if ($blog_show_readmore) { ?>
                                            <option value="1" selected="selected"><?php echo $text_yes;?></option>
                                            <option value="0"><?php echo $text_no;?></option>
                                            <?php } else { ?>
                                            <option value="1"><?php echo $text_yes;?></option>
                                            <option value="0" selected="selected"><?php echo $text_no;?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-status"><?php echo $text_blog_limit; ?></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="blog_limit" value="<?php echo $blog_limit; ?>" placeholder="<?php echo $blog_limit;?>" id="input-height" class="form-control" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-status"><?php echo $show_description_limit; ?></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="blog_show_description_limit" value="<?php echo $blog_show_description_limit; ?>" placeholder="<?php echo $show_description_limit;?>" id="input-height" class="form-control" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-status"><?php echo $show_category_limit; ?></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="blog_show_category_limit" value="<?php echo $blog_show_category_limit; ?>" placeholder="<?php echo $show_category_limit;?>" id="input-height" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-status"><?php echo $show_category_description_limit; ?></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="blog_show_category_description_limit" value="<?php echo $blog_show_category_description_limit; ?>" placeholder="<?php echo $show_category_description_limit;?>" id="input-height" class="form-control" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-status"><?php echo $show_articles_under_category; ?></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="blog_show_articles_under_category" value="<?php echo $blog_show_articles_under_category; ?>" placeholder="<?php echo $blog_show_articles_under_category;?>" id="input-height" class="form-control" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-status"><?php echo $show_image; ?></label>
                                    <div class="col-sm-10">
                                        <select name="blog_show_image" id="input-status" class="form-control">
                                            <?php if ($blog_show_image) { ?>
                                            <option value="1" selected="selected"><?php echo $text_yes;?></option>
                                            <option value="0"><?php echo $text_no;?></option>
                                            <?php } else { ?>
                                            <option value="1"><?php echo $text_yes;?></option>
                                            <option value="0" selected="selected"><?php echo $text_no;?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-status"><?php echo $show_author; ?></label>
                                    <div class="col-sm-10">
                                        <select name="blog_show_author" id="input-status" class="form-control">
                                            <?php if ($blog_show_author) { ?>
                                            <option value="1" selected="selected"><?php echo $text_yes;?></option>
                                            <option value="0"><?php echo $text_no;?></option>
                                            <?php } else { ?>
                                            <option value="1"><?php echo $text_yes;?></option>
                                            <option value="0" selected="selected"><?php echo $text_no;?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-status"><?php echo $show_category; ?></label>
                                    <div class="col-sm-10">
                                        <select name="blog_show_category" id="input-status" class="form-control">
                                            <?php if ($blog_show_category) { ?>
                                            <option value="1" selected="selected"><?php echo $text_yes;?></option>
                                            <option value="0"><?php echo $text_no;?></option>
                                            <?php } else { ?>
                                            <option value="1"><?php echo $text_yes;?></option>
                                            <option value="0" selected="selected"><?php echo $text_no;?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-status"><?php echo $text_date_format; ?></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="blog_date_format" value="<?php echo $blog_date_format; ?>" placeholder="<?php echo $text_date_format_example;?>" id="input-height" class="form-control" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-status"><?php echo $show_created_date; ?></label>
                                    <div class="col-sm-10">
                                        <select name="blog_show_created_date" id="input-status" class="form-control">
                                            <?php if ($blog_show_created_date) { ?>
                                            <option value="1" selected="selected"><?php echo $text_yes;?></option>
                                            <option value="0"><?php echo $text_no;?></option>
                                            <?php } else { ?>
                                            <option value="1"><?php echo $text_yes;?></option>
                                            <option value="0" selected="selected"><?php echo $text_no;?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-status"><?php echo $show_hits; ?></label>
                                    <div class="col-sm-10">
                                        <select name="blog_show_hits" id="input-status" class="form-control">
                                            <?php if ($blog_show_hits) { ?>
                                            <option value="1" selected="selected"><?php echo $text_yes;?></option>
                                            <option value="0"><?php echo $text_no;?></option>
                                            <?php } else { ?>
                                            <option value="1"><?php echo $text_yes;?></option>
                                            <option value="0" selected="selected"><?php echo $text_no;?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-status"><?php echo $show_comment_counter; ?></label>
                                    <div class="col-sm-10">
                                        <select name="blog_show_comment_counter" id="input-status" class="form-control">
                                            <?php if ($blog_show_comment_counter) { ?>
                                            <option value="1" selected="selected"><?php echo $text_yes;?></option>
                                            <option value="0"><?php echo $text_no;?></option>
                                            <?php } else { ?>
                                            <option value="1"><?php echo $text_yes;?></option>
                                            <option value="0" selected="selected"><?php echo $text_no;?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-height"><?php echo $show_limits_comments;?></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="blog_show_limits_comments" value="<?php echo $blog_show_limits_comments; ?>" placeholder="Show Limits Comments" id="input-height" class="form-control" />                                        
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-status"><?php echo $show_auto_publish_comment; ?></label>
                                    <div class="col-sm-10">
                                        <select name="blog_show_auto_publish_comment" id="input-status" class="form-control recaptcha">
                                            <?php if ($blog_show_auto_publish_comment) { ?>
                                            <option value="1" selected="selected"><?php echo $text_yes;?></option>
                                            <option value="0"><?php echo $text_no;?></option>
                                            <?php } else { ?>
                                            <option value="1"><?php echo $text_yes;?></option>
                                            <option value="0" selected="selected"><?php echo $text_no;?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-status"><?php echo $show_social_media_share; ?></label>
                                    <div class="col-sm-10">
                                        <select name="blog_social_media_share" id="input-status" class="form-control recaptcha">
                                            <?php if ($blog_social_media_share) { ?>
                                            <option value="1" selected="selected"><?php echo $text_enabled;?></option>
                                            <option value="0"><?php echo $text_disabled;?></option>
                                            <?php } else { ?>
                                            <option value="1"><?php echo $text_enabled;?></option>
                                            <option value="0" selected="selected"><?php echo $text_disabled;?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-status"><?php echo $show_enable_recaptcha; ?></label>
                                    <div class="col-sm-10">
                                        <select name="blog_show_enable_recaptcha" id="input-status" class="form-control recap">
                                            <?php if ($blog_show_enable_recaptcha) { ?>
                                            <option value="1" selected="selected"><?php echo $text_yes;?></option>
                                            <option value="0"><?php echo $text_no;?></option>
                                            <?php } else { ?>
                                            <option value="1"><?php echo $text_yes;?></option>
                                            <option value="0" selected="selected"><?php echo $text_no;?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-status"><?php echo $show_blog_comment_minmax_character; ?></label>
                                    <div class="col-sm-10">

                                        <input type="text" name="blog_comment_min_character" size="3" style="width:20%;" value="<?php echo $blog_comment_min_character; ?>" placeholder="<?php echo $show_blog_comment_min_character;?>" id="input-height" class="form-control" />
                                        x
                                        <input type="text" name="blog_comment_max_character" size="3" style="width:20%;" value="<?php echo $blog_comment_max_character; ?>" placeholder="<?php echo $show_blog_comment_max_character;?>" id="input-height" class="form-control" />                           
                                    </div>
                                </div>

                                <div class="form-group recaptcha_key">
                                    <label class="col-sm-2 control-label" for="input-status"><span style="color:red">*</span><?php echo $show_recaptcha_sitekey; ?></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="blog_recaptcha_sitekey" value="<?php echo $blog_recaptcha_sitekey; ?>" placeholder="<?php echo $show_recaptcha_sitekey;?>" id="input-height" class="form-control" />
                                    </div>
                                </div>

                                <div class="form-group recaptcha_key">
                                    <label class="col-sm-2 control-label" for="input-status"><span style="color:red">*</span><?php echo $show_recaptcha_secretkey; ?></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="blog_recaptcha_secretkey" value="<?php echo $blog_recaptcha_secretkey; ?>" placeholder="<?php echo $show_recaptcha_secretkey; ?>" id="input-height" class="form-control" />
                                    </div>
                                </div>


                            </div>
                        </div>

                        <div id="image" class="tab-pane fade">
                            <div class="panel-body"> 

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-height"><?php echo $blog_large_image;?></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="blog_large_image_width" size="3" style="width:20%;" value="<?php echo $blog_large_image_width; ?>" placeholder="<?php echo $text_width;?>" id="input-height" class="form-control" />
                                        x
                                        <input type="text" name="blog_large_image_height" size="3" style="width:20%;" value="<?php echo $blog_large_image_height; ?>" placeholder="<?php echo $text_height;?>" id="input-height" class="form-control" />                           
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-height"><?php echo $blog_small_image;?></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="blog_small_image_width" size="3" style="width:20%;" value="<?php echo $blog_small_image_width; ?>" placeholder="<?php echo $text_width;?>" id="input-height" class="form-control" />
                                        x
                                        <input type="text" name="blog_small_image_height" size="3" style="width:20%;" value="<?php echo $blog_small_image_height; ?>" placeholder="<?php echo $text_height;?>" id="input-height" class="form-control" />                                       
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-height"><?php echo $blog_related_image;?></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="blog_related_image_width" size="3" style="width:20%;" value="<?php echo $blog_related_image_width; ?>" placeholder="Width" id="input-height" class="form-control" />
                                        x
                                        <input type="text" name="blog_related_image_height" size="3" style="width:20%;" value="<?php echo $blog_related_image_height; ?>" placeholder="Hieght" id="input-height" class="form-control" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="color" class="tab-pane fade">
                            <div class="panel-body"> 

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-height"><?php echo $text_blog_heading_color;?></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="blog_heading_color" value="<?php echo $blog_heading_color; ?>" placeholder="<?php echo $text_blog_heading_color;?>" id="input-height" class="form-control" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-height"><?php echo $text_blog_description_color;?></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="blog_description_color" value="<?php echo $blog_description_color; ?>" placeholder="<?php echo $text_blog_heading_color;?>" id="input-height" class="form-control" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-height"><?php echo $text_blog_heading_font_size;?></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="blog_heading_font_size" value="<?php echo $blog_heading_font_size; ?>" placeholder="<?php echo $text_blog_heading_font_size;?>" id="input-height" class="form-control" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-height"><?php echo $text_blog_description_font_size;?></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="blog_description_font_size" value="<?php echo $blog_description_font_size; ?>" placeholder="<?php echo $text_blog_description_font_size;?>" id="input-height" class="form-control" />
                                    </div>
                                </div>

                            </div> 
                        </div> 


                        <div id="social" class="tab-pane fade">
                            <div class="panel-body">
                                <h4><?php echo $text_facebook; ?></h4>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-status"><?php echo $auto_post_on_facebook; ?></label>
                                    <div class="col-sm-10">
                                        <select name="blog_auto_post_on_facebook" id="input-status" class="form-control">
                                            <?php if ($blog_auto_post_on_facebook) { ?>
                                            <option value="1" selected="selected"><?php echo $text_enabled;?></option>
                                            <option value="0"><?php echo $text_disabled;?></option>
                                            <?php } else { ?>
                                            <option value="1"><?php echo $text_enabled;?></option>
                                            <option value="0" selected="selected"><?php echo $text_disabled;?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-height"><?php echo $facebook_app_id;?></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="blog_facebook_app_id" value="<?php echo $blog_facebook_app_id; ?>" placeholder="<?php echo $text_app_id;?>" id="input-height" class="form-control" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-height"><?php echo $facebook_app_secret;?></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="blog_facebook_app_secret" value="<?php echo $blog_facebook_app_secret; ?>" placeholder="<?php echo $text_secret_id;?>" id="input-height" class="form-control" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-height"><?php echo $text_message;?></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="blog_facebook_message" value="<?php echo $blog_facebook_message; ?>" placeholder="<?php echo $text_message;?>" id="input-height" class="form-control" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-height"> 
                                        <?php if (isset($blog_facebook_access_token) && ($blog_facebook_access_token !='')) { ?>
                                        <a class="btn btn-primary" href="<?php echo $deauthorize;?>"><?php echo $text_deauthorize;?></a>                    
                                        <?php } else { ?>  
                                        <a class="btn btn-primary" href="<?php echo $authorize;?>"><?php echo $text_authorize;?></a>
                                        <?php }?>
                                    </label>
                                    <div class="col-sm-10">
                                        <?php if (isset($blog_facebook_access_token) && ($blog_facebook_access_token !='')) { ?>
                                        <?php echo $text_connected;?> 
                                        <?php } else { ?>
                                        <?php echo $text_disconnected;?>
                                        <?php } ?>  
                                    </div> 
                                </div>

                            </div>

                            <div class="panel-body">
                                <h4><?php echo $text_twitter; ?></h4>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-status"><?php echo $auto_post_on_twitter; ?></label>
                                    <div class="col-sm-10">
                                        <select name="blog_auto_post_on_twitter" id="input-status" class="form-control">
                                            <?php if ($blog_auto_post_on_twitter) { ?>
                                            <option value="1" selected="selected"><?php echo $text_enabled;?></option>
                                            <option value="0"><?php echo $text_disabled;?></option>
                                            <?php } else { ?>
                                            <option value="1"><?php echo $text_enabled;?></option>
                                            <option value="0" selected="selected"><?php echo $text_disabled;?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-height"><?php echo $twit_consumer_key;?></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="blog_twit_consumer_key" value="<?php echo $blog_twit_consumer_key; ?>" placeholder="<?php echo $twit_consumer_key;?>" id="input-height" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-height"><?php echo $twit_consumer_secret;?></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="blog_twit_consumer_secret" value="<?php echo $blog_twit_consumer_secret; ?>" placeholder="<?php echo $twit_consumer_secret;?>" id="input-height" class="form-control" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-height"><?php echo $twit_access_token;?></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="blog_twit_access_token" value="<?php echo $blog_twit_access_token; ?>" placeholder="<?php echo $twit_access_token;?>" id="input-height" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-height"><?php echo $twit_access_token_secret;?></label>
                                    <div class="col-sm-10">
                                        <input type="text" name="blog_twit_access_token_secret" value="<?php echo $blog_twit_access_token_secret; ?>" placeholder="<?php echo $twit_access_token_secret;?>" id="input-height" class="form-control" />
                                    </div>
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

<script type="text/javascript">
    $(document).ready(function () {
        var value = $('select[name=\'blog_show_enable_recaptcha\']').val();
        if (value == 0) {
            $(".recaptcha_key").hide();
        } else {
            $(".recaptcha_key").show();
        }

        $(".recap").change(function () {
            var show = $(this).val();
            if (show == 1) {
                $(".recaptcha_key").show();
            } else {
                $(".recaptcha_key").hide();
            }
        });
    });

</script>

<?php echo $footer; ?>
