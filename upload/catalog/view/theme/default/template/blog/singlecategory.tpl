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
            <h2><?php echo $heading_title; ?></h2>
            <?php if ($description) { ?>
            <div class="row">        
                <?php if ($description) { ?>
                <div class="col-sm-10"><?php echo $description; ?></div>
                <?php } ?>
            </div>
            <hr>
            <?php } ?>
            <?php if ($blog_info) { ?>
            <div class="row">
                <div class="col-md-4">
                    <div class="btn-group hidden-xs">
                        <button type="button" id="list-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_list; ?>"><i class="fa fa-th-list"></i></button>
                        <button type="button" id="grid-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_grid; ?>"><i class="fa fa-th"></i></button>
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
                                <p class=""><?php echo $text_category;?>: <b><?php if(isset($info['blog_category'])) echo $info['blog_category']; ?></b></p>
                                <?php } ?>

                                <?php if ($info['show_description']) { ?>
                                <p class="<?php echo $margin;?> description-font"><?php echo $info['blog_description']; ?>
                                    <?php if ($info['show_readmore']) { ?>
                                    <a class="blog-readmore" href="<?php echo $info['href']; ?>"><?php echo $text_readmore;?></a>
                                    <?php }?>
                                </p>

                                <?php } ?> 


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
            <?php } ?>
            <?php if (!$blog_info) { ?>
            <p><?php echo $text_empty; ?></p>
            <div class="buttons">
                <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
            </div>
            <?php } ?>
            <?php echo $content_bottom; ?></div>
        <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>
