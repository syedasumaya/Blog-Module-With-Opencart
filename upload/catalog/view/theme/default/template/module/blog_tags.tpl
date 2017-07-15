<style>
    .blog-list-group a{
        border: none !important; 
    }
</style>

<div class="list-group blog-list-group">
    <a class="list-group-item active"><b><?php echo $heading_title;?></b></a>  
    <div class="list-group-item">
        <?php $new = array();
        foreach ($tags as $key=>$tag) {
        $s = $tag['large_font']; 
        $i = 0;
        shuffle($tag['blog_tags']);  
        $arrlength = sizeof($tag['blog_tags']);
		
        foreach($tag['blog_tags'] as $k=>$t){ 
        
        ?>
        <?php if($k == $arrlength-1){
              $s = $tag['small_font'];
        }
        ?>
        <?php if (!in_array($t,$new)) { ?>
        <a href="<?php echo $tag['href']?>" style="font-size: <?php echo $s;?>px !important;"><?php echo $t; ?></a>
        <?php } ?>
        <?php  if($i == $tag['limit']){
               break;
        }?>
        <?php $i++; 

        $s = $tag['large_font']-$tag['small_font']

        ?>
        <?php  $new[] = $t; } 
		
		} //echo '<pre>';print_r($new);?>
    </div>  
</div>
