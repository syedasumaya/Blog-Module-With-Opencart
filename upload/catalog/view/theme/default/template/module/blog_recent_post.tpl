<div class="list-group">
    <a class="list-group-item active"><b><?php echo $heading_title;?></b></a>  
    <?php foreach ($recentpost as $post) { ?>
    <a href="<?php echo $post['href']; ?>" class="list-group-item"><?php echo $post['blog_title']; ?></a>
    <?php } ?>
</div>
