<?php

class ControllerModuleBlog extends Controller {

    private $error = array();

    public function index() {
        $this->load->language('module/blog');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('extension/module');
        $this->load->model('blog/blog');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            // print_r($this->request->post); exit;
            if (!isset($this->request->get['module_id'])) {
                $this->model_extension_module->addModule('blog', $this->request->post);
            } else {
                $this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], true));
        }

        $data['blog_dashboard'] = $this->language->get('blog_dashboard');
        $data['blog_categories'] = $this->language->get('blog_categories');
        $data['blog_articles'] = $this->language->get('blog_articles');
        $data['blog_comments'] = $this->language->get('blog_comments');
        $data['blog_settings'] = $this->language->get('blog_settings');

        $data['heading_title'] = $this->language->get('heading_title');

        $data['heading_settings'] = $this->language->get('heading_settings');

        $data['tab_general'] = $this->language->get('tab_general');
        $data['tab_option'] = $this->language->get('tab_option');
        $data['tab_image'] = $this->language->get('tab_image');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_feature'] = $this->language->get('text_feature');
        $data['text_popular'] = $this->language->get('text_popular');
        $data['text_module_name'] = $this->language->get('text_module_name');
        $data['text_create'] = $this->language->get('text_create');
        $data['text_total_blogs'] = $this->language->get('text_total_blogs');
        $data['text_view_more'] = $this->language->get('text_view_more');
        $data['text_total_categories'] = $this->language->get('text_total_categories');
        $data['text_total_comments'] = $this->language->get('text_total_comments');
        $data['text_not_featured'] = $this->language->get('text_not_featured');
        $data['text_featured'] = $this->language->get('text_featured');
        $data['text_image'] = $this->language->get('text_image');
        $data['text_article_name'] = $this->language->get('text_article_name');
        $data['text_created_date'] = $this->language->get('text_created_date');
        $data['text_modified_date'] = $this->language->get('text_modified_date');
        $data['text_sort_order'] = $this->language->get('text_sort_order');
        $data['text_status'] = $this->language->get('text_status');
        $data['featured_status'] = $this->language->get('featured_status');
        $data['text_hits'] = $this->language->get('text_hits');
        $data['text_action'] = $this->language->get('text_action');

        $data['entry_status'] = $this->language->get('entry_status');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['name'])) {
            $data['error_name'] = $this->error['name'];
        } else {
            $data['error_name'] = '';
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
            'href' => $this->url->link('module/account', 'token=' . $this->session->data['token'], true)
        );

        if (!isset($this->request->get['module_id'])) {
            $data['action'] = $this->url->link('module/blog', 'token=' . $this->session->data['token'], true);
        } else {
            $data['action'] = $this->url->link('module/blog', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true);
        }

        $data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], true);

        if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
        }

        $data['token'] = $this->session->data['token'];

        if (isset($this->request->post['name'])) {
            $data['name'] = $this->request->post['name'];
        } elseif (!empty($module_info)) {
            $data['name'] = $module_info['name'];
        } else {
            $data['name'] = '';
        }

        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($module_info)) {
            $data['status'] = $module_info['status'];
        } else {
            $data['status'] = '';
        }
        $filter_data = array(
            
            'sort' => 'blog_hits',
            'order' => 'DESC',
            'start' => 0,
            'limit' => 3
        );
        $results = $this->model_blog_blog->getArticles($filter_data);
        
        $this->load->model('tool/image');
                
        foreach ($results as $result) {
            if (is_file(DIR_IMAGE . $result['blog_image'])) {
                $image = $this->model_tool_image->resize($result['blog_image'], 40, 40);
            } else {
                $image = $this->model_tool_image->resize('no_image.png', 40, 40);
            }

            $data['blogs'][] = array(
                'blog_id' => $result['blog_id'],
                'blog_title' => $result['blog_title'],
                'blog_category' => $result['blog_category'],
                'blog_tags' => $result['blog_tags'],
                'blog_hits' => $result['blog_hits'],
                'blog_seo_keyword' => $result['blog_seo_keyword'],
                'blog_creator' => $result['blog_creator'],
                'blog_created_date' => $result['blog_created_date'],
                'blog_modified_date' => $result['blog_modified_date'],
                'blog_status' => $result['blog_status'],
                'blog_featured' => $result['blog_featured'],
                'blog_image' => $image,
                'blog_sort_order' => $result['blog_sort_order'],
                'edit' => $this->url->link('module/blog/blog_articles/edit', 'token=' . $this->session->data['token'] . '&blog_id=' . $result['blog_id'], true),
                'comment' => $this->url->link('module/blog/blog_comments', 'token=' . $this->session->data['token'] . '&filter_name=' . $result['blog_title'], true)
            );
        }

        $data['totalBlogs'] = $this->model_blog_blog->getTotalBlogs();
        $data['totalCategories'] = $this->model_blog_blog->getTotalCategory();
        $data['totalComments'] = $this->model_blog_blog->getTotalComment();

        $data['settings'] = $this->url->link('module/blog/blog_settings', 'token=' . $this->session->data['token'], true);
        $data['comments'] = $this->url->link('module/blog/blog_comments', 'token=' . $this->session->data['token'], true);
        $data['categories'] = $this->url->link('module/blog/blog_categories', 'token=' . $this->session->data['token'], true);
        $data['articles'] = $this->url->link('module/blog/blog_articles', 'token=' . $this->session->data['token'], true);
        $data['dashboard'] = $this->url->link('module/blog', 'token=' . $this->session->data['token'], true);

        if (isset($this->request->post['account_status'])) {
            $data['account_status'] = $this->request->post['account_status'];
        } else {
            $data['account_status'] = $this->config->get('account_status');
        }
        $data['sort'] = 'blog_created_date';
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('module/blog', $data));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'module/blog')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
            $this->error['name'] = $this->language->get('error_name');
        }

        return !$this->error;
    }

}
