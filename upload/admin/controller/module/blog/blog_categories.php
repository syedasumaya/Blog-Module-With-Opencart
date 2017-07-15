<?php

class ControllerModuleBlogBlogCategories extends Controller {

    private $error = array();

    public function index() {

        if (isset($this->request->get['filter_name'])) {
            $filter_name = $this->request->get['filter_name'];
        } else {
            $filter_name = null;
        }

        if (isset($this->request->get['filter_status'])) {
            $filter_status = $this->request->get['filter_status'];
        } else {
            $filter_status = null;
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

        $url = '';

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_status'])) {
            $url .= '&filter_status=' . $this->request->get['filter_status'];
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

        $this->load->language('module/blog');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');
        $this->load->model('blog/blog');

        $data['blog_dashboard'] = $this->language->get('blog_dashboard');
        $data['blog_categories'] = $this->language->get('blog_categories');
        $data['blog_articles'] = $this->language->get('blog_articles');
        $data['blog_comments'] = $this->language->get('blog_comments');
        $data['blog_settings'] = $this->language->get('blog_settings');

        $data['blog_name'] = $this->language->get('blog_name');
        $data['seo_key'] = $this->language->get('seo_key');
        $data['show_title'] = $this->language->get('show_title');
        $data['show_description'] = $this->language->get('show_description');
        $data['show_readmore'] = $this->language->get('show_readmore');
        $data['show_image'] = $this->language->get('show_image');
        $data['show_author'] = $this->language->get('show_author');
        $data['show_category'] = $this->language->get('show_category');
        $data['show_created_date'] = $this->language->get('show_created_date');
        $data['show_hits'] = $this->language->get('show_hits');
        $data['show_comment_counter'] = $this->language->get('show_comment_counter');
        $data['show_description_limit'] = $this->language->get('show_description_limit');
        $data['show_limits_comments'] = $this->language->get('show_limits_comments');
        $data['show_auto_publish_comment'] = $this->language->get('show_auto_publish_comment');
        $data['show_enable_recaptcha'] = $this->language->get('show_enable_recaptcha');

        $data['blog_large_image'] = $this->language->get('blog_large_image');
        $data['blog_small_image'] = $this->language->get('blog_small_image');

        $data['heading_title'] = $this->language->get('heading_title');

        $data['heading_categories'] = $this->language->get('heading_categories');

        $data['tab_general'] = $this->language->get('tab_general');
        $data['tab_option'] = $this->language->get('tab_option');
        $data['tab_image'] = $this->language->get('tab_image');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');

        $data['text_status'] = $this->language->get('text_status');
        $data['text_category_name'] = $this->language->get('text_category_name');
        $data['text_sort_order'] = $this->language->get('text_sort_order');
        $data['text_action'] = $this->language->get('text_action');
        $data['text_add_new_category'] = $this->language->get('text_add_new_category');
        $data['text_delete_category'] = $this->language->get('text_delete_category');

        $data['text_filter'] = $this->language->get('text_filter');

        $data['entry_status'] = $this->language->get('entry_status');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        if (isset($this->request->post['selected'])) {
            $data['selected'] = (array) $this->request->post['selected'];
        } else {
            $data['selected'] = array();
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('module/blog', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('blog_categories'),
            'href' => $this->url->link('module/blog/blog_categories', 'token=' . $this->session->data['token'], true)
        );

        $filter_data = array(
            'filter_name' => $filter_name,
            'filter_status' => $filter_status,
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit' => $this->config->get('config_limit_admin')
        );

        $categoryTotal = $this->model_blog_blog->getTotalCategory($filter_data);

        $results = $this->model_blog_blog->getAllCategories($filter_data);
        
        foreach ($results as $result) {

            $data['all_categories'][] = array(
                'category_id' => $result['blog_category_id'],
                'category_description' => $result['blog_category_description'],
                'category_sort_order' => $result['blog_category_sort_order'],
                'category_seo_keyword' => $result['blog_category_seo_keyword'],
                'category_name' => $result['blog_category_name'],
                'category_status' => $result['blog_category_status'],
                'edit' => $this->url->link('module/blog/blog_categories/edit', 'token=' . $this->session->data['token'] . '&category_id=' . $result['blog_category_id'], true)
            );
        }

        $url = '';

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_status'])) {
            $url .= '&filter_status=' . $this->request->get['filter_status'];
        }
        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }
        $data['sort_title'] = $this->url->link('module/blog/blog_categories', 'token=' . $this->session->data['token'] . '&sort=blog_category_name' . $url, true);
        $data['sort_order'] = $this->url->link('module/blog/blog_categories', 'token=' . $this->session->data['token'] . '&sort=blog_category_sort_order' . $url, true);
        $data['sort_status'] = $this->url->link('module/blog/blog_categories', 'token=' . $this->session->data['token'] . '&sort=blog_category_status' . $url, true);

        $url = '';

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }


