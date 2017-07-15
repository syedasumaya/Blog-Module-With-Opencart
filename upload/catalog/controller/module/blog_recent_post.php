<?php

class ControllerModuleBlogRecentPost extends Controller {

    public function index($setting) {

        $this->load->language('module/blog_recent_post');

        $data['heading_title'] = $setting['name'];

        if (!$setting['limit']) {
            $setting['limit'] = 4;
        }
        $this->load->model('blog/blog');

        $data['recentpost'] = array();

        $recentpost = $this->model_blog_blog->getRecentPost($setting['limit']);

        foreach ($recentpost as $post) {

            $data['recentpost'][] = array(
                'blog_id' => $post['blog_id'],
                'blog_title' => $post['blog_title'],
                'href' => $this->url->link('blog/singleblog', 'blog_id=' . $post['blog_id'])
            );
        }

        $data['mainhref'] = $this->url->link('blog/blog');

        return $this->load->view('module/blog_recent_post', $data);
    }

}
