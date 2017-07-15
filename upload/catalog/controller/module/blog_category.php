<?php

class ControllerModuleBlogcategory extends Controller {

    public function index($setting) {

        $this->load->language('module/blog_category');

        $data['heading_title'] = $setting['name'];

        if (!$setting['limit']) {
            $setting['limit'] = 4;
        }
        $this->load->model('blog/blog');

        $data['categories'] = array();

        if (!empty($setting['category'])) {
            $categories = array_slice($setting['category'], 0, (int) $setting['limit']);

            foreach ($categories as $category_id) {

                $category = $this->model_blog_blog->getCategory($category_id);

                $data['categories'][] = array(
                    'blog_category_id' => $category['blog_category_id'],
                    'blog_category_name' => $category['blog_category_name'],
                    'href' => $this->url->link('blog/blog', 'category=' . $category['blog_category_id'])
                );
            }

            $data['mainhref'] = $this->url->link('blog/categories');
        }
        return $this->load->view('module/blog_category', $data);
    }

}
