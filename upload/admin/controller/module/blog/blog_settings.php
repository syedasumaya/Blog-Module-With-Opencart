<?php

class ControllerModuleBlogBlogSettings extends Controller {

    private $error = array();

    public function index() {

        $this->load->language('module/blog');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('blog', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success_setting');

            $this->response->redirect($this->url->link('module/blog/blog_settings', 'token=' . $this->session->data['token'], true));
        }

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
        $data['show_recaptcha_sitekey'] = $this->language->get('show_recaptcha_sitekey');
        $data['show_recaptcha_secretkey'] = $this->language->get('show_recaptcha_secretkey');
        $data['show_social_media_share'] = $this->language->get('show_social_media_share');
        $data['auto_post_on_facebook'] = $this->language->get('auto_post_on_facebook');
        $data['auto_post_on_twitter'] = $this->language->get('auto_post_on_twitter');
        $data['facebook_app_id'] = $this->language->get('facebook_app_id');
        $data['facebook_app_secret'] = $this->language->get('facebook_app_secret');
        $data['twit_consumer_key'] = $this->language->get('twit_consumer_key');
        $data['twit_consumer_secret'] = $this->language->get('twit_consumer_secret');
        $data['text_blog_limit'] = $this->language->get('blog_limit');
        $data['show_articles_under_category'] = $this->language->get('show_articles_under_category');
        $data['text_facebook'] = $this->language->get('text_facebook');
        $data['text_twitter'] = $this->language->get('text_twitter');
        $data['text_blog_heading_color'] = $this->language->get('text_blog_heading_color');
        $data['text_blog_description_color'] = $this->language->get('text_blog_description_color');
        $data['text_blog_heading_font_size'] = $this->language->get('text_blog_heading_font_size');
        $data['text_blog_description_font_size'] = $this->language->get('text_blog_description_font_size');
        $data['show_blog_comment_minmax_character'] = $this->language->get('show_blog_comment_minmax_character');
        $data['show_blog_comment_min_character'] = $this->language->get('show_blog_comment_min_character');
        $data['show_blog_comment_max_character'] = $this->language->get('show_blog_comment_max_character');

        $data['blog_large_image'] = $this->language->get('blog_large_image');
        $data['blog_small_image'] = $this->language->get('blog_small_image');
        $data['blog_related_image'] = $this->language->get('blog_related_image');

        $data['heading_title'] = $this->language->get('heading_title');

        $data['heading_settings'] = $this->language->get('heading_settings');

        $data['tab_general'] = $this->language->get('tab_general');
        $data['tab_option'] = $this->language->get('tab_option');
        $data['tab_image'] = $this->language->get('tab_image');
        $data['tab_color'] = $this->language->get('tab_color');
        $data['tab_social'] = $this->language->get('tab_social');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['blog_name'] = $this->language->get('blog_name');
        $data['seo_key'] = $this->language->get('seo_key');
        $data['text_yes'] = $this->language->get('text_yes');
        $data['text_no'] = $this->language->get('text_no');
        $data['blog_limit'] = $this->language->get('blog_limit');
        $data['show_description_limit'] = $this->language->get('show_description_limit');
        $data['text_width'] = $this->language->get('text_width');
        $data['text_height'] = $this->language->get('text_height');
        $data['text_app_id'] = $this->language->get('text_app_id');
        $data['text_secret_id'] = $this->language->get('text_secret_id');
        $data['text_message'] = $this->language->get('text_message');
        $data['text_deauthorize'] = $this->language->get('text_deauthorize');
        $data['text_authorize'] = $this->language->get('text_authorize');
        $data['text_connected'] = $this->language->get('text_connected');
        $data['text_disconnected'] = $this->language->get('text_disconnected');
        $data['text_date_format'] = $this->language->get('text_date_format');
        $data['text_date_format_example'] = $this->language->get('text_date_format_example');
        $data['show_category_limit'] = $this->language->get('show_category_limit');
        $data['twit_access_token'] = $this->language->get('twit_access_token');
        $data['twit_access_token_secret'] = $this->language->get('twit_access_token_secret');
        $data['show_category_description_limit'] = $this->language->get('show_category_description_limit');

        $data['entry_status'] = $this->language->get('entry_status');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['error_sitekey'])) {
            $data['error_sitekey'] = $this->error['error_sitekey'];
        } else {
            $data['error_sitekey'] = '';
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
            'text' => $this->language->get('blog_settings'),
            'href' => $this->url->link('module/blog/blog_settings', 'token=' . $this->session->data['token'], true)
        );



        $data['action'] = $this->url->link('module/blog/blog_settings', 'token=' . $this->session->data['token'], true);
        $data['authorize'] = $this->url->link('module/blog/blog_socialmedia', 'token=' . $this->session->data['token'], true);
        $data['deauthorize'] = $this->url->link('module/blog/blog_articles/deauthorize', 'token=' . $this->session->data['token'], true);


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

        if (isset($this->request->post['blog_seo_keyword'])) {
            $data['blog_seo_keyword'] = $this->request->post['blog_seo_keyword'];
        } else {
            $data['blog_seo_keyword'] = $this->config->get('blog_seo_keyword');
        }

        if (isset($this->request->post['blog_show_title'])) {
            $data['blog_show_title'] = $this->request->post['blog_show_title'];
        } else {
            $data['blog_show_title'] = $this->config->get('blog_show_title');
        }

        if (isset($this->request->post['blog_show_description'])) {
            $data['blog_show_description'] = $this->request->post['blog_show_description'];
        } else {
            $data['blog_show_description'] = $this->config->get('blog_show_description');
        }

        if (isset($this->request->post['blog_show_readmore'])) {
            $data['blog_show_readmore'] = $this->request->post['blog_show_readmore'];
        } else {
            $data['blog_show_readmore'] = $this->config->get('blog_show_readmore');
        }
        if (isset($this->request->post['blog_limit'])) {
            $data['blog_limit'] = $this->request->post['blog_limit'];
        } else {
            $data['blog_limit'] = $this->config->get('blog_limit');
        }

        if (isset($this->request->post['blog_show_description_limit'])) {
            $data['blog_show_description_limit'] = $this->request->post['blog_show_description_limit'];
        } else {
            $data['blog_show_description_limit'] = $this->config->get('blog_show_description_limit');
        }

        if (isset($this->request->post['blog_show_image'])) {
            $data['blog_show_image'] = $this->request->post['blog_show_image'];
        } else {
            $data['blog_show_image'] = $this->config->get('blog_show_image');
        }

        if (isset($this->request->post['blog_show_author'])) {
            $data['blog_show_author'] = $this->request->post['blog_show_author'];
        } else {
            $data['blog_show_author'] = $this->config->get('blog_show_author');
        }

        if (isset($this->request->post['blog_show_category'])) {
            $data['blog_show_category'] = $this->request->post['blog_show_category'];
        } else {
            $data['blog_show_category'] = $this->config->get('blog_show_category');
        }

        if (isset($this->request->post['blog_show_created_date'])) {
            $data['blog_show_created_date'] = $this->request->post['blog_show_created_date'];
        } else {
            $data['blog_show_created_date'] = $this->config->get('blog_show_created_date');
        }

        if (isset($this->request->post['blog_date_format'])) {
            $data['blog_date_format'] = $this->request->post['blog_date_format'];
        } else {
            $data['blog_date_format'] = $this->config->get('blog_date_format');
        }

        if (isset($this->request->post['blog_show_hits'])) {
            $data['blog_show_hits'] = $this->request->post['blog_show_hits'];
        } else {
            $data['blog_show_hits'] = $this->config->get('blog_show_hits');
        }

        if (isset($this->request->post['blog_show_comment_counter'])) {
            $data['blog_show_comment_counter'] = $this->request->post['blog_show_comment_counter'];
        } else {
            $data['blog_show_comment_counter'] = $this->config->get('blog_show_comment_counter');
        }

        if (isset($this->request->post['blog_show_limits_comments'])) {
            $data['blog_show_limits_comments'] = $this->request->post['blog_show_limits_comments'];
        } else {
            $data['blog_show_limits_comments'] = $this->config->get('blog_show_limits_comments');
        }

        if (isset($this->request->post['blog_show_auto_publish_comment'])) {
            $data['blog_show_auto_publish_comment'] = $this->request->post['blog_show_auto_publish_comment'];
        } else {
            $data['blog_show_auto_publish_comment'] = $this->config->get('blog_show_auto_publish_comment');
        }

        if (isset($this->request->post['blog_social_media_share'])) {
            $data['blog_social_media_share'] = $this->request->post['blog_social_media_share'];
        } else {
            $data['blog_social_media_share'] = $this->config->get('blog_social_media_share');
        }

        if (isset($this->request->post['blog_show_enable_recaptcha'])) {
            $data['blog_show_enable_recaptcha'] = $this->request->post['blog_show_enable_recaptcha'];
        } else {
            $data['blog_show_enable_recaptcha'] = $this->config->get('blog_show_enable_recaptcha');
        }

        if (isset($this->request->post['blog_show_recaptcha_sitekey'])) {
            $data['blog_recaptcha_sitekey'] = $this->request->post['blog_recaptcha_sitekey'];
        } else {
            $data['blog_recaptcha_sitekey'] = $this->config->get('blog_recaptcha_sitekey');
        }

        if (isset($this->request->post['blog_recaptcha_secretkey'])) {
            $data['blog_recaptcha_secretkey'] = $this->request->post['blog_recaptcha_secretkey'];
        } else {
            $data['blog_recaptcha_secretkey'] = $this->config->get('blog_recaptcha_secretkey');
        }

        if (isset($this->request->post['blog_large_image_width'])) {
            $data['blog_large_image_width'] = $this->request->post['blog_large_image_width'];
        } else {
            $data['blog_large_image_width'] = $this->config->get('blog_large_image_width');
        }

        if (isset($this->request->post['blog_large_image_height'])) {
            $data['blog_large_image_height'] = $this->request->post['blog_large_image_height'];
        } else {
            $data['blog_large_image_height'] = $this->config->get('blog_large_image_height');
        }

        if (isset($this->request->post['blog_small_image_width'])) {
            $data['blog_small_image_width'] = $this->request->post['blog_small_image_width'];
        } else {
            $data['blog_small_image_width'] = $this->config->get('blog_small_image_width');
        }

        if (isset($this->request->post['blog_small_image_height'])) {
            $data['blog_small_image_height'] = $this->request->post['blog_small_image_height'];
        } else {
            $data['blog_small_image_height'] = $this->config->get('blog_small_image_height');
        }

        if (isset($this->request->post['blog_related_image_height'])) {
            $data['blog_related_image_height'] = $this->request->post['blog_related_image_height'];
        } else {
            $data['blog_related_image_height'] = $this->config->get('blog_related_image_height');
        }

        if (isset($this->request->post['blog_related_image_width'])) {
            $data['blog_related_image_width'] = $this->request->post['blog_related_image_width'];
        } else {
            $data['blog_related_image_width'] = $this->config->get('blog_related_image_width');
        }

        if (isset($this->request->post['blog_auto_post_on_facebook'])) {
            $data['blog_auto_post_on_facebook'] = $this->request->post['blog_auto_post_on_facebook'];
        } else {
            $data['blog_auto_post_on_facebook'] = $this->config->get('blog_auto_post_on_facebook');
        }
        if (isset($this->request->post['blog_auto_post_on_twitter'])) {
            $data['blog_auto_post_on_twitter'] = $this->request->post['blog_auto_post_on_twitter'];
        } else {
            $data['blog_auto_post_on_twitter'] = $this->config->get('blog_auto_post_on_twitter');
        }
        if (isset($this->request->post['blog_facebook_app_id'])) {
            $data['blog_facebook_app_id'] = $this->request->post['blog_facebook_app_id'];
        } else {
            $data['blog_facebook_app_id'] = $this->config->get('blog_facebook_app_id');
        }
        if (isset($this->request->post['blog_facebook_app_secret'])) {
            $data['blog_facebook_app_secret'] = $this->request->post['blog_facebook_app_secret'];
        } else {
            $data['blog_facebook_app_secret'] = $this->config->get('blog_facebook_app_secret');
        }

        if (isset($this->request->post['blog_facebook_message'])) {
            $data['blog_facebook_message'] = $this->request->post['blog_facebook_message'];
        } else {
            $data['blog_facebook_message'] = $this->config->get('blog_facebook_message');
        }

        if (isset($this->request->post['blog_show_articles_under_category'])) {
            $data['blog_show_articles_under_category'] = $this->request->post['blog_show_articles_under_category'];
        } else {
            $data['blog_show_articles_under_category'] = $this->config->get('blog_show_articles_under_category');
        }

        if (isset($this->request->post['blog_show_category_limit'])) {
            $data['blog_show_category_limit'] = $this->request->post['blog_show_category_limit'];
        } else {
            $data['blog_show_category_limit'] = $this->config->get('blog_show_category_limit');
        }
        if (isset($this->request->post['blog_show_category_description_limit'])) {
            $data['blog_show_category_description_limit'] = $this->request->post['blog_show_category_description_limit'];
        } else {
            $data['blog_show_category_description_limit'] = $this->config->get('blog_show_category_description_limit');
        }
        if (isset($this->request->post['blog_twit_consumer_key'])) {
            $data['blog_twit_consumer_key'] = $this->request->post['blog_twit_consumer_key'];
        } else {
            $data['blog_twit_consumer_key'] = $this->config->get('blog_twit_consumer_key');
        }
        if (isset($this->request->post['blog_twit_consumer_secret'])) {
            $data['blog_twit_consumer_secret'] = $this->request->post['blog_twit_consumer_secret'];
        } else {
            $data['blog_twit_consumer_secret'] = $this->config->get('blog_twit_consumer_secret');
        }
        if (isset($this->request->post['blog_twit_access_token'])) {
            $data['blog_twit_access_token'] = $this->request->post['blog_twit_access_token'];
        } else {
            $data['blog_twit_access_token'] = $this->config->get('blog_twit_access_token');
        }
        if (isset($this->request->post['blog_twit_access_token_secret'])) {
            $data['blog_twit_access_token_secret'] = $this->request->post['blog_twit_access_token_secret'];
        } else {
            $data['blog_twit_access_token_secret'] = $this->config->get('blog_twit_access_token_secret');
        }
        if (isset($this->request->post['blog_heading_color'])) {
            $data['blog_heading_color'] = $this->request->post['blog_heading_color'];
        } else {
            $data['blog_heading_color'] = $this->config->get('blog_heading_color');
        }
        if (isset($this->request->post['blog_description_color'])) {
            $data['blog_description_color'] = $this->request->post['blog_description_color'];
        } else {
            $data['blog_description_color'] = $this->config->get('blog_description_color');
        }
        if (isset($this->request->post['blog_heading_font_size'])) {
            $data['blog_heading_font_size'] = $this->request->post['blog_heading_font_size'];
        } else {
            $data['blog_heading_font_size'] = $this->config->get('blog_heading_font_size');
        }
        if (isset($this->request->post['blog_description_font_size'])) {
            $data['blog_description_font_size'] = $this->request->post['blog_description_font_size'];
        } else {
            $data['blog_description_font_size'] = $this->config->get('blog_description_font_size');
        }
        if (isset($this->request->post['blog_comment_min_character'])) {
            $data['blog_comment_min_character'] = $this->request->post['blog_comment_min_character'];
        } else {
            $data['blog_comment_min_character'] = $this->config->get('blog_comment_min_character');
        }
        if (isset($this->request->post['blog_comment_max_character'])) {
            $data['blog_comment_max_character'] = $this->request->post['blog_comment_max_character'];
        } else {
            $data['blog_comment_max_character'] = $this->config->get('blog_comment_max_character');
        }

        $data['blog_facebook_access_token'] = $this->config->get('blog_facebook_access_token');
        $today_date = date('Y-m-d');
        $token_createDate = $this->config->get('blog_facebook_access_token_time');
        $days = (strtotime($today_date) - strtotime($token_createDate)) / (60 * 60 * 24);
        if ($days >= 60) {
            $data['blog_facebook_access_token'] = '';
            $this->model_setting_setting->editSetting('blog', $data);
            $data['error_access_token'] = $this->language->get('text_error_access_token');
            
        }
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('module/blog/blog_settings', $data));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'module/blog')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if ($this->request->post['blog_show_enable_recaptcha'] == 1) {
            if (($this->request->post['blog_recaptcha_sitekey'] == '') || ($this->request->post['blog_recaptcha_secretkey'] == '')) {
                $this->error['error_sitekey'] = $this->language->get('error_sitekey');
            }
        }

        return !$this->error;
    }

}
