<?php

class ControllerModuleBlogBlogComments extends Controller {

    private $error = array();

    public function index() {

        if (isset($this->request->get['filter_name'])) {
            $filter_name = $this->request->get['filter_name'];
        } else {
            $filter_name = null;
        }
        if (isset($this->request->get['filter_email'])) {
            $filter_email = $this->request->get['filter_email'];
        } else {
            $filter_email = null;
        }
        if (isset($this->request->get['filter_status'])) {
            $filter_status = $this->request->get['filter_status'];
        } else {
            $filter_status = null;
        }
        if (isset($this->request->get['filter_created_date'])) {
            $filter_created_date = $this->request->get['filter_created_date'];
        } else {
            $filter_created_date = null;
        }

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'c.comment_created_date';
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

        $url = '';

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_status'])) {
            $url .= '&filter_status=' . $this->request->get['filter_status'];
        }
        if (isset($this->request->get['filter_email'])) {
            $url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
        }
        if (isset($this->request->get['filter_created_date'])) {
            $url .= '&filter_created_date=' . $this->request->get['filter_created_date'];
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

        $this->document->setTitle($this->language->get('blog_comments'));
        $data['heading_comments'] = $this->language->get('heading_comments');

        $this->load->model('setting/setting');
        $this->load->model('blog/blog');

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
        $data['text_filter'] = $this->language->get('text_filter');
        $data['text_blog_title'] = $this->language->get('text_blog_title');

        $data['text_comment'] = $this->language->get('text_comment');
        $data['text_blog_title'] = $this->language->get('text_blog_title');
        $data['text_user_email'] = $this->language->get('text_user_email');
        $data['text_created_date'] = $this->language->get('text_created_date');
        $data['text_modified_date'] = $this->language->get('text_modified_date');
        $data['text_status'] = $this->language->get('text_status');
        $data['text_action'] = $this->language->get('text_action');
        $data['text_publish'] = $this->language->get('text_publish');
        $data['text_unpublish'] = $this->language->get('text_unpublish');
        $data['heading_editComment'] = $this->language->get('heading_editComment');
        $data['text_make_publish'] = $this->language->get('text_make_publish');
        $data['text_make_unpublish'] = $this->language->get('text_make_unpublish');

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
            'text' => $this->language->get('blog_comments'),
            'href' => $this->url->link('module/blog/blog_comments', 'token=' . $this->session->data['token'], true)
        );

        $filter_data = array(
            'filter_name' => $filter_name,
            'filter_status' => $filter_status,
            'filter_email' => $filter_email,
            'filter_created_date' => $filter_created_date,
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit' => $this->config->get('config_limit_admin')
        );

        $commentTotal = $this->model_blog_blog->getTotalComment($filter_data);

        $results = $this->model_blog_blog->getAllComments($filter_data);

        foreach ($results as $result) {

            $data['all_comments'][] = array(
                'comment_id' => $result['comment_id'],
                'comment' => $result['comment'],
                'comment_blog_id' => $result['comment_blog_id'],
                'comment_user_id' => $result['comment_user_id'],
                'comment_user_name' => $result['comment_user_name'],
                'comment_user_email' => $result['comment_user_email'],
                'comment_created_date' => $result['comment_created_date'],
                'comment_modified_date' => $result['comment_modified_date'],
                'comment_status' => $result['comment_status'],
                'comment_blog_title' => $result['blog_title'],
                'edit' => $this->url->link('module/blog/blog_comments/edit', 'token=' . $this->session->data['token'] . '&comment_id=' . $result['comment_id'], true),
                'publish' => $this->url->link('module/blog/blog_comments/unpublish', 'token=' . $this->session->data['token'] . '&comment_id=' . $result['comment_id'], true),
                'unpublish' => $this->url->link('module/blog/blog_comments/publish', 'token=' . $this->session->data['token'] . '&comment_id=' . $result['comment_id'], true)
            );
        }

