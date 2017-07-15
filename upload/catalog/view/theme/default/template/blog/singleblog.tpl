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
    .social{
        padding-right: 10px;
    }
    .blog-font{
        font-size : 20px !important;
    }
    .articleClass p,.articleClass p span{
        font-size: <?php echo $description_font;?> !important; 
        color: <?php echo $description_color;?> !important;
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
                    <h2 style="font-size: <?php echo $heading_font;?>; color: <?php echo $heading_color;?>;"><?php echo $blog['blog_title'];?></h2>

                    <?php if ($settings['show_author']) { ?>
                    <p class=""><?php echo $text_post_by;?>: <b><?php echo $blog['blog_creator_name']; ?></b>
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
                        <b><?php echo $blog['blog_total_comment']; ?></b>&nbsp;<?php echo $text_comments?>
                        <?php if ($settings['show_category']) { ?>
                        |
                        <?php }?>
                        <?php } ?>

                        <?php if ($settings['show_category']) { ?>
                        <?php echo $text_category;?>:&nbsp;<b><a href="<?php echo $blog['category_href']?>"><?php echo $blog['blog_category_name']; ?></a></b>           
                    </p>
                    <?php } ?>
                    <?php $articleClass = 'articleClass'?>
                    <div class = "articleClass">  
                        <p><?php echo html_entity_decode($blog['blog_description'])?></p>
                    </div>
                    <?php } ?>

                </div>
            </div>

            <!----------------------------social media share start--------------------------------------->
            <?php if($settings['blog_social_media_share']) { ?>
            <div class="row">
                <?php if ($column_left && $column_right) { ?>
                <?php $class = 'col-sm-6'; ?>
                <?php } elseif ($column_left || $column_right) { ?>
                <?php $class = 'col-sm-9'; ?>
                <?php } else { ?>
                <?php $class = 'col-sm-12'; ?>
                <?php } ?>
                <div class="<?php echo $class; ?>">
                    <table class="pull-right">
                        <tr> 
                            <td class="social">Share on:</td>
                            <td class="social">
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $blog['href']; ?>" target="_blank" class="fb">
                                    <i class="fa fa-facebook-official blog-font" aria-hidden="true"></i>
                                </a>
                            </td>
                            <td class="social">
                                <a href="https://twitter.com/intent/tweet?text=<?php echo $blog['blog_title']?>&url=<?php echo $blog['twitt_href']; ?>" target="_blank">
                                    <i class="fa fa-twitter-square blog-font" aria-hidden="true"></i>
                                </a>

                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <?php } ?>
            <!----------------------------social media share end--------------------------------------->


            <!----------------------------related articles--------------------------------------------------->
            <?php if ($relatedArticles) { ?>
            <h3><?php echo $text_related; ?></h3>
            <div class="row">        
                <?php foreach ($relatedArticles as $article) { ?>
                <?php if ($column_left && $column_right) { ?>
                <?php $class = 'col-lg-6 col-md-6 col-sm-12 col-xs-12'; ?>
                <?php } elseif ($column_left || $column_right) { ?>
                <?php $class = 'col-lg-4 col-md-4 col-sm-6 col-xs-12'; ?>
                <?php } else { ?>
                <?php $class = 'col-lg-3 col-md-3 col-sm-6 col-xs-12'; ?>
                <?php } ?>
                <div class="<?php echo $class; ?>">
                    <div class="product-thumb transition">
                        <div class="image"><a href="<?php echo $article['href']; ?>"><img src="<?php echo $article['thumb']; ?>" alt="<?php echo $article['blog_title']; ?>" title="<?php echo $article['blog_title']; ?>" class="img-responsive" /></a></div>
                        <div class="caption">
                            <h4><a href="<?php echo $article['href']; ?>"><?php echo $article['blog_title']; ?></a></h4>
                            <p><?php echo $article['blog_description']; ?></p>
                            <?php if ((($settings['show_author']) || ($settings['show_hits']) || ($settings['show_comment_counter']) || ($settings['show_category']) || ($settings['show_created_date']))) { ?>                            
                            <div class="rating">

                                <?php  if($settings['show_created_date']){ ?>
                                <span><?php echo $text_created_date?>: <b><?php echo $article['blog_created_date']?></b>
                                    <?php 
                                    if ((($settings['show_author']) || ($settings['show_hits']) || ($settings['show_comment_counter']) || ($settings['show_category']))) {
                                    echo '|';
                                    }
                                    ?>
                                </span>
                                <?php  } ?>

                                <?php  if ($settings['show_author']) { ?>
                                <span><?php echo $text_post_by;?>: <b><?php echo $article['blog_creator_name']?></b>
                                    <?php 
                                    if ((($settings['show_hits']) || ($settings['show_comment_counter']) || ($settings['show_category']))) {
                                    echo '|';
                                    }
                                    ?>
                                </span>
                                <?php  } ?>

                                <?php  if ($settings['show_hits']) { ?>
                                <span><b><?php echo $article['blog_hits']?> <?php echo $text_hits;?></b>
                                    <?php 
                                    if ((($settings['show_comment_counter']) || ($settings['show_category']))) {
                                    echo '|';
                                    }
                                    ?>
                                </span>
                                <?php  } ?>

                                <?php  if ($settings['show_comment_counter']) { ?>
                                <span><b><?php echo $article['blog_total_comment']?> <?php echo $text_comments;?></b>
                                    <?php 
                                    if ($settings['show_category']) {
                                    echo '|';
                                    }
                                    ?>
                                </span>
                                <?php  } ?>

                                <?php  if ($settings['show_category']) { ?>
                                <span><?php echo $text_category;?>: <b><a href="<?php echo $article['cathref'];?>"><?php echo $article['blog_category_name']?></a></b>

                                </span>
                                <?php  } ?>

                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <?php } ?>
            <!----------------related articles-------------------->  

            <!-----------------Show Comment Start------------------------------------------------------>
            <?php if ($blog['blog_total_comment']>0) { ?>
            <h3><?php echo $text_show_comment;?>&nbsp;&nbsp;&nbsp;<b>(<?php echo $blog['blog_total_comment'];?>)</b></h3>
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
                            <p><?php echo $text_comment_by;?> <b><?php echo $comment['comment_user_name'];?></b>&nbsp;|&nbsp;
                                <?php echo $comment['comment_created_date'];?>
                            </p>
                            <p><?php echo $comment['comment'];?></p>
                        </span><br>
                        <?php } ?>
                        <?php if ($blog['blog_total_comment'] > count($comments)) { ?>
                        <a href="<?php echo $comment['href'];?>" class="btn btn-primary pull-right btn-text"><?php echo $text_view_all_comments;?></a>
                        <?php } ?>
                    </div>
                </div>
            </div> 
            <?php }?>
            <!-----------------Show Comment End------------------------------------------------------>

            <!-----------------Post Comment Start------------------------------------------------------>

            <h3><?php echo $text_comment;?></h3>
            <p class="succ_msg" style="color:green"><?php echo $text_comment_success_msg;?></p>
            <p class="succ_msg1" style="color:green"><?php echo $text_comment_success_msg1;?></p>
            <div class="row">  

                <?php if ($column_left && $column_right) { ?>
                <?php $class = 'col-lg-6 col-md-6 col-sm-12 col-xs-12'; ?>
                <?php } elseif ($column_left || $column_right) { ?>
                <?php $class = 'col-lg-4 col-md-4 col-sm-6 col-xs-12'; ?>
                <?php } else { ?>
                <?php $class = 'col-lg-3 col-md-3 col-sm-6 col-xs-12'; ?>
                <?php } ?>
                <div class="<?php echo $class; ?>">
                    <form class="commmentform" method="post">
                        <div class="form-group">
                            <label for="exampleInputEmail1"><?php echo $text_name;?><span style='color:red'>*</span></label>
                            <?php if($logged) { ?>
                            <input type="text" name="name" value="<?php echo $customer_firstname.' '.$customer_lastname?>" class="form-control" id="name" placeholder="<?php echo $text_name;?>" readonly>
                            <?php } else{ ?>
                            <input type="text" name="name" class="form-control" id="name" placeholder="<?php echo $text_name;?>">

                            <?php }?>
                            <span class="nameerr" style="color:red"><?php echo $text_name_required;?></span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1"><?php echo $text_email;?><span style='color:red'>*</span></label>
                            <?php if($logged) { ?>
                            <input type="email" name="email" value="<?php echo $customer_email?>" class="form-control" id="email" placeholder="<?php echo $text_email;?>" readonly>
                            <?php } else{ ?>
                            <input type="email" name="email" class="form-control" id="email" placeholder="<?php echo $text_email;?>">
                            <?php } ?>
                            <span class="emailerr" style="color:red"><?php echo $text_email_required;?></span>
                            <span class="emailformaterr" style="color:red"><?php echo $text_email_err;?></span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1"><?php echo $text_comment;?><span style='color:red'>*</span></label>
                            <textarea name="comment" rows="5" class="form-control" id="comment"></textarea>
                            <span class="commenterr" style="color:red"><?php echo $text_comment_required;?></span>
                        </div>
                        <input type="hidden" name="blog_id" value="<?php echo $blog['blog_id']?>">
                        <input type="hidden" name="show_enable_recaptcha" value="<?php echo $settings['show_enable_recaptcha']?>">
                        <input type="hidden" name="show_auto_publish_comment" value="<?php echo $settings['show_auto_publish_comment']?>">
                        <?php if($settings['show_enable_recaptcha']) { ?>
                        <div class="g-recaptcha" data-sitekey="<?php echo $settings['blog_recaptcha_sitekey']?>"></div><br>
                        <span class="captcha-box" style="color:red"><?php echo $text_click_recaptcha;?></span>
                        <?php } ?>
                        <button type="button" class="btn btn-default commentbtn"><?php echo $text_submit;?></button>
                    </form>

                    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                </div>
            </div>
            <!-----------------Post Comment End------------------------------------------------------>
            <?php echo $content_bottom; ?></div>

        <?php echo $column_right; ?></div>

</div>

<script type="text/javascript">
    $(document).ready(function () {

        var blog_id = "<?php echo $blog['blog_id']?>";
        var blog_hits = "<?php echo $blog['blog_hits']?>";

        $.ajax({
            url: 'index.php?route=blog/singleblog/update_hits&blog_hits=' + blog_hits + '&blog_id=' + blog_id,
            dataType: 'json',
            success: function (result) {

            },
            error: function (xhr, ajaxOptions, thrownError) {

            }
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('.nameerr').hide();
        $('.emailerr').hide();
        $('.commenterr').hide();
        $('.emailformaterr').hide();
        $('.succ_msg').hide();
        $('.succ_msg1').hide();
        $('.captcha-box').hide();
        function validateEmail($email) {
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            return emailReg.test($email);
        }
        function checkCommentWord(comment){ 
        var min = "<?php echo $blog['blog_comment_min_character']?>"; 
        var max = "<?php echo $blog['blog_comment_max_character']?>"; 
        if(comment.length < min || comment.length > max ){
            return false;
        } else {
           return true;
        }
    }

        $('.commentbtn').click(function () {
            var name = $('#name').val();
            var email = $('#email').val();
            var comment = $('#comment').val();
            var checkComment =  checkCommentWord(comment);
            if (name == '' || email == '' || comment == '' || checkComment == false) {
                if ((name == '') && (email != '' && comment != '' && checkComment != false)) {
                    $('.nameerr').show();
                    $('.emailerr').hide();
                    $('.commenterr').hide();
                }
                if ((email == '') && (name != '' && comment != '' && checkComment != false)) {
                    $('.nameerr').hide();
                    $('.emailerr').show();
                    $('.commenterr').hide();
                }
                if ((checkComment == false) && (name != '' && email != '' && comment != '')) {
                    $('.nameerr').hide();
                    $('.emailerr').hide();
                    $('.commenterr').show();
                }
                if ((comment == '') && (name != '' && email != '')) {
                    $('.nameerr').hide();
                    $('.emailerr').hide();
                    $('.commenterr').show();
                }
                if (comment == '' && name == '' && email == '') {
                    $('.nameerr').show();
                    $('.emailerr').show();
                    $('.commenterr').show();
                }
            } else {
                if (validateEmail(email)) {
                    $('.emailformaterr').hide();
                    var form = $('.commmentform').serialize();
                    console.log(form);

                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: 'index.php?route=blog/singleblog/postComment',
                        data: form,
                        success: function (json) {

                            if (json.msg == 'success') {
                                var comment = "<?php echo $settings['show_auto_publish_comment']?>";
                                
                                $('.captcha-box').hide();
                                if (comment == 0) {
                                    $('.succ_msg1').show();
                                } else {
                                    $('.succ_msg').show();
                                }

                                $('.nameerr').hide();
                                $('.emailerr').hide();
                                $('.commenterr').hide();

                            }
                            if (json.msg == 'error') {
                                $('.captcha-box').show();
                                $('.succ_msg').hide();
                            }
                        }
                    });
                } else {
                    $('.emailformaterr').show();
                }
            }
        });

    });
</script>

<?php echo $footer; ?>

