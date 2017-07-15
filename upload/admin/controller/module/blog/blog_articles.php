<?php

require_once __DIR__ . '/twitteroauth-master/src/Config.php';
//require_once __DIR__ . '/twitteroauth-master/src/Util/JsonDecoder.php';
require_once __DIR__ . '/twitteroauth-master/src/TwitterOAuth.php';
require_once __DIR__ . '/twitteroauth-master/src/Response.php';
require_once __DIR__ . '/twitteroauth-master/src/SignatureMethod.php';
require_once __DIR__ . '/twitteroauth-master/src/HmacSha1.php';
require_once __DIR__ . '/twitteroauth-master/src/Consumer.php';
require_once __DIR__ . '/twitteroauth-master/src/Token.php';
require_once __DIR__ . '/twitteroauth-master/src/Request.php';
require_once __DIR__ . '/twitteroauth-master/src/Util.php';
require_once __DIR__ . '/twitteroauth-master/src/Util/JsonDecoder.php';

require_once __DIR__ . '/facebook-php-sdk-v4-5.0.0/src/Facebook/Facebook.php';
require_once __DIR__ . '/facebook-php-sdk-v4-5.0.0/src/Facebook/autoload.php';

use Abraham\TwitterOAuth\TwitterOAuth;
use Abraham\TwitterOAuth\SignatureMethod;
use Abraham\TwitterOAuth\Response;
use Abraham\TwitterOAuth\Consumer;
use Abraham\TwitterOAuth\Token;
use Abraham\TwitterOAuth\Request;
use Abraham\TwitterOAuth\Util;
use Abraham\TwitterOAuth\JsonDecoder;

class ControllerModuleBlogBlogArticles extends Controller {

    private $error = array();

    public function index() {

        $this->load->language('module/blog');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('blog/blog');

        $this->getList();
    }

