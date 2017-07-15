<style>
    .comment-span{
        padding: 0px !important;
        border-bottom: 1px solid #ccc !important;
        border-top: none !important;
        border-left: none !important;
        border-right: none !important;
    }    
    .btn-text{
        color: #fff !important;
    }
    .btn-text:hover{
        color: black !important;
    }
    .description-cls{
        font-size : 18px;
    }
</style>
<?php echo $header; ?>
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
        <?php $class = 'col-sm-9'; ?>
        <?php } else { ?>
        <?php $class = 'col-sm-12'; ?>
        <?php } ?>
        <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
            <div class="row">

                <div class="<?php echo $class; ?>">
                    <?php if ($blog) { ?>
                    <h2><?php echo $blog['blog_title'];?></h2>

                    <?php if($settings['show_author']){ ?>
                    <p class="">Post by: <b><?php echo $blog['blog_creator_name']; ?></b>
                        <?php if (($settings['show_created_date']) || ($settings['show_category']) || ($settings['show_hits']) || ($settings['show_comment_counter'])) { ?>
                        |
                        <?php }?>
                        <?php } ?>

                        <?php if ($settings['show_created_date']) { ?>
                        <?php echo date("D, F j, Y, g:i a", strtotime($blog['blog_created_date'])); ?>
                        <?php if (($settings['show_category']) || ($settings['show_hits']) || ($settings['show_comment_counter'])) { ?>
                        |
                        <?php }?>
                        <?php } ?>

                        <?php if ($settings['show_hits']) { ?>
                        <b><?php echo $blog['blog_hits']; ?></b>&nbsp;<?php echo $text_hits;?>
                        <?php if (($settings['show_category']) || ($settings['show_comment_counter'])) { ?>
                        |
                        <?php }?>
                        <?php } ?>

                        <?php if ($settings['show_comment_counter']) { ?>
                        <b><?php echo $blog['blog_total_comment']; ?></b>&nbsp;<?php echo $text_comments;?>
                        <?php if ($settings['show_category']) { ?>
                        |
                        <?php }?>
                        <?php } ?>

                        <?php if ($settings['show_category']) { ?>
                        Category:&nbsp;<b><?php echo $blog['blog_category_name']; ?></b>           
                    </p>
                    <?php } ?>
                    <p class="description-cls"><?php echo $blog['blog_description']?>
                        <a type="button" class="readmore"><?php echo $text_readmore;?></a>
                    </p>
                    <div class="long-description-cls"><?php echo $blog['blog_long_description']?>
                        <a type="button" class="btn btn-primary readless"><?php echo $text_hide;?></a>
                    </div>


                    <?php } ?>

                </div>
            </div>

            <!-----------------Show Comment Start------------------------------------------------------>          
            <h4><?php echo $text_show_comment;?>&nbsp;&nbsp;&nbsp;<b>(<?php echo $total_comment;?>)</b></h4>
            <div class="row">
                <?php if ($column_left && $column_right) { ?>
                <?php $class = 'col-sm-6'; ?>
                <?php } elseif ($column_left || $column_right) { ?>
                <?php $class = 'col-sm-9'; ?>
                <?php } else { ?>
                <?php $class = 'col-sm-12'; ?>
                <?php } ?>
                <div class="<?php echo $class; ?>">
                    <div class="list-group blog-list-group">
                        <?php foreach ($comments as $comment) { ?> 
                        <span class="list-group-item comment-span">
                            <p>Comment by <b><?php echo $comment['comment_user_name'];?></b>&nbsp;|&nbsp;
                                <?php echo $comment['comment_created_date'];?>
                            </p>
                            <p><?php echo $comment['comment'];?></p>
                        </span><br>
                        <?php } ?>                        
                    </div>
                </div>
            </div> 

            <div class="row">
                <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
                <div class="col-sm-6 text-right"><?php echo $results; ?></div>
            </div>

            <!-----------------Show Comment End------------------------------------------------------>

            <?php echo $content_bottom; ?></div>

        <?php echo $column_right; ?></div>

</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.long-description-cls').hide();
        $('.readmore').click(function () {
            $('.description-cls').hide();
            $('.long-description-cls').show();
        });
        $('.readless').click(function () {
            $('.description-cls').show();
            $('.long-description-cls').hide();
        });
    });
</script>


<?php echo $footer; ?>

