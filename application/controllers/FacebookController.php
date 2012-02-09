<?php

class FacebookController extends Zend_Controller_Action
{
    const CLIENT_ID = '341769282522679';
    const CLIENT_SECRET = '9c0d0f4de1fcacbfdff53489c58355a1';

    public function init()
    {
        $this->view->CLIENT_ID = self::CLIENT_ID;
        $this->view->CLIENT_SECRET = self::CLIENT_SECRET;

        $this->session = new Zend_Session_Namespace('OAUTH2');
        if (!isset($this->session->services)) {
            $this->session->services = array();
        }
    }

    public function indexAction()
    {
        $isAuthorized = $this->_isAuthorized();
        $this->view->isAuthorized = $isAuthorized;

        if ($isAuthorized) {
            $this->view->me = $this->_fetchData('/me');
            $this->view->photos = $this->_fetchData('/me/photos');
        }
    }

    public function callbackAction()
    {
        $code = $this->_getParam('code');   // see 4.1.2. of OAuth 2.0 draft 23
        $error = $this->_getParam('error'); // see 4.1.2.1. of OAuth 2.0 draft 23

        $this->view->status = false;
        if (!empty($error)) { // eg. 'access_denied' when user fails to confirm app
            return;
        }

        $token = $this->_requestToken($code);

        if ($token) {
            $this->session->services['facebook'] = $token;
            $this->view->status = true;
        } else { // error obtaining token
            $this->view->status = false;
        }

    }

    /**
     * Check whether user is already authorized
     *
     * @return boolean Authorization status
     *
     */
    protected function _isAuthorized()
    {
        if (isset($this->session->services['facebook'])) {
            return true;
        }
        return false;
    }

    /**
     * Request OAuth access token.
     *
     * @param string $code OAuth code we got from service.
     * @return string Token, or null if we didn't obtain a proper token
     */
    protected function _requestToken($code) {
        $client = new Zend_Http_Client();
        $client->setUri('https://graph.facebook.com/oauth/access_token');

        $queryParams = array(
            'client_id'     => self::CLIENT_ID,
            'client_secret' => self::CLIENT_SECRET,
            'redirect_uri'  => 'http://oauth2.local'
                                . $this->view->url(array('controller' => 'facebook', 'action' => 'callback')),
            'code'          => $code
        );

        $client->setParameterGet($queryParams);

        echo "<h3>We then made asynchronous request to this Facebook URL:</h3>";
        Zend_Debug::dump($client->getUri(true) . '?');
        Zend_Debug::dump($queryParams);

        try {
            $response = $client->request('POST');
        } catch (Zend_Http_Client_Exception $e) {  // timeout or host not accessible
            return;
        }

        // error in response
        if ($response->isError()) {
            return;
        }

        echo "<h3>This is what Facebook returned to this request:</h3>";
        Zend_Debug::dump($response->getBody());

        $result = array();
        parse_str($response->getBody(), $result);
        if (isset($result['access_token'])) {
            $token = $result['access_token'];
            echo "<h3>And we parsed this access_token, which we then stored to session:</h3>";
            Zend_Debug::dump($token);
            echo "<h3>Voilà, now return to the main page!</h3>";
            return $token;
        }
        return;
    }


    protected function _fetchData($endpoint) {
        $client = new Zend_Http_Client();
        $client->setUri('https://graph.facebook.com' . $endpoint);

        $queryParams = array(
                        'access_token' => $this->session->services['facebook']
                       );

        $client->setParameterGet($queryParams);

        try {
            $response = $client->request();
        } catch (Zend_Http_Client_Exception $e) {  // timeout or host not accessible
            return;
        }
        // error in response
        if ($response->isError()) return;

        // parse JSON data
        $data = Zend_Json::decode($response->getBody());

        return $data;

    }

}



