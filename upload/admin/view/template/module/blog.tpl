<style>
    .blue {
        background: #238fc9;
    }
    .darkblue{
        background: #1b6f9c !important;
    }
    .green {
        background: #24a46c;
    }
    .darkgreen {
        background: #1c8054 !important;
    }
    .pink {
        background: #e5588d;
    }
    .darkpink {
        background: #b2446d !important;
    }
    table{
      font-size: 12px;
    }
</style>
<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
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
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle href="#help"><?php echo $blog_dashboard;?></a></li>
            <li><a href="<?php echo $categories;?>"><?php echo $blog_categories;?></a></li>
            <li><a href="<?php echo $articles?>"><?php echo $blog_articles;?></a></li>
            <li><a href="<?php echo $comments?>"><?php echo $blog_comments;?></a></li>
            <li><a href="<?php echo $settings;?>"><?php echo $blog_settings;?></a></li>
        </ul> 
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4"><div class="tile">
                    <div class="tile-heading darkblue"><b><?php echo $text_total_blogs;?></b> 
                    </div>
                    <div class="tile-body blue"><i class="fa fa-rss"></i>
                        <h2 class="pull-right"><?php echo $totalBlogs;?></h2>
                    </div>
                    <div class="tile-footer darkblue"><a href="<?php echo $articles;?>"><?php echo $text_view_more;?></a></div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4"><div class="tile">
                    <div class="tile-heading darkpink"><b><?php echo $text_total_categories;?></b> </div>
                    <div class="tile-body pink"><i class="fa fa-link"></i>
                        <h2 class="pull-right"><?php echo $totalCategories;?></h2>
                    </div>
                    <div class="tile-footer darkpink"><a href="<?php echo $categories;?>"><?php echo $text_view_more;?></a></div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4"><div class="tile">
                    <div class="tile-heading darkgreen"><b><?php echo $text_total_comments;?></b> </div>
                    <div class="tile-body green"><i class="fa fa-comment"></i>
                        <h2 class="pull-right"><?php echo $totalComments;?></h2>
                    </div>
                    <div class="tile-footer darkgreen"><a href="<?php echo $comments;?>"><?php echo $text_view_more;?></a></div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="tab-content">
                <div id="help" class="tab-pane fade in active">
                    <div class="panel-heading">
                        <h3><?php echo $text_popular;?></h3>
                    </div>
                    <div class="panel-body">  
                         <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    
                                    <td><?php echo $text_image;?></td>
                                    <td>
                                        <?php echo $text_article_name;?>
                                        
                                    </td>
                                    <td>
                                        <?php echo $text_created_date;?>
                                       
                                    </td>
                                    <td>
                                        <?php echo $text_modified_date;?>
                                        
                                    </td>
                                    <td>
                                        <?php echo $text_sort_order;?>
                                    </td>
                                    <td>
                                      
                                        <?php echo $text_status?>
                                    </td>
                                    <td>
                                        <?php echo $featured_status?>
                                    </td>

                                    <td>
                                       <?php echo $text_hits;?>
                                    </td>

                                    <td><?php echo $text_action?></td>
                                </tr>
                            </thead> 
                            <tbody>
                                <?php if (isset($blogs)) { 
                                foreach($blogs as $blog){ 
                                ?>
                                <tr>

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
                    </div>
                </div>              
            </div>

        </div>
    </div>
</div>
</div>
<?php echo $footer; ?>

<script type="text/javascript">
    $(document).ready(function () {
        $('.settings').attr("id", "");
        $('.set-cls').click(function () {
            $('.settings').attr("id", "");
            $('.settings').attr("id", "form-blog");
        });
    });
</script>