        $url = '';

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }
        if (isset($this->request->get['filter_email'])) {
            $url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_status'])) {
            $url .= '&filter_status=' . $this->request->get['filter_status'];
        }
        if (isset($this->request->get['filter_created_date'])) {
            $url .= '&filter_created_date=' . $this->request->get['filter_created_date'];
        }

        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }
        $data['sort_comment'] = $this->url->link('module/blog/blog_comments', 'token=' . $this->session->data['token'] . '&sort=c.comment' . $url, true);
        $data['sort_blog_id'] = $this->url->link('module/blog/blog_comments', 'token=' . $this->session->data['token'] . '&sort=c.comment_blog_id' . $url, true);
        $data['sort_email'] = $this->url->link('module/blog/blog_comments', 'token=' . $this->session->data['token'] . '&sort=c.comment_user_email' . $url, true);
        $data['sort_created_date'] = $this->url->link('module/blog/blog_comments', 'token=' . $this->session->data['token'] . '&sort=c.comment_created_date' . $url, true);
        $data['sort_modified_date'] = $this->url->link('module/blog/blog_comments', 'token=' . $this->session->data['token'] . '&sort=c.comment_modified_date' . $url, true);
        $data['sort_status'] = $this->url->link('module/blog/blog_comments', 'token=' . $this->session->data['token'] . '&sort=c.comment_status' . $url, true);

        $url = '';
        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }
        if (isset($this->request->get['filter_email'])) {
            $url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
        }
        if (isset($this->request->get['filter_status'])) {
            $url .= '&filter_status=' . $this->request->get['filter_status'];
        }
        if (isset($this->request->get['filter_created_date'])) {
            $url .= '&filter_created_date=' . $this->request->get['filter_created_date'];
        }
        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        $pagination = new Pagination();
        $pagination->total = $commentTotal;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->url->link('module/blog/blog_comments', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($commentTotal) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($commentTotal - $this->config->get('config_limit_admin'))) ? $commentTotal : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $commentTotal, ceil($commentTotal / $this->config->get('config_limit_admin')));


        $data['sort'] = $sort;
        $data['order'] = $order;
        $data['token'] = $this->session->data['token'];

        $data['publish'] = $this->url->link('module/blog/blog_comments/publish', 'token=' . $this->session->data['token'], true);
        $data['unpublish'] = $this->url->link('module/blog/blog_comments/unpublish', 'token=' . $this->session->data['token'], true);

        $data['delete'] = $this->url->link('module/blog/blog_comments/delete', 'token=' . $this->session->data['token'], true);

        $data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], true);

        $data['settings'] = $this->url->link('module/blog/blog_settings', 'token=' . $this->session->data['token'], true);
        $data['comments'] = $this->url->link('module/blog/blog_comments', 'token=' . $this->session->data['token'], true);
        $data['categories'] = $this->url->link('module/blog/blog_categories', 'token=' . $this->session->data['token'], true);
        $data['articles'] = $this->url->link('module/blog/blog_articles', 'token=' . $this->session->data['token'], true);
        $data['dashboard'] = $this->url->link('module/blog', 'token=' . $this->session->data['token'], true);

        if (isset($this->request->post['blog_blogname'])) {
            $data['blog_blogname'] = $this->request->post['blog_blogname'];
        } else {
            $data['blog_blogname'] = $this->config->get('blog_blogname');
        }


        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('module/blog/blog_comments', $data));
    }

    public function edit() {

        $this->load->language('module/blog');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('blog/blog');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

            $this->model_blog_blog->editComment($this->request->get['comment_id'], $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success_comment');

            $this->response->redirect($this->url->link('module/blog/blog_comments', 'token=' . $this->session->data['token'], true));
        }

        $this->getForm();
    }

    public function delete() {

        $this->load->language('module/blog');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('blog/blog');

        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $comment_id) {
                $this->model_blog_blog->deleteComment($comment_id);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('module/blog/blog_comments', 'token=' . $this->session->data['token'], true));
        }

        $this->index();
    }

    public function publish() {

        $this->load->language('module/blog');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('blog/blog');

        $this->model_blog_blog->publishComment($this->request->get['comment_id']);

        $this->session->data['success'] = $this->language->get('text_success');

        $this->response->redirect($this->url->link('module/blog/blog_comments', 'token=' . $this->session->data['token'], true));
    }

    public function unpublish() {

        $this->load->language('module/blog');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('blog/blog');

        $this->model_blog_blog->unpublishComment($this->request->get['comment_id']);

        $this->session->data['success'] = $this->language->get('text_success');

        $this->response->redirect($this->url->link('module/blog/blog_comments', 'token=' . $this->session->data['token'], true));
    }

    protected function getForm() {

        $data['blog_dashboard'] = $this->language->get('blog_dashboard');
        $data['blog_categories'] = $this->language->get('blog_categories');
        $data['blog_articles'] = $this->language->get('blog_articles');
        $data['blog_comments'] = $this->language->get('blog_comments');
        $data['blog_settings'] = $this->language->get('blog_settings');

        $data['heading_editComment'] = $this->language->get('heading_editComment');

        $data['tab_general'] = $this->language->get('tab_general');
        $data['tab_option'] = $this->language->get('tab_option');
        $data['tab_image'] = $this->language->get('tab_image');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_status'] = $this->language->get('text_status');

        $data['text_created_date'] = $this->language->get('text_created_date');
        $data['text_user_name'] = $this->language->get('text_user_name');
        $data['text_user_email'] = $this->language->get('text_user_email');
        $data['text_comment'] = $this->language->get('text_comment');

        $data['entry_status'] = $this->language->get('entry_status');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

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
            'text' => $this->language->get('blog_comments'),
            'href' => $this->url->link('module/blog/blog_comments', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_editComment'),
            'href' => $this->url->link('module/blog/blog_comments/edit', 'token=' . $this->session->data['token'] . '&comment_id=' . $this->request->get['comment_id'], true)
        );


        $data['action'] = $this->url->link('module/blog/blog_comments/edit', 'token=' . $this->session->data['token'] . '&comment_id=' . $this->request->get['comment_id'], true);

        $data['cancel'] = $this->url->link('module/blog/blog_comments', 'token=' . $this->session->data['token'], true);

        if (isset($this->request->get['comment_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $commentInfo = $this->model_blog_blog->getComment($this->request->get['comment_id']);
        }

        $data['token'] = $this->session->data['token'];

        if (!empty($commentInfo)) {
            $data['comment'] = $commentInfo['comment'];
        } else {
            $data['comment'] = '';
        }
        if (!empty($commentInfo)) {
            $data['comment_blog_id'] = $commentInfo['comment_blog_id'];
        } else {
            $data['comment_blog_id'] = '';
        }

        if (!empty($commentInfo)) {
            $data['blog_title'] = $commentInfo['blog_title'];
        } else {
            $data['blog_title'] = '';
        }
        if (!empty($commentInfo)) {
            $data['comment_user_name'] = $commentInfo['comment_user_name'];
        } else {
            $data['comment_user_name'] = '';
        }
        if (!empty($commentInfo)) {
            $data['comment_user_email'] = $commentInfo['comment_user_email'];
        } else {
            $data['comment_user_email'] = '';
        }
        if (!empty($commentInfo)) {
            $data['comment_status'] = $commentInfo['comment_status'];
        } else {
            $data['comment_status'] = '';
        }
        if (!empty($commentInfo)) {
            $data['comment_created_date'] = $commentInfo['comment_created_date'];
        } else {
            $data['comment_created_date'] = '';
        }



        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('module/blog/blog_comments_form', $data));
    }

    public function autocomplete() {

        $json = array();
        if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_email'])) {
            $this->load->model('blog/blog');


            if (isset($this->request->get['filter_name'])) {
                $filter_name = $this->request->get['filter_name'];
            } else {
                $filter_name = '';
            }
            if (isset($this->request->get['filter_email'])) {
                $filter_email = $this->request->get['filter_email'];
            } else {
                $filter_email = '';
            }
            if (isset($this->request->get['limit'])) {
                $limit = $this->request->get['limit'];
            } else {
                $limit = 5;
            }
            $filter_data = array(
                'filter_name' => $filter_name,
                'filter_email' => $filter_email,
                'start' => 0,
                'limit' => $limit
            );
            $results = $this->model_blog_blog->getAllComments($filter_data);

            foreach ($results as $result) {
                $json[] = array(
                    'blog_title' => $result['blog_title'],
                    'comment_user_email' => $result['comment_user_email'],
                );
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'module/blog')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

    protected function validateDelete() {
        if (!$this->user->hasPermission('modify', 'module/blog')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

}
