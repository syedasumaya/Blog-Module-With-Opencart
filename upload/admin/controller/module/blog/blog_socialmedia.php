<?php
class ControllerModuleBlogBlogSocialmedia extends Controller {

    private $error = array();

    public function index() {

        require_once __DIR__ . '/facebook-php-sdk-v4-5.0.0/src/Facebook/autoload.php';

        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            $data['base'] = $this->config->get('config_ssl');
        } else {
            $data['base'] = $this->config->get('config_url');
        }

        $fbData = array(
            'app_id' => $this->config->get('blog_facebook_app_id'),
            'app_secret' => $this->config->get('blog_facebook_app_secret'),
            'default_graph_version' => 'v2.5',
        );

        $fb = new Facebook\Facebook($fbData);

        $params = array('req_perms' => 'publish_actions');
        $helper = $fb->getRedirectLoginHelper();
        $loginUrl = $this->response->redirect($helper->getLoginUrl($data['base'] . "index.php?route=blog/callback", $params));
    }

}
