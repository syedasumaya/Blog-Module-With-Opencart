<?php

class ControllerBlogSingleblog extends Controller {

    public function index() {

        $this->load->language('blog/singleblog');

        $this->load->model('blog/blog');
        $this->load->model('tool/image');


        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );

        $data['breadcrumbs'][] = array(
            'text' => 'Blog',
            'href' => $this->url->link('blog/blog')
        );

        $data['text_related'] = $this->language->get('text_related');
        $data['text_comment'] = $this->language->get('text_comment');
        $data['text_show_comment'] = $this->language->get('text_show_comment');

        $data['text_post_by'] = $this->language->get('text_post_by');
        $data['text_hits'] = $this->language->get('text_hits');
        $data['text_comments'] = $this->language->get('text_comments');
        $data['text_category'] = $this->language->get('text_category');

        $data['text_created_date'] = $this->language->get('text_created_date');
        $data['text_comment_by'] = $this->language->get('text_comment_by');
        $data['text_view_all_comments'] = $this->language->get('text_view_all_comments');
        $data['text_comment_success_msg'] = $this->language->get('text_comment_success_msg');
        $data['text_comment_success_msg1'] = $this->language->get('text_comment_success_msg1');
        $data['text_name'] = $this->language->get('text_name');
        $data['text_name_required'] = $this->language->get('text_name_required');
        $data['text_email'] = $this->language->get('text_email');
        $data['text_email_required'] = $this->language->get('text_email_required');
        $data['text_email_err'] = $this->language->get('text_email_err');
        $data['text_comment'] = $this->language->get('text_comment');
        $data['text_comment_required'] = $this->language->get('text_comment_required').' And your comment need to contain minimum '.$this->config->get('blog_comment_min_character').' character and maximum '.$this->config->get('blog_comment_max_character').' character.' ;
        $data['text_click_recaptcha'] = $this->language->get('text_click_recaptcha');
        $data['text_submit'] = $this->language->get('text_submit');



        if (isset($this->request->get['blog_id'])) {
            $blogId = (int) $this->request->get['blog_id'];
        } else {
            $blogId = 0;
        }
        $result = $this->model_blog_blog->getArticle($blogId);