        if (isset($this->request->get['filter_status'])) {
            $url .= '&filter_status=' . $this->request->get['filter_status'];
        }
        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }


        $pagination = new Pagination();
        $pagination->total = $categoryTotal;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->url->link('module/blog/blog_categories', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($categoryTotal) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($categoryTotal - $this->config->get('config_limit_admin'))) ? $categoryTotal : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $categoryTotal, ceil($categoryTotal / $this->config->get('config_limit_admin')));

        $data['filter_name'] = $filter_name;
        $data['filter_status'] = $filter_status;
        $data['sort'] = $sort;
        $data['order'] = $order;
        $data['token'] = $this->session->data['token'];


        $data['add'] = $this->url->link('module/blog/blog_categories/add', 'token=' . $this->session->data['token'], true);
        $data['delete'] = $this->url->link('module/blog/blog_categories/delete', 'token=' . $this->session->data['token'], true);

        $data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], true);

        $data['settings'] = $this->url->link('module/blog/blog_settings', 'token=' . $this->session->data['token'], true);
        $data['comments'] = $this->url->link('module/blog/blog_comments', 'token=' . $this->session->data['token'], true);
        $data['categories'] = $this->url->link('module/blog/blog_categories', 'token=' . $this->session->data['token'], true);
        $data['articles'] = $this->url->link('module/blog/blog_articles', 'token=' . $this->session->data['token'], true);
        $data['dashboard'] = $this->url->link('module/blog', 'token=' . $this->session->data['token'], true);


        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('module/blog/blog_categories', $data));
    }

    public function add() {

        $this->load->language('module/blog');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('blog/blog');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) { //print_r($this->request->post);exit;
            $this->model_blog_blog->addCategory($this->request->post);

            $this->session->data['success'] = $this->language->get('text_success_category');

            $this->response->redirect($this->url->link('module/blog/blog_categories', 'token=' . $this->session->data['token'] . $url, true));
        }

        $this->getForm();
    }

    public function edit() {

        $this->load->language('module/blog');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('blog/blog');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

            $this->model_blog_blog->editCategory($this->request->get['category_id'], $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success_category');

            $this->response->redirect($this->url->link('module/blog/blog_categories', 'token=' . $this->session->data['token'] . $url, true));
        }

        $this->getForm();
    }

    public function delete() {

        $this->load->language('module/blog');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('blog/blog');
        
        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $category_id) {
                $this->model_blog_blog->deleteCategory($category_id);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('module/blog/blog_categories', 'token=' . $this->session->data['token'], true));
        }

        $this->index();
    }

    protected function getForm() {

        $data['blog_dashboard'] = $this->language->get('blog_dashboard');
        $data['blog_categories'] = $this->language->get('blog_categories');
        $data['blog_articles'] = $this->language->get('blog_articles');
        $data['blog_comments'] = $this->language->get('blog_comments');
        $data['blog_settings'] = $this->language->get('blog_settings');

        $data['heading_title'] = $this->language->get('heading_title');

        $data['heading_addCat'] = $this->language->get('heading_addCat');

        $data['tab_general'] = $this->language->get('tab_general');
        $data['tab_option'] = $this->language->get('tab_option');
        $data['tab_image'] = $this->language->get('tab_image');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_status'] = $this->language->get('text_status');
        $data['text_seo_keyword'] = $this->language->get('text_seo_keyword');
        $data['text_sort_order'] = $this->language->get('text_sort_order');
        $data['text_category_description'] = $this->language->get('text_category_description');
        $data['text_category_title'] = $this->language->get('text_category_title');

        $data['entry_status'] = $this->language->get('entry_status');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        $data['action'] = $this->url->link('module/blog/blog_categories/add', 'token=' . $this->session->data['token'], true);

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['error_title'])) {
            $data['error_title'] = $this->error['error_title'];
        } else {
            $data['error_title'] = array();
        }

        if (isset($this->error['error_seo'])) {
            $data['error_seo'] = $this->error['error_seo'];
        } else {
            $data['error_seo'] = array();
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('module/blog', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('blog_categories'),
            'href' => $this->url->link('module/blog/blog_categories', 'token=' . $this->session->data['token'], true)
        );

        if (!isset($this->request->get['category_id'])) {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_addCat'),
                'href' => $this->url->link('module/blog/blog_categories/add', 'token=' . $this->session->data['token'], true)
            );
        } else {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_editCat'),
                'href' => $this->url->link('module/blog/blog_categories/edit', 'token=' . $this->session->data['token'] . '&category_id=' . $this->request->get['category_id'], true)
            );
        }

        if (!isset($this->request->get['category_id'])) {
            $data['action'] = $this->url->link('module/blog/blog_categories/add', 'token=' . $this->session->data['token'], true);
        } else {
            $data['action'] = $this->url->link('module/blog/blog_categories/edit', 'token=' . $this->session->data['token'] . '&category_id=' . $this->request->get['category_id'], true);
        }

        $data['cancel'] = $this->url->link('module/blog/blog_categories', 'token=' . $this->session->data['token'], true);

        if (isset($this->request->get['category_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $category_info = $this->model_blog_blog->getCategory($this->request->get['category_id']);
        }
        

        $data['token'] = $this->session->data['token'];

        if (isset($this->request->post['category_title'])) {
            $data['category_title'] = $this->request->post['category_title'];
        } elseif (!empty($category_info)) {
            $data['category_title'] = $category_info['blog_category_name'];
        } else {
            $data['category_title'] = '';
        }

        if (isset($this->request->post['category_description'])) {
            $data['category_description'] = $this->request->post['category_description'];
        } elseif (!empty($category_info)) {
            $data['category_description'] = $category_info['blog_category_description'];
        } else {
            $data['category_description'] = '';
        }

        if (isset($this->request->post['sort_order'])) {
            $data['sort_order'] = $this->request->post['sort_order'];
        } elseif (!empty($category_info)) {
            $data['sort_order'] = $category_info['blog_category_sort_order'];
        } else {
            $data['sort_order'] = '';
        }

        if (isset($this->request->post['seo_keyword'])) {
            $data['seo_keyword'] = $this->request->post['seo_keyword'];
        } elseif (!empty($category_info)) {
            $data['seo_keyword'] = $category_info['blog_category_seo_keyword'];
        } else {
            $data['seo_keyword'] = '';
        }

        if (isset($this->request->post['blog_category_status'])) {
            $data['blog_category_status'] = $this->request->post['blog_category_status'];
        } elseif (!empty($category_info)) {
            $data['blog_category_status'] = $category_info['blog_category_status'];
        } else {
            $data['blog_category_status'] = '';
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('module/blog/blog_categories_form', $data));
    }

    public function autocomplete() {

        $json = array();
        if (isset($this->request->get['filter_name'])) {
            $this->load->model('blog/blog');


            if (isset($this->request->get['filter_name'])) {
                $filter_name = $this->request->get['filter_name'];
            } else {
                $filter_name = '';
            }
            if (isset($this->request->get['limit'])) {
                $limit = $this->request->get['limit'];
            } else {
                $limit = 5;
            }
            $filter_data = array(
                'filter_name' => $filter_name,
                'start' => 0,
                'limit' => $limit
            );
            $results = $this->model_blog_blog->getAllCategories($filter_data);

            foreach ($results as $result) {
                $json[] = array(
                    'category_title' => $result['blog_category_name'],
                    'category_id' => $result['blog_category_id']
                );
            }
        }
        // print_r($json);exit;
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'module/blog')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        $this->load->model('blog/blog');

        if ($this->request->get['category_id'] == '') {
            if ($this->request->post['category_title'] != '') {

                $fieldname = 'blog_category_name';
                $value = $this->request->post['category_title'];
                $table = 'blog_category';
                $duplicate = $this->model_blog_blog->checkDuplicateEntry($fieldname, $table, $value);
                if ($duplicate == 0) {//echo 1234;exit;
                    $this->error['error_title'] = 'Category title already exist! Try another one.';
                }
            } else {
                $this->error['error_title'] = 'Category title field is required!!!';
            }

            if ($this->request->post['seo_keyword'] != '') {

                $fieldname = 'blog_category_seo_keyword';
                $value = $this->request->post['seo_keyword'];
                $table = 'blog_category';
                $duplicate = $this->model_blog_blog->checkDuplicateEntry($fieldname, $table, $value);
                if ($duplicate == 0) {
                    $this->error['error_seo'] = 'Seo keyword already exist! Try another one.';
                }
            } else {
                $this->error['error_seo'] = 'Seo keyword field is required!!!';
            }
        } else {

            if ($this->request->post['category_title'] != '') {

                $fieldname = 'blog_category_name';
                $value = $this->request->post['category_title'];
                $table = 'blog_category';
                $duplicate = $this->model_blog_blog->checkDuplicateEntryEdit($fieldname, $table, $value, $this->request->get['category_id']);
                if ($duplicate == 0) {//echo 1234;exit;
                    $this->error['error_title'] = 'Category title already exist! Try another one.';
                }
            } else {
                $this->error['error_title'] = 'Category title field is required!!!';
            }

            if ($this->request->post['seo_keyword'] != '') {

                $fieldname = 'blog_category_seo_keyword';
                $value = $this->request->post['seo_keyword'];
                $table = 'blog_category';
                $duplicate = $this->model_blog_blog->checkDuplicateEntryEdit($fieldname, $table, $value, $this->request->get['category_id']);
                if ($duplicate == 0) {
                    $this->error['error_seo'] = 'Seo keyword already exist! Try another one.';
                }
            } else {
                $this->error['error_seo'] = 'Seo keyword field is required!!!';
            }
        }
        //print_r($this->error);exit;

        return !$this->error;
    }

    protected function validateDelete() {
        if (!$this->user->hasPermission('modify', 'module/blog')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

}
