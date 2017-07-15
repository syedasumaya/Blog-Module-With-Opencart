<style>
    .archive{
        height : 206px;
        overflow-y: auto;
    }
    .blog-list-group a{
        border: none !important; 
    }
</style>
<div class="list-group blog-list-group">
    <a class="list-group-item active"><b><?php echo $heading_title;?></b></a>  
    <div class="archive">
        <?php 
        $thisYear = date("Y");
        for ($x = 0; $x <= $limit-1; $x++) {
        for ($m=1; $m<=12; $m++) {
        $month = date('F , Y', mktime(0,0,0,$m, 1, $thisYear-$x));?>
        <span class="list-group-item">
            <a href="<?php echo $mainhref?>&month=<?php echo $m?>&year=<?php echo $thisYear-$x?>"><?php echo $month;?></a>
        </span>
        <?php  }
        }
        ?>
    </div>
</div>    
