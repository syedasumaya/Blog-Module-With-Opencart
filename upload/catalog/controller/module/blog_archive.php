<?php

class ControllerModuleBlogArchive extends Controller {

    public function index($setting) {

        $this->load->language('module/blog_archive');

        $data['heading_title'] = $setting['name'];

        if (!$setting['limit']) {
            $setting['limit'] = 4;
        }
        $this->load->model('blog/blog');

        $data['archive'] = array();

        $data['limit'] = $setting['limit'];
        $data['mainhref'] = $this->url->link('blog/blog');

        return $this->load->view('module/blog_archive', $data);
    }

}
