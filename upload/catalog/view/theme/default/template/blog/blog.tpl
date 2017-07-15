<?php echo $header; ?>
<style>
    .single-blog{
        border-top: 0px !important;  
        border-left: 0px !important;  
        border-right: 0px !important;  
        border-bottom: 1px solid #ddd !important;
    }
    .description-font{
        font-size: 15px;
    }
    .tbl-font{
        font-size: 10px;
    }
    .title-font{
        font-weight:bold;
        font-size:20px;
    }
    .p-margin9{
        margin: -5px 0 12px;
    }
    .p-margin12{
        margin: 0px 0 12px;
    }
</style>
<div class="container">
    <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
    </ul>
    <div class="row"><?php echo $column_left; ?>
        <?php if ($column_left && $column_right) { ?>
        <?php $class = 'col-sm-6'; ?>
        <?php } elseif ($column_left || $column_right) { ?>
        <?php $class = 'col-sm-9'; 
        $margin = 'p-margin9';
        ?>
        <?php } else { ?>
        <?php $class = 'col-sm-12';
        $margin = 'p-margin12';
        ?>
        <?php } ?>
        <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
            <h2><?php //echo $heading_title; ?></h2>

            <?php if (isset($blog_info)) { ?>
            <div class="row">
                <div class="col-md-4">
                    <div class="btn-group hidden-xs">
                        <input type="hidden" name="route" class="route" value="<?php echo $route;?>">
                        <button type="button" id="blog-list-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_list; ?>"><i class="fa fa-th-list"></i></button>
                        <button type="button" id="blog-grid-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_grid; ?>"><i class="fa fa-th"></i></button>
                    </div>
                </div>
                <div class="col-md-2 text-right">
                    <label class="control-label" for="input-sort"><?php echo $text_sort; ?></label>
                </div>
                <div class="col-md-3 text-right">
                    <select id="input-sort" class="form-control" onchange="location = this.value;">
                        <?php foreach ($sorts as $sorts) { ?>
                        <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
                        <option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
                        <?php } ?>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-1 text-right">
                    <label class="control-label" for="input-limit"><?php echo $text_limit; ?></label>
                </div>
                <div class="col-md-2 text-right">
                    <select id="input-limit" class="form-control" onchange="location = this.value;">
                        <?php foreach ($limits as $limits) { ?>
                        <?php if ($limits['value'] == $limit) { ?>
                        <option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
                        <?php } ?>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <br />
            <div class="row">
                <?php foreach ($blog_info as $info) { ?>
                <div class="product-layout product-list col-xs-12">
                    <div class="product-thumb single-blog">
                        <div class="image"><a href="<?php echo $info['href']; ?>"><img src="<?php echo $info['thumb']; ?>" alt="<?php //echo $product['name']; ?>" title="<?php //echo $product['name']; ?>" class="img-responsive" /></a></div>
                        <div class="single-blog-grid">
                            <div class="caption">
                                <?php if ($info['show_title']) { ?>
                                <span class="title-font">
                                    <a href="<?php echo $info['href']; ?>"><?php echo $info['blog_title']; ?></a>
                                </span>
                                <?php } ?>

                                <?php if ($info['show_created_date']) { ?>
                                <p class=""><?php echo $info['blog_created_date']; ?></p>
                                <?php } ?>

                                <?php if ($info['show_category']) { ?>
                                <p class=""><?php echo $text_category;?>: <b><a href="<?php echo $info['category_href']; ?>"><?php if(isset($info['blog_category']['blog_category_name'])) echo $info['blog_category']['blog_category_name']; ?></a></b></p>
                                <?php } ?>

                                <?php if ($info['show_description']) { ?>
                                <p class="<?php echo $margin;?> description-font"><?php echo $info['blog_description']; ?>
                                    <?php if ($info['show_readmore']) { ?>
                                    <a class="blog-readmore" href="<?php echo $info['href']; ?>"><?php echo $text_readmore;?></a>
                                    <?php }?>
                                </p>

                                <?php } ?> 

                                <table class="blog-tbl">
                                    <tr class="tbl-font">
                                        <?php if ($info['show_author'] ){ ?> 
                                        <td>Post by: <b><?php echo $info['blog_creator']['username']?></b>
                                            <?php if (($info['show_comment_counter']) || ($info['blog_hits'])) { ?><span>|</span><?php } ?>
                                        </td>    
                                        <?php } ?>                                       
                                        <?php if ($info['show_comment_counter']) { ?>
                                        <td>
                                            <b><?php echo $info['blog_total_comment']?></b><?php echo $text_comments;?>
                                            <?php if ($info['blog_hits']) { ?><span>|</span><?php } ?>
                                        </td>
                                        <?php }?>
                                        <?php if ($info['blog_hits']) { ?>
                                        <td>
                                            <b><?php echo $info['blog_hits']?></b><?php echo $text_hits;?>
                                        </td>
                                        <?php }?>
                                    </tr>
                                </table>                                
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <div class="row">
                <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
                <div class="col-sm-6 text-right"><?php echo $results; ?></div>
            </div>
            <?php } else { ?>

            <p><h3><?php echo $text_empty; ?></h3></p>

            <?php } ?>
            <?php echo $content_bottom; ?></div>
        <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('.single-blog-grid').css('text-align', 'left');
        $('.blog-tbl').css('margin', '0 30px');
        $('.blog-readmore').css('margin', '0 30px');
        $('#blog-list-view').click(function () {
            $('#content .product-grid > .clearfix').remove();

            $('#content .row > .product-grid').attr('class', 'product-layout product-list col-xs-12');
            $('.single-blog-grid').css('text-align', 'left');
            $('.blog-tbl').css('margin', '0 30px');
            $('.blog-readmore').css('margin', '0 30px');

            localStorage.setItem('display', 'list');
        });

        // Product Grid
        $('#blog-grid-view').click(function () {

            var cols = $('#column-right, #column-left').length;

            if (cols == 2) {
                $('#content .product-list').attr('class', 'product-layout product-grid col-lg-6 col-md-6 col-sm-12 col-xs-12');
                $('.single-blog-grid').css('text-align', 'center');
                $('.blog-tbl').css('margin', '0px');
                $('.blog-readmore').css('margin', '0px');

            } else if (cols == 1) {
                $('#content .product-list').attr('class', 'product-layout product-grid col-lg-4 col-md-4 col-sm-6 col-xs-12');
                $('.single-blog-grid').css('text-align', 'center');
                $('.blog-tbl').css('margin', '0px');
                $('.blog-readmore').css('margin', '0px');
            } else {
                $('#content .product-list').attr('class', 'product-layout product-grid col-lg-3 col-md-3 col-sm-6 col-xs-12');
                $('.single-blog-grid').css('text-align', 'center');
                $('.blog-tbl').css('margin', '0px');
                $('.blog-readmore').css('margin', '0px');
            }


            localStorage.setItem('display', 'grid');
        });

        if (localStorage.getItem('display') == 'list') {
            $('#blog-list-view').trigger('click');
        } else {
            $('#bloggrid-view').trigger('click');
        }
    });
</script>


