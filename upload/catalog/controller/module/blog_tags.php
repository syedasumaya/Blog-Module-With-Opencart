<?php

class ControllerModuleBlogTags extends Controller {

    public function index($setting) {

        $this->load->language('module/blog_tags');

        $data['heading_title'] = $setting['name'];
        $data['text_error'] = $this->language->get('text_error');

        if (!$setting['limit']) {
            $setting['limit'] = 4;
        }
        $this->load->model('blog/blog');
        $this->load->model('tool/image');

        $data['tags'] = array();

        $tags = $this->model_blog_blog->getTags();

        foreach ($tags as $tag) {

            $data['tags'][] = array(
                'blog_id' => $tag['blog_id'],
                'blog_tags' => explode(',', $tag['blog_tags']),
                'limit' => $setting['limit'] - 1,
                'large_font' => $setting['large_font'],
                'small_font' => $setting['small_font'],
                'href' => $this->url->link('blog/singleblog', 'blog_id=' . $tag['blog_id'])
            );
        }


        $data['mainhref'] = $this->url->link('blog/blog');

        return $this->load->view('module/blog_tags', $data);
    }

}