    protected function getList() {

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

        if (isset($this->request->get['filter_featured'])) {
            $filter_featured = $this->request->get['filter_featured'];
        } else {
            $filter_featured = null;
        }

        if (isset($this->request->get['filter_created_date'])) {
            $filter_created_date = $this->request->get['filter_created_date'];
        } else {
            $filter_created_date = null;
        }

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'blog_title';
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

        if (isset($this->request->get['filter_created_date'])) {
            $url .= '&filter_created_date=' . urlencode(html_entity_decode($this->request->get['filter_created_date'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_status'])) {
            $url .= '&filter_status=' . $this->request->get['filter_status'];
        }
        if (isset($this->request->get['filter_featured'])) {
            $url .= '&filter_featured=' . $this->request->get['filter_featured'];
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

        $data['heading_blog'] = $this->language->get('heading_blog');

        $data['blog_dashboard'] = $this->language->get('blog_dashboard');
        $data['blog_categories'] = $this->language->get('blog_categories');
        $data['blog_articles'] = $this->language->get('blog_articles');
        $data['blog_comments'] = $this->language->get('blog_comments');
        $data['blog_settings'] = $this->language->get('blog_settings');

        $data['article_name'] = $this->language->get('article_name');
        $data['status'] = $this->language->get('status');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['featured_status'] = $this->language->get('featured_status');

        $data['text_created_date'] = $this->language->get('text_created_date');
        $data['text_modified_date'] = $this->language->get('text_modified_date');
        $data['text_sort_order'] = $this->language->get('text_sort_order');
        $data['text_status'] = $this->language->get('text_status');
        $data['text_article_name'] = $this->language->get('text_article_name');
        $data['text_hits'] = $this->language->get('text_hits');
        $data['text_action'] = $this->language->get('text_action');
        $data['text_filter'] = $this->language->get('text_filter');
        $data['text_featured'] = $this->language->get('text_featured');
        $data['text_not_featured'] = $this->language->get('text_not_featured');
        $data['text_image'] = $this->language->get('text_image');

        $data['heading_blog_article'] = $this->language->get('heading_blog_article');

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
            'text' => $this->language->get('heading_blog_article'),
            'href' => $this->url->link('module/blog/blog_articles', 'token=' . $this->session->data['token'], true)
        );

        $filter_data = array(
            'filter_name' => $filter_name,
            'filter_created_date' => $filter_created_date,
            'filter_status' => $filter_status,
            'filter_featured' => $filter_featured,
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit' => $this->config->get('config_limit_admin')
        );

        $this->load->model('tool/image');

        $blogTotal = $this->model_blog_blog->getTotalBlogs($filter_data);

        $results = $this->model_blog_blog->getArticles($filter_data);

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

        $url = '';

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_created_date'])) {
            $url .= '&filter_created_date=' . urlencode(html_entity_decode($this->request->get['filter_created_date'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_status'])) {
            $url .= '&filter_status=' . $this->request->get['filter_status'];
        }
        if (isset($this->request->get['filter_featured'])) {
            $url .= '&filter_featured=' . $this->request->get['filter_featured'];
        }

        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $data['sort_title'] = $this->url->link('module/blog/blog_articles', 'token=' . $this->session->data['token'] . '&sort=blog_title' . $url, true);
        $data['sort_created_date'] = $this->url->link('module/blog/blog_articles', 'token=' . $this->session->data['token'] . '&sort=blog_created_date' . $url, true);
        $data['sort_modified_date'] = $this->url->link('module/blog/blog_articles', 'token=' . $this->session->data['token'] . '&sort=blog_modified_date' . $url, true);
        $data['sort_status'] = $this->url->link('module/blog/blog_articles', 'token=' . $this->session->data['token'] . '&sort=blog_status' . $url, true);
        $data['sort_featured'] = $this->url->link('module/blog/blog_articles', 'token=' . $this->session->data['token'] . '&sort=blog_featured' . $url, true);
        $data['sort_order'] = $this->url->link('module/blog/blog_articles', 'token=' . $this->session->data['token'] . '&sort=blog_sort_order' . $url, true);
        $data['sort_hits'] = $this->url->link('module/blog/blog_articles', 'token=' . $this->session->data['token'] . '&sort=blog_hits' . $url, true);

        $url = '';

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_created_date'])) {
            $url .= '&filter_created_date=' . urlencode(html_entity_decode($this->request->get['filter_created_date'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_status'])) {
            $url .= '&filter_status=' . $this->request->get['filter_status'];
        }
        if (isset($this->request->get['filter_featured'])) {
            $url .= '&filter_featured=' . $this->request->get['filter_featured'];
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }


        $pagination = new Pagination();
        $pagination->total = $blogTotal;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->url->link('module/blog/blog_articles', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($blogTotal) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($blogTotal - $this->config->get('config_limit_admin'))) ? $blogTotal : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $blogTotal, ceil($blogTotal / $this->config->get('config_limit_admin')));

        $data['filter_name'] = $filter_name;
        $data['filter_status'] = $filter_status;
        $data['filter_featured'] = $filter_featured;
        $data['filter_created_date'] = $filter_created_date;
        $data['sort'] = $sort;
        $data['order'] = $order;
        $data['token'] = $this->session->data['token'];

        $data['add'] = $this->url->link('module/blog/blog_articles/add', 'token=' . $this->session->data['token'], true);
        $data['delete'] = $this->url->link('module/blog/blog_articles/delete', 'token=' . $this->session->data['token'], true);

        $data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], true);

        $data['settings'] = $this->url->link('module/blog/blog_settings', 'token=' . $this->session->data['token'], true);
        $data['comments'] = $this->url->link('module/blog/blog_comments', 'token=' . $this->session->data['token'], true);
        $data['categories'] = $this->url->link('module/blog/blog_categories', 'token=' . $this->session->data['token'], true);
        $data['articles'] = $this->url->link('module/blog/blog_articles', 'token=' . $this->session->data['token'], true);
        $data['dashboard'] = $this->url->link('module/blog', 'token=' . $this->session->data['token'], true);

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('module/blog/blog_articles', $data));
    }

    public function add() {

        $this->load->language('module/blog');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('blog/blog');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            // print_r($this->request->post);exit;
            $lastid = $this->model_blog_blog->addArticle($this->request->post);
            $article = $this->model_blog_blog->getArticle($lastid); //echo $this->config->get("blog_facebook_access_token"); exit;

            if (($this->config->get("blog_facebook_access_token") != '') && ($this->config->get("blog_auto_post_on_facebook") == 1) && $article['blog_status'] == 1) {

                $this->autoPost($article);
            }
            if (($this->config->get("blog_auto_post_on_twitter") == 1) && $article['blog_status'] == 1) {

                $this->autoPostTwitter($article);
            }
            $this->session->data['success'] = $this->language->get('text_success_article');

            $this->response->redirect($this->url->link('module/blog/blog_articles', 'token=' . $this->session->data['token'], true));
        }

        $this->getForm();
    }

    public function autoPostTwitter($article) {

        $connection = new TwitterOAuth($this->config->get("blog_twit_consumer_key"), $this->config->get("blog_twit_consumer_secret"), $this->config->get("blog_twit_access_token"), $this->config->get("blog_twit_access_token_secret"));

        $this->load->model('tool/image');

        if (is_file(DIR_IMAGE . $article['blog_image'])) {
            $image = $this->model_tool_image->resize($article['blog_image'], 400, 250);
        } else {
            $image = $this->model_tool_image->resize('no_image.png', 400, 250);
        }

        $description = utf8_substr(strip_tags(html_entity_decode($article['blog_description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('blog_show_description_limit')) . '..';
        $link = $this->config->get("config_url") . "index.php?route=blog/singleblog&blog_id=" . $article['blog_id'];
        $attachment = $image;
        $status = $article['blog_title'] . '.......Click here to read ' . $link;
        $result = $connection->upload('media/upload', array('media' => $image));

        $parameters = array(
            "status" => $status,
            "media_ids" => $result->media_id_string
        );

        $statuses = $connection->post("statuses/update", $parameters);
    }

    public function deauthorize() {

        $fbData = array(
            'app_id' => $this->config->get('blog_facebook_app_id'),
            'app_secret' => $this->config->get('blog_facebook_app_secret')
        );

        $fb = new Facebook\Facebook($fbData);
        $response = $fb->get('/me?fields=id,name', $this->config->get('blog_facebook_access_token'));
        $user = $response->getGraphUser();

        $access_token = $this->config->get('blog_facebook_access_token');
        $result = array(
            'uid' => $user['id'],
            'access_token' => $access_token
        );

        //$ret = $fb->post('/' . $user['id'] . '/permissions' , 'DELETE' , $this->config->get('blog_facebook_access_token'));
        $ret = $fb->delete('/' . $user['id'] . '/permissions', $result, $this->config->get('blog_facebook_access_token'));

        $data['store_id'] = $this->config->get('config_store_id');
        $this->load->model('blog/blog');
        $this->model_blog_blog->removeAccessToken($data['store_id']);

        $this->session->data['success'] = 'Facebook App Deauthorized Successfully';

        $this->response->redirect($this->url->link('module/blog/blog_articles', 'token=' . $this->session->data['token'], true));
        $this->getForm();
    }

    public function autoPost($article) {

        $fbData = array(
            'app_id' => $this->config->get('blog_facebook_app_id'),
            'app_secret' => $this->config->get('blog_facebook_app_secret')
        );

        $fb = new Facebook\Facebook($fbData);
        $response = $fb->get('/me?fields=id,name', $this->config->get('blog_facebook_access_token'));
        $user = $response->getGraphUser();


        $this->load->model('tool/image');
        if (is_file(DIR_IMAGE . $article['blog_image'])) {
            $image = $this->model_tool_image->resize($article['blog_image'], 100, 100);
        } else {
            $image = $this->model_tool_image->resize('no_image.png', 100, 100);
        }
        $description = utf8_substr(strip_tags(html_entity_decode($article['blog_description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('blog_show_description_limit')) . '..';
        $params = array(
            // this is the main access token (facebook profile)
            "access_token" => $this->config->get('blog_facebook_access_token'),
            "message" => $this->config->get('blog_facebook_message'),
            "link" => $this->config->get("config_url") . "index.php?route=blog/singleblog&blog_id=" . $article['blog_id'],
            "picture" => $image,
            "name" => $article['blog_title'],
            "caption" => $this->config->get("config_url"),
            "description" => $description,
            'req_perms' => 'status_update,manage_pages,publish_actions'
        );
        $ret = $fb->post('/' . $user['id'] . '/feed', $params, $this->config->get('blog_facebook_access_token'));
        return true;
    }

    public function edit() {

        $this->load->language('module/blog');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('blog/blog');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

            $this->model_blog_blog->editArticle($this->request->get['blog_id'], $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success_article');

            $this->response->redirect($this->url->link('module/blog/blog_articles', 'token=' . $this->session->data['token'], true));
        }

        $this->getForm();
    }

    public function delete() {

        $this->load->language('module/blog');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('blog/blog');

        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $blog_id) {
                $this->model_blog_blog->deleteArticle($blog_id);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('module/blog/blog_articles', 'token=' . $this->session->data['token'], true));
        }

        $this->index();
    }

    protected function getForm() {

        $data['heading_title'] = $this->language->get('heading_title_article');

        if (!isset($this->request->get['blog_id'])) {
            $data['heading_article'] = $this->language->get('heading_addArticle');
        } else {
            $data['heading_article'] = $this->language->get('heading_editArticle');
        }

        $data['tab_general'] = $this->language->get('tab_general');
        $data['tab_blog'] = $this->language->get('tab_blog');
        $data['tab_image'] = $this->language->get('tab_image');

        $data['blog_dashboard'] = $this->language->get('blog_dashboard');
        $data['blog_categories'] = $this->language->get('blog_categories');
        $data['blog_articles'] = $this->language->get('blog_articles');
        $data['blog_comments'] = $this->language->get('blog_comments');
        $data['blog_settings'] = $this->language->get('blog_settings');

        $data['text_blog_category'] = $this->language->get('text_blog_category');
        $data['text_tags'] = $this->language->get('text_tags');
        $data['text_seo_keyword'] = $this->language->get('text_seo_keyword');
        $data['text_created_date'] = $this->language->get('text_created_date');
        $data['text_hits'] = $this->language->get('text_hits');
        $data['text_creator'] = $this->language->get('text_creator');
        $data['text_status'] = $this->language->get('text_status');
        $data['text_blog_title'] = $this->language->get('text_blog_title');
        $data['text_blog_decription'] = $this->language->get('text_blog_decription');
        $data['text_image'] = $this->language->get('text_image');
        $data['text_sort_order'] = $this->language->get('text_sort_order');
        $data['text_featured'] = $this->language->get('text_featured');
        $data['entry_related'] = $this->language->get('entry_related');
        $data['text_tags_example'] = $this->language->get('text_tags_example');
        $data['text_yes'] = $this->language->get('text_yes');
        $data['text_no'] = $this->language->get('text_no');
        $data['text_created_date'] = $this->language->get('text_created_date');
        $data['text_modified_date'] = $this->language->get('text_modified_date');
        $data['text_blog_creator'] = $this->language->get('text_blog_creator');
        $data['text_blog_title'] = $this->language->get('text_blog_title');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');

        $data['settings'] = $this->url->link('module/blog/blog_settings', 'token=' . $this->session->data['token'], true);
        $data['comments'] = $this->url->link('module/blog/blog_comments', 'token=' . $this->session->data['token'], true);
        $data['categories'] = $this->url->link('module/blog/blog_categories', 'token=' . $this->session->data['token'], true);
        $data['articles'] = $this->url->link('module/blog/blog_articles', 'token=' . $this->session->data['token'], true);
        $data['dashboard'] = $this->url->link('module/blog', 'token=' . $this->session->data['token'], true);

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

        if (isset($this->error['error_title'])) {
            $data['error_title'] = $this->error['error_title'];
        } else {
            $data['error_title'] = array();
        }

        if (isset($this->error['error_category'])) {
            $data['error_category'] = $this->error['error_category'];
        } else {
            $data['error_category'] = array();
        }

        if (isset($this->error['error_seo'])) {
            $data['error_seo'] = $this->error['error_seo'];
        } else {
            $data['error_seo'] = array();
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
            'text' => 'Blog Articles',
            'href' => $this->url->link('module/blog/blog_articles', 'token=' . $this->session->data['token'], true)
        );

        if (!isset($this->request->get['blog_id'])) {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_addArticle'),
                'href' => $this->url->link('module/blog/blog_articles/add', 'token=' . $this->session->data['token'], true)
            );
        } else {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_editArticle'),
                'href' => $this->url->link('module/blog/blog_articles/edit', 'token=' . $this->session->data['token'] . '&blog_id=' . $this->request->get['blog_id'], true)
            );
        }

        $data['blog_category'] = $this->model_blog_blog->getAllCategories();


        if (!isset($this->request->get['blog_id'])) {
            $data['action'] = $this->url->link('module/blog/blog_articles/add', 'token=' . $this->session->data['token'], true);
        } else {
            $data['action'] = $this->url->link('module/blog/blog_articles/edit', 'token=' . $this->session->data['token'] . '&blog_id=' . $this->request->get['blog_id'], true);
        }

        $data['cancel'] = $this->url->link('module/blog/blog_articles', 'token=' . $this->session->data['token'], true);

        if (isset($this->request->get['blog_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $blog_info = $this->model_blog_blog->getArticle($this->request->get['blog_id']);
        }

        $data['token'] = $this->session->data['token'];

        if (isset($this->request->post['blog_title'])) {
            $data['blog_title'] = $this->request->post['blog_title'];
        } elseif (!empty($blog_info)) {
            $data['blog_title'] = $blog_info['blog_title'];
        } else {
            $data['blog_title'] = '';
        }

        if (isset($this->request->post['blog_description'])) {
            $data['blog_description'] = $this->request->post['blog_description'];
        } elseif (!empty($blog_info)) {
            $data['blog_description'] = $blog_info['blog_description'];
        } else {
            $data['blog_description'] = '';
        }

        if (isset($this->request->post['blog_category'])) {
            $data['category'] = $this->request->post['blog_category'];
        } elseif (!empty($blog_info)) {
            $data['category'] = $blog_info['blog_category'];
        } else {
            $data['category'] = '';
        }

        if (isset($this->request->post['blog_tags'])) {
            $data['blog_tags'] = $this->request->post['blog_tags'];
        } elseif (!empty($blog_info)) {
            $data['blog_tags'] = $blog_info['blog_tags'];
        } else {
            $data['blog_tags'] = '';
        }

        if (isset($this->request->post['blog_hits'])) {
            $data['blog_hits'] = $this->request->post['blog_hits'];
        } elseif (!empty($blog_info)) {
            $data['blog_hits'] = $blog_info['blog_hits'];
        } else {
            $data['blog_hits'] = '';
        }

        if (isset($this->request->post['blog_seo_keyword'])) {
            $data['blog_seo_keyword'] = $this->request->post['blog_seo_keyword'];
        } elseif (!empty($blog_info)) {
            $data['blog_seo_keyword'] = $blog_info['blog_seo_keyword'];
        } else {
            $data['blog_seo_keyword'] = '';
        }

        if (isset($this->request->post['blog_creator'])) {
            $data['blog_creator'] = $this->request->post['blog_creator'];
            $data['blog_creator_name'] = $this->request->post['blog_creator_name'];
        } elseif (!empty($blog_info)) {
            $data['blog_creator'] = $blog_info['blog_creator'];
            $this->load->model('user/user');
            $user = $this->model_user_user->getUser($data['blog_creator']);
            $data['blog_creator_name'] = $user['username'];
        } else {
            $data['blog_creator'] = $this->session->data['user_id'];
            $data['blog_creator_name'] = $this->session->data['username'];
        }

        if (isset($this->request->post['blog_created_date'])) {
            $data['blog_created_date'] = $this->request->post['blog_created_date'];
        } elseif (!empty($blog_info)) {
            $data['blog_created_date'] = $blog_info['blog_created_date'];
        } else {
            $data['blog_created_date'] = '';
        }

        if (isset($this->request->post['blog_modified_date'])) {
            $data['blog_modified_date'] = $this->request->post['blog_modified_date'];
        } elseif (!empty($blog_info)) {
            $data['blog_modified_date'] = $blog_info['blog_modified_date'];
        } else {
            $data['blog_modified_date'] = '';
        }

        if (isset($this->request->post['blog_status'])) {
            $data['blog_status'] = $this->request->post['blog_status'];
        } elseif (!empty($blog_info)) {
            $data['blog_status'] = $blog_info['blog_status'];
        } else {
            $data['blog_status'] = '';
        }
        if (isset($this->request->post['blog_featured'])) {
            $data['blog_status'] = $this->request->post['blog_featured'];
        } elseif (!empty($blog_info)) {
            $data['blog_featured'] = $blog_info['blog_featured'];
        } else {
            $data['blog_featured'] = '';
        }

        if (isset($this->request->post['blog_related'])) {
            $blogs = $this->request->post['blog_related'];
        } elseif (isset($this->request->get['blog_id'])) {
            $blogs = explode(',', $blog_info['blog_related']);
        } else {
            $blogs = array();
        }

        $data['blog_relateds'] = array();

        foreach ($blogs as $blog_id) {
            $related_info = $this->model_blog_blog->getArticle($blog_id);

            if ($related_info) {
                $data['blog_relateds'][] = array(
                    'blog_id' => $related_info['blog_id'],
                    'blog_title' => $related_info['blog_title']
                );
            }
        }

        if (isset($this->request->post['blog_sort_order'])) {
            $data['blog_sort_order'] = $this->request->post['blog_sort_order'];
        } elseif (!empty($blog_info)) {
            $data['blog_sort_order'] = $blog_info['blog_sort_order'];
        } else {
            $data['blog_sort_order'] = '';
        }
//print_r($data);die;

        $this->load->model('tool/image');

        if (isset($this->request->post['blog_image']) && is_file(DIR_IMAGE . $this->request->post['blog_image'])) {
            $data['thumb'] = $this->model_tool_image->resize($this->request->post['blog_image'], 100, 100);
            $data['blog_image'] = $this->request->post['blog_image'];
        } elseif (!empty($blog_info) && is_file(DIR_IMAGE . $blog_info['blog_image'])) {
            $data['thumb'] = $this->model_tool_image->resize($blog_info['blog_image'], 100, 100);
            $data['blog_image'] = $blog_info['blog_image'];
        } else {
            $data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
            $data['blog_image'] = '';
        }


        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('module/blog/blog_articles_form', $data));
    }

    public function autocomplete() {
        $json = array();
        if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_recent_post'])) {

            $this->load->model('blog/blog');

            if (isset($this->request->get['filter_name'])) {
                $filter_name = $this->request->get['filter_name'];
            } else {
                $filter_name = '';
            }
            if (isset($this->request->get['filter_recent_post'])) {
                $filter_recent_post = $this->request->get['filter_recent_post'];
            } else {
                $filter_recent_post = '';
            }
            if (isset($this->request->get['limit'])) {
                $limit = $this->request->get['limit'];
            } else {
                $limit = 5;
            }
            if ($filter_recent_post != '') {

                $filter_data = array(
                    'filter_name' => $filter_recent_post,
                    'sort' => 'blog_created_date',
                    'order' => 'DESC',
                    'start' => 0,
                    'limit' => $limit
                );
            } else {
                $filter_data = array(
                    'filter_name' => $filter_name,
                    'filter_recent_post' => $filter_recent_post,
                    'start' => 0,
                    'limit' => $limit
                );
            }
            $results = $this->model_blog_blog->getArticles($filter_data);

            foreach ($results as $result) {
                $json[] = array(
                    'blog_title' => $result['blog_title'],
                    'blog_id' => $result['blog_id'],
                    'blog_created_date' => $result['blog_created_date']
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
        $this->load->model('blog/blog');

        if ($this->request->post['blog_category'] == '') {
            $this->error['error_category'] = 'Blog category field is required!!!';
        }

        if ($this->request->post['blog_seo_keyword'] == '') {

            $this->error['error_seo'] = 'Seo keyword field is required!!!';
        }

        if ($this->request->post['blog_title'] == '') {

            $this->error['error_title'] = 'Blog title field is required!!!';
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
