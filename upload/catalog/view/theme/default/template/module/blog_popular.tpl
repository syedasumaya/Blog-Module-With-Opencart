<div class="list-group">
    <a  class="list-group-item active"><b><?php echo $heading_title;?></b></a>  
    <?php foreach ($popular as $pop) { ?>
    <a href="<?php echo $pop['href']; ?>" class="list-group-item"><?php echo $pop['blog_title']; ?></a>
    <?php } ?>
</div>
