<div class="list-group">
  <a class="list-group-item active"><b><?php echo $heading_title;?></b></a>  
  <?php foreach ($categories as $category) { ?>
  <a href="<?php echo $category['href']; ?>" class="list-group-item"><?php echo $category['blog_category_name']; ?></a>
  <?php } ?>
</div>
