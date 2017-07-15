<?php

class ControllerBlogCategories extends Controller {

    public function index() {

        $this->load->language('blog/categories');

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
            $sort = 'blog_category_name';
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'ASC';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        if (isset($this->request->get['limit'])) {
            $limit = (int) $this->request->get['limit'];
        } else {
            $limit = $this->config->get('blog_show_category_limit');
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );


        $filter_data = array(
            'filter_filter' => $filter,
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $limit,
            'limit' => $limit
        );

        $categoryTotal = $this->model_blog_categories->getTotalCategories($filter_data);
        $results = $this->model_blog_categories->getCategories($filter_data);

        $data['text_sort'] = $this->language->get('text_sort');
        $data['text_limit'] = $this->language->get('text_limit');
        $data['text_empty'] = $this->language->get('text_empty');

        $data['text_category'] = $this->language->get('text_category');
        $data['text_readmore'] = $this->language->get('text_readmore');
        $data['text_comments'] = $this->language->get('text_comments');
        $data['text_hits'] = $this->language->get('text_hits');

        $data['button_cart'] = $this->language->get('button_cart');
        $data['button_wishlist'] = $this->language->get('button_wishlist');
        $data['button_compare'] = $this->language->get('button_compare');
        $data['button_continue'] = $this->language->get('button_continue');
        $data['button_list'] = $this->language->get('button_list');
        $data['button_grid'] = $this->language->get('button_grid');

        $data['breadcrumbs'][] = array(
            'text' => 'Categories',
            'href' => $this->url->link('blog/categories')
        );

        foreach ($results as $result) {

            $data['category_info'][] = array(
                'blog_category_id' => $result['blog_category_id'],
                'blog_category_name' => $result['blog_category_name'],
                'blog_category_description' => utf8_substr(strip_tags(html_entity_decode($result['blog_category_description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('blog_show_category_description_limit')) . '..',
                'show_readmore' => $this->config->get('blog_show_readmore'),
                'href' => $this->url->link('blog/singlecategory', 'path=' . $result['blog_category_id'])
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
            'value' => 'blog_category_name-ASC',
            'href' => $this->url->link('blog/categories', '&sort=blog_category_name&order=ASC' . $url)
        );
        $data['sorts'][] = array(
            'text' => $this->language->get('text_category_name_desc'),
            'value' => 'blog_category_name-DESC',
            'href' => $this->url->link('blog/categories', '&sort=blog_category_name&order=DESC' . $url)
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

        $limits = array_unique(array($this->config->get('blog_show_category_limit'), 25, 50, 75, 100));

        sort($limits);

        foreach ($limits as $value) {
            $data['limits'][] = array(
                'text' => $value,
                'value' => $value,
                'href' => $this->url->link('blog/categories', $url . '&limit=' . $value)
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
        $pagination->total = $categoryTotal;
        $pagination->page = $page;
        $pagination->limit = $limit;
        $pagination->url = $this->url->link('blog/categories', $url . '&page={page}');

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($categoryTotal) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($categoryTotal - $limit)) ? $categoryTotal : ((($page - 1) * $limit) + $limit), $categoryTotal, ceil($categoryTotal / $limit));

        $data['sort'] = $sort;
        $data['order'] = $order;
        $data['limit'] = $limit;
        $data['route'] = $this->request->get['route'];

        $data['continue'] = $this->url->link('common/home');

        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');

        $this->response->setOutput($this->load->view('blog/categories', $data));
    }

}
