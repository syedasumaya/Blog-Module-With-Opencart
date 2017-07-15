<h3><?php echo $heading_title; ?></h3>
<div class="row">
    <?php foreach ($featured as $feat) { ?>
    <div class="product-layout col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="product-thumb transition">
            <div class="image"><a href="<?php echo $feat['href']; ?>"><img src="<?php echo $feat['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a></div>
            <div class="caption">
                <h4><a href="<?php echo $feat['href']; ?>"><?php echo $feat['blog_title']; ?></a></h4>
                <p><?php echo $feat['blog_description']; ?></p>
                <?php if (($feat['settings_blog_hits']) || ($feat['settings_blog_show_comment_counter'])) { ?>
                <div class="rating">
                    <?php if ($feat['settings_blog_hits']){ ?>
                    <span style="padding-right: 5px;"><b><?php echo $feat['blog_hits']?></b><?php echo $text_hits?></span> 
                    <?php }?>
                    <?php if ($feat['settings_blog_show_comment_counter']){ ?>
                    <span><b><?php echo $feat['blog_comments']?></b><?php echo $text_comments;?></span> 
                    <?php } ?>
                </div>
                <?php } ?>
            </div>           
        </div>
    </div>
    <?php } ?>
</div>
