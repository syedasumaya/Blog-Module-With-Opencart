<?php

class ControllerBlogSinglecategory extends Controller {

    public function index() {
        $this->load->language('blog/singlecategory');

        $this->load->model('blog/blog');

        $this->load->model('blog/categories');

        $this->load->model('tool/image');

        if (isset($this->request->get['filter'])) {
            $filter = $this->request->get['filter'];
        } else {
            $filter = '';
        }

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'b.blog_created_date';
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'DESC';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        if (isset($this->request->get['limit'])) {
            $limit = (int) $this->request->get['limit'];
        } else {
            $limit = $this->config->get('blog_show_articles_under_category');
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );

        if (isset($this->request->get['path'])) {
            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }

            $categoryId = $this->request->get['path'];
            $categoryInfo = $this->model_blog_categories->getCategory($categoryId);

            if ($categoryInfo) {
                $data['breadcrumbs'][] = array(
                    'text' => $categoryInfo['blog_category_name'],
                    'href' => $this->url->link('blog/singlecategory', 'path=' . $categoryId . $url)
                );
            }
        } else {
            $categoryId = 0;
        }

        $categoryInfo = $this->model_blog_categories->getCategory($categoryId);

        if ($categoryInfo) {

            $this->document->setKeywords($categoryInfo['blog_category_seo_keyword']);

            $data['heading_title'] = $categoryInfo['blog_category_name'];
            $data['text_refine'] = $this->language->get('text_refine');
            $data['text_empty'] = $this->language->get('text_empty');
            $data['text_quantity'] = $this->language->get('text_quantity');
            $data['text_manufacturer'] = $this->language->get('text_manufacturer');
            $data['text_model'] = $this->language->get('text_model');
            $data['text_price'] = $this->language->get('text_price');
            $data['text_tax'] = $this->language->get('text_tax');
            $data['text_points'] = $this->language->get('text_points');
            $data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
            $data['text_sort'] = $this->language->get('text_sort');
            $data['text_limit'] = $this->language->get('text_limit');
            $data['text_category'] = $this->language->get('text_category');
            $data['text_readmore'] = $this->language->get('text_readmore');

            $data['button_cart'] = $this->language->get('button_cart');
            $data['button_wishlist'] = $this->language->get('button_wishlist');
            $data['button_compare'] = $this->language->get('button_compare');
            $data['button_continue'] = $this->language->get('button_continue');
            $data['button_list'] = $this->language->get('button_list');
            $data['button_grid'] = $this->language->get('button_grid');

            $data['description'] = html_entity_decode($categoryInfo['blog_category_description'], ENT_QUOTES, 'UTF-8');


            $url = '';

            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }

            $data['products'] = array();

            $filter_data = array(
                'category_id' => $categoryId,
                'start_date' => '',
                'filter_filter' => $filter,
                'sort' => $sort,
                'order' => $order,
                'start' => ($page - 1) * $limit,
                'limit' => $limit
            );

            $blogTotal = $this->model_blog_blog->getTotalBlogs($filter_data);

            $results = $this->model_blog_blog->getArticles($filter_data);