        if ($result) {
            $data['breadcrumbs'][] = array(
                'text' => $result['blog_title'],
                'href' => $this->url->link('blog/singleblog', 'blog_id=' . $result['blog_id'])
            );

            $data['blog'] = array(
                'blog_id' => $result['blog_id'],
                'blog_title' => $result['blog_title'],
                'blog_description' => html_entity_decode($result['blog_description']),
                'blog_category' => $result['blog_category'],
                'blog_tags' => $result['blog_tags'],
                'blog_hits' => $result['blog_hits'],
                'blog_comments' => $result['blog_comments'],
                'blog_featured' => $result['blog_featured'],
                'blog_seo_keyword' => $result['blog_seo_keyword'],
                'blog_creator' => $result['blog_creator'],
                'blog_created_date' => date($this->config->get('blog_date_format'), strtotime($result['blog_created_date'])),
                'blog_modified_date' => $result['blog_modified_date'],
                'blog_status' => $result['blog_status'],
                'blog_image' => $result['blog_image'],
                'blog_sort_order' => $result['blog_sort_order'],
                'blog_category_id' => $result['blog_category_id'],
                'blog_category_description' => $result['blog_category_description'],
                'blog_category_sort_order' => $result['blog_category_sort_order'],
                'blog_category_seo_keyword' => $result['blog_category_seo_keyword'],
                'blog_category_name' => $result['blog_category_name'],
                'blog_category_status' => $result['blog_category_status'],
                'comment_id' => $result['comment_id'],
                'comment' => $result['comment'],
                'comment_blog_id' => $result['comment_blog_id'],
                'comment_user_id' => $result['comment_user_id'],
                'comment_user_name' => $result['comment_user_name'],
                'comment_user_email' => $result['comment_user_email'],
                'comment_created_date' => $result['comment_created_date'],
                'comment_modified_date' => $result['comment_modified_date'],
                'comment_status' => $result['comment_status'],
                'blog_comment_min_character' => $this->config->get('blog_comment_min_character'),
                'blog_comment_max_character' => $this->config->get('blog_comment_max_character'),
                'blog_creator_name' => $result['username'],
                'blog_total_comment' => $result['total_comment'],
                'href' => $this->url->link('blog/singleblog', 'blog_id=' . $result['blog_id']),
                'twitt_href' => $this->getTinyUrl($this->url->link('blog/singleblog', 'blog_id=' . $result['blog_id'])),
                'category_href' => $this->url->link('blog/singlecategory', 'path=' . $result['blog_category_id'])
            );


            $data['relatedArticles'] = array();
            if ($result['blog_related']) {
                $relatedes = explode(',', $result['blog_related']);
                foreach ($relatedes as $releted) {
                    $result = $this->model_blog_blog->getArticle($releted);
                    if (isset($result) && !empty($result)) {
                        if ($result['blog_image']) {
                            $image = $this->model_tool_image->resize($result['blog_image'], $this->config->get('blog_related_image_width'), $this->config->get('blog_related_image_width'));
                        } else {
                            $image = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_related_width'), $this->config->get($this->config->get('config_theme') . '_image_related_height'));
                        }

                        $data['relatedArticles'][] = array(
                            'blog_id' => $result['blog_id'],
                            'thumb' => $image,
                            'blog_title' => $result['blog_title'],
                            'blog_description' => utf8_substr(strip_tags(html_entity_decode($result['blog_description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('blog_show_description_limit')) . '..',
                            'blog_hits' => $result['blog_hits'],
                            'blog_comments' => $result['blog_comments'],
                            'blog_total_comment' => $result['total_comment'],
                            'blog_creator_name' => $result['username'],
                            'blog_category_name' => $result['blog_category_name'],
                            'blog_created_date' => date("D, F j, Y, g:i a", strtotime($result['blog_created_date'])),
                            'href' => $this->url->link('blog/singleblog', 'blog_id=' . $result['blog_id']),
                            'cathref' => $this->url->link('blog/singlecategory', 'path=' . $result['blog_category_id'])
                        );
                    }
                }
            }

            $data['comments'] = array();
            if ($data['blog']['blog_total_comment'] > 0) {
                $info = array(
                    'start' => 0,
                    'limit' => $this->config->get('blog_show_limits_comments'),
                    'blog_id' => $this->request->get['blog_id']
                );
                $result = $this->model_blog_blog->getComments($info);
                foreach ($result as $value) {

                    $data['comments'][] = array(
                        'comment_id' => $value['comment_id'],
                        'comment' => $value['comment'],
                        'comment_blog_id' => $value['comment_blog_id'],
                        'comment_user_name' => $value['comment_user_name'],
                        'comment_user_email' => $value['comment_user_email'],
                        'comment_created_date' => date("D, F j, Y, g:i a", strtotime($value['comment_created_date'])),
                        'href' => $this->url->link('blog/comments', 'blog_id=' . $this->request->get['blog_id'])
                    );
                }
            }
   
            $data['heading_font'] = $this->config->get('blog_heading_font_size');
            $data['heading_color'] = $this->config->get('blog_heading_color');
            $data['description_font'] = $this->config->get('blog_description_font_size');
            $data['description_color'] = $this->config->get('blog_description_color');
            
            $data['logged'] = $this->customer->isLogged();
            if ($this->customer->isLogged()) {

                $data['customer_firstname'] = $this->customer->getFirstName();
                $data['customer_lastname'] = $this->customer->getLastName();
                $data['customer_email'] = $this->customer->getEmail();
            }

            $data['settings'] = array(
                'show_author' => $this->config->get('blog_show_author'),
                'show_category' => $this->config->get('blog_show_category'),
                'show_created_date' => $this->config->get('blog_show_created_date'),
                'show_hits' => $this->config->get('blog_show_hits'),
                'show_comment_counter' => $this->config->get('blog_show_comment_counter'),
                'show_enable_recaptcha' => $this->config->get('blog_show_enable_recaptcha'),
                'show_auto_publish_comment' => $this->config->get('blog_show_auto_publish_comment'),
                'blog_recaptcha_sitekey' => $this->config->get('blog_recaptcha_sitekey'),
                'blog_recaptcha_secretkey' => $this->config->get('blog_recaptcha_secretkey'),
                'show_limits_comments' => $this->config->get('blog_show_limits_comments'),
                'blog_social_media_share' => $this->config->get('blog_social_media_share')
            );
         
            $data['column_left'] = $this->load->controller('common/column_left');
            $data['column_right'] = $this->load->controller('common/column_right');
            $data['content_top'] = $this->load->controller('common/content_top');
            $data['content_bottom'] = $this->load->controller('common/content_bottom');
            $data['footer'] = $this->load->controller('common/footer');
            $data['header'] = $this->load->controller('common/header');

            $this->response->setOutput($this->load->view('blog/singleblog', $data));
        } else {
            $url = '';

            if (isset($this->request->get['path'])) {
                $url .= '&path=' . $this->request->get['path'];
            }

            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }

            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_error'),
                'href' => $this->url->link('blog/singleblog', $url)
            );

            $this->document->setTitle($this->language->get('text_error'));

            $data['heading_title'] = $this->language->get('text_error');

            $data['text_error'] = $this->language->get('text_error');

            $data['button_continue'] = $this->language->get('button_continue');

            $data['continue'] = $this->url->link('common/home');

            $this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

            $data['column_left'] = $this->load->controller('common/column_left');
            $data['column_right'] = $this->load->controller('common/column_right');
            $data['content_top'] = $this->load->controller('common/content_top');
            $data['content_bottom'] = $this->load->controller('common/content_bottom');
            $data['footer'] = $this->load->controller('common/footer');
            $data['header'] = $this->load->controller('common/header');

            $this->response->setOutput($this->load->view('error/not_found', $data));
        }
    }

    public function getTinyUrl($url) {
        return file_get_contents("http://tinyurl.com/api-create.php?url=".$url);
   }

    public function update_hits() {

        $blog = array();
        $blog['blog_id'] = $this->request->get['blog_id'];
        $blog['blog_hits'] = $this->request->get['blog_hits'];

        $this->load->model('blog/blog');
        $update = $this->model_blog_blog->updateBlogHits($blog);
        if ($update) {
            $json['msg'] = 'success';
        } else {
            $json['msg'] = 'failed';
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function insertComment() {
        //print_r($this->request->post);exit;
        $data = array();
        $data['name'] = $this->request->post['name'];
        $data['email'] = $this->request->post['email'];
        $data['comment'] = $this->request->post['comment'];
        $data['blog_id'] = $this->request->post['blog_id'];
        $data['show_auto_publish_comment'] = $this->request->post['show_auto_publish_comment'];
        $data['customer_id'] = '';

        $this->load->model('blog/blog');
        $checkCustomer = $this->model_blog_blog->checkCustomer($data);
        if ($checkCustomer) {
            $insert = $this->model_blog_blog->insertComment($checkCustomer);
        } else {
            $insert = $this->model_blog_blog->insertComment($data);
        }
        if ($insert) {
            $msg = 'success';
        } else {
            $msg = 'failed';
        }
        return $msg;
    }

    public function postComment() {
        //print_r($this->request->post);exit;
        if ($this->request->post['show_enable_recaptcha'] == 1) {
            if (isset($this->request->post['g-recaptcha-response']) && !empty($this->request->post['g-recaptcha-response'])) {

                $json['msg'] = $this->insertComment();
            } else {
                $json['msg'] = 'error';
            }
        } else {
            $json['msg'] = $this->insertComment();
        }
        //print_r($json);exit;
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

}
