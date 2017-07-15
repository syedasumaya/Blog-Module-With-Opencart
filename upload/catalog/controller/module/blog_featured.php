<?php

class ControllerModuleBlogfeatured extends Controller {

    public function index($setting) {

        $this->load->language('module/blog_featured');

        $data['heading_title'] = $setting['name'];
        $data['text_hits'] = $this->language->get('text_hits');
        $data['text_comments'] = $this->language->get('text_comments');

        if (!$setting['limit']) {
            $setting['limit'] = 4;
        }
        $this->load->model('blog/blog');
        $this->load->model('tool/image');

        $data['featured'] = array();

        $featured = $this->model_blog_blog->getFeatured($setting['limit']);
        //print_r($featured);exit;
        foreach ($featured as $feat) {

            if ($feat['blog_image']) {
                $image = $this->model_tool_image->resize($feat['blog_image'], $setting['width'], $setting['height']);
            } else {
                $image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
            }
            $data['featured'][] = array(
                'blog_id' => $feat['blog_id'],
                'blog_title' => $feat['blog_title'],
                'thumb' => $image,
                'blog_comments' => $feat['blog_comments'],
                'blog_hits' => $feat['blog_hits'],
                'blog_description' => utf8_substr(strip_tags(html_entity_decode($feat['blog_description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('blog_show_description_limit')) . '..',
                'settings_blog_hits' => $this->config->get('blog_show_hits'),
                'settings_blog_show_comment_counter' => $this->config->get('blog_show_comment_counter'),
                'blog_hits' => $feat['blog_hits'],
                'href' => $this->url->link('blog/singleblog', 'blog_id=' . $feat['blog_id'])
            );
        }


        $data['mainhref'] = $this->url->link('blog/blog');

        return $this->load->view('module/blog_featured', $data);
    }

}