            foreach ($results as $result) {
                if ($result['blog_image']) {
                    $image = $this->model_tool_image->resize($result['blog_image'], $this->config->get('blog_small_image_width'), $this->config->get('blog_small_image_height'));
                } else {
                    $image = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
                }

                $data['blog_info'][] = array(
                    'blog_id' => $result['blog_id'],
                    'thumb' => $image,
                    'blog_title' => $result['blog_title'],
                    'blog_hits' => $result['blog_hits'],
                    'blog_category' => $categoryInfo['blog_category_name'],
                    'blog_creator' => $this->model_blog_blog->getUser($result['blog_creator']),
                    'blog_total_comment' => $this->model_blog_blog->getTotalComment($result['blog_id']),
                    'blog_created_date' => date($this->config->get('blog_date_format'), strtotime($result['blog_created_date'])),
                    'blog_description' => utf8_substr(strip_tags(html_entity_decode($result['blog_description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('blog_show_description_limit')) . '..',
                    'show_title' => $this->config->get('blog_show_title'),
                    'show_description' => $this->config->get('blog_show_description'),
                    'show_readmore' => $this->config->get('blog_show_readmore'),
                    'show_image' => $this->config->get('blog_show_image'),
                    'show_image' => $this->config->get('blog_show_image'),
                    'show_author' => $this->config->get('blog_show_author'),
                    'show_category' => $this->config->get('blog_show_category'),
                    'show_created_date' => $this->config->get('blog_show_created_date'),
                    'show_hits' => $this->config->get('blog_show_hits'),
                    'show_comment_counter' => $this->config->get('blog_show_comment_counter'),
                    'href' => $this->url->link('blog/singleblog', 'blog_id=' . $result['blog_id'])
                );
            }

            $url = '';

            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }

            $data['sorts'] = array();

            $data['sorts'][] = array(
                'text' => $this->language->get('text_default'),
                'value' => 'b.blog_created_date-DESC',
                'href' => $this->url->link('blog/singlecategory', 'path=' . $categoryId . '&sort=b.blog_created_date&order=DESC' . $url)
            );
            $data['sorts'][] = array(
                'text' => $this->language->get('text_created_date_asc'),
                'value' => 'b.blog_created_date-ASC',
                'href' => $this->url->link('blog/singlecategory', 'path=' . $categoryId . '&sort=b.blog_created_date&order=ASC' . $url)
            );
            $data['sorts'][] = array(
                'text' => $this->language->get('text_name_asc'),
                'value' => 'b.blog_title-ASC',
                'href' => $this->url->link('blog/singlecategory', 'path=' . $categoryId . '&sort=b.blog_title&order=ASC' . $url)
            );

            $data['sorts'][] = array(
                'text' => $this->language->get('text_name_desc'),
                'value' => 'b.blog_title-DESC',
                'href' => $this->url->link('blog/singlecategory', 'path=' . $categoryId . '&sort=b.blog_title&order=DESC' . $url)
            );

            $data['sorts'][] = array(
                'text' => $this->language->get('text_comment_desc'),
                'value' => 'b.blog_comments-DESC',
                'href' => $this->url->link('blog/singlecategory', 'path=' . $categoryId . '&sort=b.blog_comments&order=DESC' . $url)
            );
            $data['sorts'][] = array(
                'text' => $this->language->get('text_comment_asc'),
                'value' => 'b.blog_comments-ASC',
                'href' => $this->url->link('blog/singlecategory', 'path=' . $categoryId . '&sort=b.blog_comments&order=ASC' . $url)
            );
            $data['sorts'][] = array(
                'text' => $this->language->get('text_visit_asc'),
                'value' => 'b.blog_hits-ASC',
                'href' => $this->url->link('blog/singlecategory', 'path=' . $categoryId . '&sort=b.blog_hits&order=ASC' . $url)
            );
            $data['sorts'][] = array(
                'text' => $this->language->get('text_visit_desc'),
                'value' => 'b.blog_hits-DESC',
                'href' => $this->url->link('blog/singlecategory', 'path=' . $categoryId . '&sort=b.blog_hits&order=DESC' . $url)
            );


            $url = '';

            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            $data['limits'] = array();

            $limits = array_unique(array($this->config->get('blog_limit'), 25, 50, 75, 100));

            sort($limits);

            foreach ($limits as $value) {
                $data['limits'][] = array(
                    'text' => $value,
                    'value' => $value,
                    'href' => $this->url->link('blog/singlecategory', 'path=' . $categoryId . $url . '&limit=' . $value)
                );
            }

            $url = '';

            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }

            $pagination = new Pagination();
            $pagination->total = $blogTotal;
            $pagination->page = $page;
            $pagination->limit = $limit;
            $pagination->url = $this->url->link('blog/singlecategory', 'path=' . $this->request->get['path'] . $url . '&page={page}');

            $data['pagination'] = $pagination->render();

            $data['results'] = sprintf($this->language->get('text_pagination'), ($blogTotal) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($blogTotal - $limit)) ? $blogTotal : ((($page - 1) * $limit) + $limit), $blogTotal, ceil($blogTotal / $limit));

            // http://googlewebmastercentral.blogspot.com/2011/09/pagination-with-relnext-and-relprev.html
            if ($page == 1) {
                $this->document->addLink($this->url->link('blog/singlecategory', 'path=' . $categoryInfo['blog_category_id'], true), 'canonical');
            } elseif ($page == 2) {
                $this->document->addLink($this->url->link('blog/singlecategory', 'path=' . $categoryInfo['blog_category_id'], true), 'prev');
            } else {
                $this->document->addLink($this->url->link('blog/singlecategory', 'path=' . $categoryInfo['blog_category_id'] . '&page=' . ($page - 1), true), 'prev');
            }

            if ($limit && ceil($blogTotal / $limit) > $page) {
                $this->document->addLink($this->url->link('blog/singlecategory', 'path=' . $categoryInfo['blog_category_id'] . '&page=' . ($page + 1), true), 'next');
            }

            $data['sort'] = $sort;
            $data['order'] = $order;
            $data['limit'] = $limit;

            $data['continue'] = $this->url->link('common/home');

            $data['column_left'] = $this->load->controller('common/column_left');
            $data['column_right'] = $this->load->controller('common/column_right');
            $data['content_top'] = $this->load->controller('common/content_top');
            $data['content_bottom'] = $this->load->controller('common/content_bottom');
            $data['footer'] = $this->load->controller('common/footer');
            $data['header'] = $this->load->controller('common/header');

            $this->response->setOutput($this->load->view('blog/singlecategory', $data));
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
                'href' => $this->url->link('product/category', $url)
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

}
