<?php

class ControllerBlogComments extends Controller {

    public function index() {

        $this->load->language('blog/blog');

        $this->load->model('blog/blog');
        $this->load->model('tool/image');

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        if (isset($this->request->get['limit'])) {
            $limit = (int) $this->request->get['limit'];
        } else {
            $limit = $this->config->get('blog_show_limits_comments');
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );

        $data['breadcrumbs'][] = array(
            'text' => 'Blog',
            'href' => $this->url->link('blog/blog')
        );

        $data['text_hits'] = $this->language->get('text_hits');

        $data['text_comments'] = $this->language->get('text_comments');
        $data['text_readmore'] = $this->language->get('text_readmore');
        $data['text_hide'] = $this->language->get('text_hide');

        $data['text_related'] = $this->language->get('text_related');
        $data['text_comment'] = $this->language->get('text_comment');
        $data['text_show_comment'] = $this->language->get('text_show_comment');

        if (isset($this->request->get['blog_id'])) {
            $blog_id = (int) $this->request->get['blog_id'];
        } else {
            $blog_id = 0;
        }


        $info = array(
            'start' => ($page - 1) * $limit,
            'limit' => $limit,
            'blog_id' => $this->request->get['blog_id']
        );


        $commentTotal = $this->model_blog_blog->getTotalComment($this->request->get['blog_id']);

        $result = $this->model_blog_blog->getComments($info);
        if ($result) {
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
            $article = $this->model_blog_blog->getArticle($this->request->get['blog_id']);

            $data['blog'] = array(
                'blog_id' => $article['blog_id'],
                'blog_title' => $article['blog_title'],
                'blog_long_description' => html_entity_decode($article['blog_description']),
                'blog_description' => utf8_substr(strip_tags(html_entity_decode($article['blog_description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('blog_show_description_limit')) . '.....',
                'blog_category' => $article['blog_category'],
                'blog_tags' => $article['blog_tags'],
                'blog_hits' => $article['blog_hits'],
                'blog_comments' => $article['blog_comments'],
                'blog_featured' => $article['blog_featured'],
                'blog_seo_keyword' => $article['blog_seo_keyword'],
                'blog_creator' => $article['blog_creator'],
                'blog_created_date' => date("D, F j, Y, g:i a", strtotime($article['blog_created_date'])),
                'blog_modified_date' => $article['blog_modified_date'],
                'blog_status' => $article['blog_status'],
                'blog_image' => $article['blog_image'],
                'blog_sort_order' => $article['blog_sort_order'],
                'blog_category_id' => $article['blog_category_id'],
                'blog_category_description' => $article['blog_category_description'],
                'blog_category_sort_order' => $article['blog_category_sort_order'],
                'blog_category_seo_keyword' => $article['blog_category_seo_keyword'],
                'blog_category_name' => $article['blog_category_name'],
                'blog_category_status' => $article['blog_category_status'],
                'comment_id' => $article['comment_id'],
                'comment' => $article['comment'],
                'comment_blog_id' => $article['comment_blog_id'],
                'comment_user_id' => $article['comment_user_id'],
                'comment_user_name' => $article['comment_user_name'],
                'comment_user_email' => $article['comment_user_email'],
                'comment_created_date' => $article['comment_created_date'],
                'comment_modified_date' => $article['comment_modified_date'],
                'comment_status' => $article['comment_status'],
                'blog_creator_name' => $article['username'],
                'blog_total_comment' => $article['total_comment'],
            );

            $data['breadcrumbs'][] = array(
                'text' => $article['blog_title'],
                'href' => $this->url->link('blog/singleblog', 'blog_id=' . $this->request->get['blog_id'])
            );

            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_show_comment'),
                'href' => $this->url->link('blog/comments', 'blog_id=' . $this->request->get['blog_id'])
            );

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
                'show_limits_comments' => $this->config->get('blog_show_limits_comments')
            );

            $url = '';
            if (isset($this->request->get['blog_id'])) {
                $url .= '&blog_id=' . $this->request->get['blog_id'];
            }
            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }

            $pagination = new Pagination();
            $pagination->total = $commentTotal;
            $pagination->page = $page;
            $pagination->limit = $limit;
            $pagination->url = $this->url->link('blog/comments', $url . '&page={page}');

            $data['pagination'] = $pagination->render();

            $data['results'] = sprintf($this->language->get('text_pagination'), ($commentTotal) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($commentTotal - $limit)) ? $commentTotal : ((($page - 1) * $limit) + $limit), $commentTotal, ceil($commentTotal / $limit));
            $data['total_comment'] = $commentTotal;

            $data['column_left'] = $this->load->controller('common/column_left');
            $data['column_right'] = $this->load->controller('common/column_right');
            $data['content_top'] = $this->load->controller('common/content_top');
            $data['content_bottom'] = $this->load->controller('common/content_bottom');
            $data['footer'] = $this->load->controller('common/footer');
            $data['header'] = $this->load->controller('common/header');

            $this->response->setOutput($this->load->view('blog/comments', $data));
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

            $data['text_hits'] = $this->language->get('text_hits');

            $data['text_comments'] = $this->language->get('text_comments');
            $data['text_readmore'] = $this->language->get('text_readmore');
            $data['text_hide'] = $this->language->get('text_hide');

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

}
