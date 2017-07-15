<?php

class ControllerModuleBlogCategory extends Controller {

    private $error = array();

    public function index() {
        $this->load->language('module/blog_category');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('extension/module');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

            if (!isset($this->request->get['module_id'])) {
                $this->model_extension_module->addModule('blog_category', $this->request->post);
            } else {
                $this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], true));
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');

        $data['entry_name'] = $this->language->get('entry_name');
        $data['entry_product'] = $this->language->get('entry_product');
        $data['entry_limit'] = $this->language->get('entry_limit');
        $data['entry_width'] = $this->language->get('entry_width');
        $data['entry_height'] = $this->language->get('entry_height');
        $data['entry_status'] = $this->language->get('entry_status');

        $data['help_product'] = $this->language->get('help_product');

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

        if (!isset($this->request->get['module_id'])) {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('module/blog_category', 'token=' . $this->session->data['token'], true)
            );
        } else {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('module/blog_category', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true)
            );
        }

        if (!isset($this->request->get['module_id'])) {
            $data['action'] = $this->url->link('module/blog_category', 'token=' . $this->session->data['token'], true);
        } else {
            $data['action'] = $this->url->link('module/blog_category', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true);
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

        $this->load->model('blog/blog');

        $data['products'] = array();

        if (!empty($this->request->post['category'])) {
            $products = $this->request->post['category'];
        } elseif (!empty($module_info['category'])) {
            $products = $module_info['category'];
        } else {
            $products = array();
        }

        foreach ($products as $product_id) {
            $product_info = $this->model_blog_blog->getCategory($product_id);

            if ($product_info) {
                $data['categories'][] = array(
                    'category_id' => $product_info['blog_category_id'],
                    'name' => $product_info['blog_category_name']
                );
            }
        }
        // print_r($data['categories']);exit;
        if (isset($this->request->post['limit'])) {
            $data['limit'] = $this->request->post['limit'];
        } elseif (!empty($module_info)) {
            $data['limit'] = $module_info['limit'];
        } else {
            $data['limit'] = 5;
        }


        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($module_info)) {
            $data['status'] = $module_info['status'];
        } else {
            $data['status'] = '';
        }
        $data['all_categories'] = $this->model_blog_blog->getAllCategories($s = '');
        //print_r($all_categories);exit;

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('module/blog_category', $data));
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
                'filter_status' => 1,
                'start' => 0,
                'limit' => $limit
            );
            $results = $this->model_blog_blog->getAllCategories($filter_data);
            //print_r($results);exit;
            $id = '';
            foreach ($results as $result) {
                $arr2[] = array(
                    'category_title' => $result['blog_category_name'],
                    'category_id' => $result['blog_category_id']
                );
                $id .= $result['blog_category_id'];
                if ($result['blog_category_id'] != '') {
                    $id .= ',';
                }
            }
            $allid = substr($id, 0, -1); //Removes very last comma.

            $arr1[] = array(
                'category_title' => 'Select All',
                'category_id' => $allid
            );
            $json = array_merge($arr1, $arr2);
        }
        // print_r($json);exit;
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function getCategoryName() {

        $category_id = $this->request->get['category_id'];

        $this->load->model('blog/blog');
        $category = $this->model_blog_blog->getCategory($category_id);
        //print_r($category['blog_category_name']);exit;
        $json = array();
        $json['category_name'] = $category['blog_category_name'];
        $json['category_id'] = $category['blog_category_id'];

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'module/featured')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
            $this->error['name'] = $this->language->get('error_name');
        }

        return !$this->error;
    }

}
