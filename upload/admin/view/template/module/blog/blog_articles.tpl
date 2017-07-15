<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <a href="<?php echo $add; ?>" data-toggle="tooltip" title="Add New Article" class="btn btn-primary"><i class="fa fa-plus"></i></a>
                <button type="button" data-toggle="tooltip" title="Delete Article" class="btn btn-danger" onclick="confirm('Are you sure?') ? $('#form-product').submit() : false;"><i class="fa fa-trash-o"></i></button>
            </div>
            <h1><?php echo $heading_blog; ?></h1>
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
            <!------------------------------Category List Start----------------------------------->
            <div class="panel-heading">
                <h3><?php echo $heading_blog_article;?></h3>
            </div>
            <div class="panel-body">  

                <div class="well">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="input-name"><?php echo $article_name;?></label>
                                <input type="text" name="filter_name" value="" placeholder="<?php echo $article_name;?>" id="input-name" class="form-control">
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="input-status"><?php echo $featured_status;?></label>
                                <select name="filter_featured" id="input-status" class="form-control">
                                    <option value="*"></option>
                                    <?php if ($filter_featured) { ?>
                                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                    <?php } else { ?>
                                    <option value="1"><?php echo $text_enabled; ?></option>
                                    <?php } ?>
                                    <?php if (!$filter_featured && !is_null($filter_featured)) { ?>
                                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                    <?php } else { ?>
                                    <option value="0"><?php echo $text_disabled; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>                       
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="input-status"><?php echo $status;?></label>
                                <select name="filter_status" id="input-status" class="form-control">
                                    <option value="*"></option>
                                    <?php if ($filter_status) { ?>
                                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                    <?php } else { ?>
                                    <option value="1"><?php echo $text_enabled; ?></option>
                                    <?php } ?>
                                    <?php if (!$filter_status && !is_null($filter_status)) { ?>
                                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                    <?php } else { ?>
                                    <option value="0"><?php echo $text_disabled; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="input-group date">  
                                    <label class="control-label" for="input-status"><?php echo $text_created_date;?></label>
                                    <input type="text" name="filter_created_date" value="" placeholder="<?php echo $text_created_date;?>" data-date-format="YYYY-MM-DD" id="input-date-available" class="form-control" />
                                    <span class="input-group-btn">
                                        <button style="margin-top:22px;" class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                                    </span>
                                </div>
                            </div>
                            <button type="button" id="blog-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i><?php echo $text_filter;?></button>
                        </div>  
                    </div>
                </div>


                <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-product">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                                    <td><?php echo $text_image;?></td>
                                    <td><?php if ($sort == 'blog_title') { ?>
                                        <a href="<?php echo $sort_title; ?>" class="<?php echo strtolower($order); ?>"><?php echo $text_article_name;?></a>
                                        <?php } else { ?>
                                        <a href="<?php echo $sort_title; ?>"><?php echo $text_article_name;?></a>
                                        <?php }?>
                                    </td>
                                    <td><?php if ($sort == 'blog_created_date') { ?>
                                        <a href="<?php echo $sort_created_date; ?>" class="<?php echo strtolower($order); ?>"><?php echo $text_created_date;?></a>
                                        <?php } else { ?>
                                        <a href="<?php echo $sort_created_date; ?>"><?php echo $text_created_date;?></a>
                                        <?php }?>
                                    </td>
                                    <td><?php if ($sort == 'blog_modified_date') { ?>
                                        <a href="<?php echo $sort_modified_date; ?>" class="<?php echo strtolower($order); ?>"><?php echo $text_modified_date;?></a>
                                        <?php } else { ?>
                                        <a href="<?php echo $sort_modified_date; ?>"><?php echo $text_modified_date;?></a>
                                        <?php }?>
                                    </td>
                                    <td>
                                        <?php if ($sort == 'blog_sort_order') { ?>
                                        <a href="<?php echo $sort_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $text_sort_order;?></a>
                                        <?php } else { ?>
                                        <a href="<?php echo $sort_order; ?>"><?php echo $text_sort_order;?></a>
                                        <?php }?>
                                    </td>
                                    <td>
                                        <?php if ($sort == 'blog_status') { ?>
                                        <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $text_status?></a>
                                        <?php } else { ?>
                                        <a href="<?php echo $sort_status; ?>"><?php echo $text_status?></a>
                                        <?php }?>
                                    </td>
                                    <td>
                                        <?php if ($sort == 'blog_featured') { ?>
                                        <a href="<?php echo $sort_featured; ?>" class="<?php echo strtolower($order); ?>"><?php echo $featured_status?></a>
                                        <?php } else { ?>
                                        <a href="<?php echo $sort_featured; ?>"><?php echo $featured_status?></a>
                                        <?php }?>
                                    </td>

                                    <td>
                                        <?php if ($sort == 'blog_hits') { ?>
                                        <a href="<?php echo $sort_hits; ?>" class="<?php echo strtolower($order); ?>"><?php echo $text_hits;?></a>
                                        <?php } else { ?>
                                        <a href="<?php echo $sort_hits; ?>"><?php echo $text_hits;?></a>
                                        <?php }?>
                                    </td>

                                    <td><?php echo $text_action?></td>
                                </tr>
                            </thead> 
                            <tbody>
                                <?php if (isset($blogs)) { 
                                foreach($blogs as $blog){ 
                                ?>
                                <tr>
                                    <td class="text-center"><?php if (in_array($blog['blog_id'], $selected)) { ?>
                                        <input type="checkbox" name="selected[]" value="<?php echo $blog['blog_id']; ?>" checked="checked" />
                                        <?php } else { ?>
                                        <input type="checkbox" name="selected[]" value="<?php echo $blog['blog_id']; ?>" />
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if ($blog['blog_image']) { ?>
                                        <img src="<?php echo $blog['blog_image']; ?>" alt="<?php echo $blog['blog_title']; ?>" class="img-thumbnail" />
                                        <?php } else { ?>
                                        <span class="img-thumbnail list"><i class="fa fa-camera fa-2x"></i></span>
                                        <?php } ?>
                                    </td>
                                    <td><?php echo $blog['blog_title'];?></td>
                                    <td><?php echo $blog['blog_created_date'];?></td>
                                    <td><?php echo $blog['blog_modified_date'];?></td>
                                    <td><?php echo $blog['blog_sort_order'];?></td>
                                    <td><?php if ($blog['blog_status'] == 1) { echo $text_enabled; } else { echo $text_disabled;} ?></td>
                                    <td><?php if ($blog['blog_featured'] == 1) { echo $text_featured; } else { echo $text_not_featured;} ?></td>
                                    <td><?php echo $blog['blog_hits'];?></td>
                                    <td>
                                        <a href="<?php echo $blog['edit']; ?>" data-toggle="tooltip" title="Edit Article" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                                        <a href="<?php echo $blog['comment']; ?>" data-toggle="tooltip" title="Comment" class="btn btn-success"><i class="fa fa-comment"></i></a>
                                    </td>
                                </tr>
                                <?php } } ?>
                            </tbody>
                        </table>    
                    </div>
                </form>
                <div class="row">
                    <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
                    <div class="col-sm-6 text-right"><?php echo $results; ?></div>
                </div>
            </div>
            <!------------------------------Category List End----------------------------------->
        </div>
    </div>
</div>

<?php echo $footer; ?>

<script type="text/javascript">
    $('.date').datetimepicker({
        pickTime: false
    });
</script>

<script type="text/javascript">
    $('#blog-filter').on('click', function () {
        var url = 'index.php?route=module/blog/blog_articles&token=<?php echo $token; ?>';

        var filter_name = $('input[name=\'filter_name\']').val();

        if (filter_name) {
            url += '&filter_name=' + encodeURIComponent(filter_name);
        }
        var filter_status = $('select[name=\'filter_status\']').val();

        if (filter_status != '*') {
            url += '&filter_status=' + encodeURIComponent(filter_status);
        }

        var filter_featured = $('select[name=\'filter_featured\']').val();
        if (filter_featured != '*') {
            url += '&filter_featured=' + encodeURIComponent(filter_featured);
        }

        var filter_created_date = $('input[name=\'filter_created_date\']').val();

        if (filter_created_date) {
            url += '&filter_created_date=' + encodeURIComponent(filter_created_date);
        }

        location = url;
    });
</script>  

<script type="text/javascript">
    $('input[name=\'filter_name\']').autocomplete({
        'source': function (request, response) {
            $.ajax({
                url: 'index.php?route=module/blog/blog_articles/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request),
                dataType: 'json',
                success: function (json) {
                    response($.map(json, function (item) {
                        return {
                            label: item['blog_title'],
                            value: item['blog_title']
                        }
                    }));
                }
            });
        },
        'select': function (item) {
            $('input[name=\'filter_name\']').val(item['label']);
        }
    });
</script>
