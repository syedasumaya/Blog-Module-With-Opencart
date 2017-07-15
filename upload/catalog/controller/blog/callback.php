<?php
require_once __DIR__ . '/facebook-php-sdk-v4-5.0.0/src/Facebook/autoload.php';

class ControllerBlogCallback extends Controller {

    public function index() {

        
        $this->load->model('blog/blog');


        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            $data['base'] = $this->config->get('config_ssl');
        } else {
            $data['base'] = $this->config->get('config_url');
        }

        $fbData = array(
            'app_id' => $this->config->get('blog_facebook_app_id'),
            'app_secret' => $this->config->get('blog_facebook_app_secret'),
            'default_graph_version' => 'v2.2'
        );
        $fb = new Facebook\Facebook($fbData);

        $helper = $fb->getRedirectLoginHelper();
        try {
            $accessToken = $helper->getAccessToken();

            $oAuth2Client = $fb->getOAuth2Client();
            //$fb->setExtendedAccessToken(); 
            $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($accessToken); 
            $data['store_id'] = $this->config->get('config_store_id');
            $this->model_blog_blog->saveAccessToken($longLivedAccessToken, $data['store_id']);
            // this token will be valid for next 2 hours  
            $this->response->redirect($data['base'] . "admin/index.php?route=module/blog/blog_settings&token=" . $this->session->data['token']);
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }

}
