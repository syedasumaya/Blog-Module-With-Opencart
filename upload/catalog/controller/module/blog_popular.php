<?php

class ControllerModuleBlogpopular extends Controller {

    public function index($setting) {

        $this->load->language('module/blog_popular');

        $data['heading_title'] = $setting['name'];

        if (!$setting['limit']) {
            $setting['limit'] = 4;
        }
        $this->load->model('blog/blog');

        $data['featured'] = array();

        $popular = $this->model_blog_blog->getPopular($setting);

        foreach ($popular as $pop) {

            $data['popular'][] = array(
                'blog_id' => $pop['blog_id'],
                'blog_title' => $pop['blog_title'],
                'href' => $this->url->link('blog/singleblog', 'blog_id=' . $pop['blog_id'])
            );
        }

        $data['mainhref'] = $this->url->link('blog/blog');

        return $this->load->view('module/blog_popular', $data);
    }

}
