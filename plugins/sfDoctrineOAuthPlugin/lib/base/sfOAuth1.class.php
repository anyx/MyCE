<?php
/**
 *
 *
 *
 * Implementation of OAuth version 1
 *
 * @author Maxime Picaud
 * @since 21 août 2010
 */
class sfOAuth1 extends sfOAuth
{
  /**
   *
   * contains consumer_key and consumer_secret
   * @var OAuthConsumer $consumer
   */
  protected $consumer;

  /**
   *
   * url to request token
   * @var string $request_token_url
   */
  protected $request_token_url;

  /**
   * parameters passed for each api request.
   *
   * @var array $parameters
   */
  protected $request_parameters = array();

  /**
   * Constructor - set version = 1
   *
   * @author Maxime Picaud
   * @since 21 août 2010
   */
  public function __construct($key, $secret, $token = null, $config = array())
  {
    $this->version = 1;

    $this->init($config, 'request_token_url');
    $this->init($config, 'consumer');
    $this->init($config, 'request_parameters', 'add');

    parent::__construct($key, $secret, $token, $config);
  }

  /**
   * getter $consumer
   *
   * @return OAuthConsumer
   *
   * @author Maxime Picaud
   * @since 21 août 2010
   */
  public function getConsumer()
  {
    if(is_null($this->consumer))
    {
      $this->consumer = new OAuthConsumer($this->getKey(), $this->getSecret());
    }

    return $this->consumer;
  }

  /**
   *
   * @param OAuthConsumer $consumer
   *
   * setter $consumer
   *
   * @author Maxime Picaud
   * @since 21 août 2010
   */
  public function setConsumer(OAuthConsumer $consumer)
  {
    $this->consumer = $consumer;
  }

  /**
   * getter $request_token_url
   *
   * @return string
   *
   * @author Maxime Picaud
   * @since 21 août 2010
   */
  public function getRequestTokenUrl()
  {
    return $this->request_token_url;
  }

  /**
   *
   * @param string $request_token_url
   *
   * setter $request_token_url
   *
   * @author Maxime Picaud
   * @since 21 août 2010
   */
  public function setRequestTokenUrl($request_token_url)
  {
    $this->request_token_url = $request_token_url;
  }

  /**
   *
   * retrieve the request token
   *
   * @return Token
   *
   * @author Maxime Picaud
   * @since 21 août 2010
   */
  public function getRequestToken($parameters = array())
  {
    $this->addRequestParameters($parameters);
    $this->setRequestParameter('oauth_callback', $this->getCallback());

    $request = OAuthRequest::from_consumer_and_token($this->getConsumer(), $this->getToken('oauth'), 'POST', $this->getRequestTokenUrl(), $this->getRequestParameters());
    $request->sign_request(new OAuthSignatureMethod_HMAC_SHA1(), $this->getConsumer(), $this->getToken('oauth'));

    $params = OAuthUtil::parse_parameters($this->call($this->getRequestTokenUrl(), $request->to_postdata()));

    $oauth_token = isset($params['oauth_token'])?$params['oauth_token']:null;
    $oauth_token_secret = isset($params['oauth_token_secret'])?$params['oauth_token_secret']:null;

    if((is_null($oauth_token) || is_null($oauth_token_secret)) && $this->getLogger())
    {
      $error = sprintf('{OAuth} access token failed - %s returns %s', $this->getName(), print_r($params, true));
      $this->getLogger()->err($error);
    }
    elseif($this->getLogger())
    {
      $message = sprintf('{OAuth} %s return %s', $this->getName(), print_r($params, true));
      $this->getLogger()->info($message);
    }

    $token = new Token();
    $token->setTokenKey($oauth_token);
    $token->setTokenSecret($oauth_token_secret);
    $token->setName($this->getName());
    $token->setStatus(Token::STATUS_REQUEST);
    $token->setOAuthVersion($this->getVersion());

    unset($params['oauth_token'], $params['oauth_token_secret']);
    if(count($params) > 0)
    {
      $token->setParams($params);
    }

    $this->setToken($token);

    return $token;
  }

  /**
   * (non-PHPdoc)
   * @see plugins/sfDoctrineOAuthPlugin/lib/sfOAuth::requestAuth()
   */
  public function requestAuth($parameters = array())
  {
    if(is_null($this->getToken()))
    {
      throw new sfException(sprintf('there is no available token to request auth in "%s" oauth', $this->getName()));
    }

    if($this->getController())
    {
      $this->setAuthParameter('oauth_token', $this->getToken()->getTokenKey());
      $this->addAuthParameters($parameters);
      $url = $this->getRequestAuthUrl().'?'.http_build_query($this->getAuthParameters());

      if($this->getLogger())
      {
        $this->getLogger()->info(sprintf('{OAuth} "%s" call url "%s" with params "%s"',
                                         $this->getName(),
                                         $this->getRequestAuthUrl(),
                                         var_export($this->getAuthParameters(), true)
                                        )
                                 );
      }

      $this->getController()->redirect($url);
    }
    else
    {
      if($this->getLogger())
      {
        $this->getLogger()->err(sprintf('{OAuth} "%s" no controller to execute the request', $this->getName()));
      }
    }
  }

  /**
   * (non-PHPdoc)
   * @see plugins/sfDoctrineOAuthPlugin/lib/sfOAuth::getAccessToken()
   */
  public function getAccessToken($verifier, $parameters = array())
  {
    $this->setAccessParameter('oauth_verifier', $verifier);
    $this->addAccessParameters($parameters);

    $request = OAuthRequest::from_consumer_and_token($this->getConsumer(), $this->getToken('oauth'), 'POST', $this->getAccessTokenUrl(), $this->getAccessParameters());
    $request->sign_request(new OAuthSignatureMethod_HMAC_SHA1(), $this->getConsumer(), $this->getToken('oauth'));

    $params = OAuthUtil::parse_parameters($this->call($this->getAccessTokenUrl(), $request->to_postdata()));

    $oauth_token = isset($params['oauth_token'])?$params['oauth_token']:null;
    $oauth_token_secret = isset($params['oauth_token_secret'])?$params['oauth_token_secret']:null;

    if((is_null($oauth_token) || is_null($oauth_token_secret)) && $this->getLogger())
    {
      $error = sprintf('{OAuth} access token failed - %s returns %s', $this->getName(), print_r($params, true));
      $this->getLogger()->err($error);
    }
    elseif($this->getLogger())
    {
      $message = sprintf('{OAuth} %s return %s', $this->getName(), print_r($params, true));
      $this->getLogger()->info($message);
    }

    $token = new Token();
    $token->setTokenKey($oauth_token);
    $token->setTokenSecret($oauth_token_secret);
    $token->setName($this->getName());
    $token->setStatus(Token::STATUS_ACCESS);
    $token->setOAuthVersion($this->getVersion());

    unset($params['oauth_token'], $params['oauth_token_secret']);
    if(count($params) > 0)
    {
      $token->setParams($params);
    }

    $this->setExpire($token);

    //override request_token
    $this->setToken($token);

    $token->setIdentifier($this->getIdentifier());
    $this->setToken($token);

    return $token;
  }

  protected function prepareCall($action, $aliases = null, $params = array(), $method = 'GET')
  {
    if(in_array($method, array('GET', 'POST')))
    {
      $this->addCallParameters($params);
    }
    else
    {
      $method = 'POST';
    }

    $url = $this->formatUrl($action, $aliases);

    $request = OAuthRequest::from_consumer_and_token($this->getConsumer(), $this->getToken('oauth'), $method, $url, $this->getCallParameters());
    $request->sign_request(new OAuthSignatureMethod_HMAC_SHA1(), $this->getConsumer(), $this->getToken('oauth'));

    return array($url, $request);
  }

  /**
   * overriden for OAuth 1
   *
   * @author Maxime Picaud
   * @since 19 août 2010
   */
  public function get($action, $aliases = null, $params = array())
  {
    list($url, $request) = $this->prepareCall($action, $aliases, $params, 'GET');
    $response = $this->call($request->to_url(), null, null, 'GET');

    return $this->formatResult($response);
  }

  public function post($action, $aliases = null, $params = array())
  {
    list($url, $request) = $this->prepareCall($action, $aliases, $params, 'POST');
    $this->setCallParameters($request->to_postdata());
    $response = $this->call($url, $this->getCallParameters(), null, 'POST');

    return $this->formatResult($response);
  }

  public function put($action, $aliases = null, $params = array())
  {
    list($url, $request) = $this->prepareCall($action, $aliases, $params, 'PUT');
    $this->setCallParameters($request->to_postdata());
    $response = $this->call($url, $this->getCallParameters(), $params, 'PUT');

    return $this->formatResult($response);
  }

  public function delete($action, $aliases = null, $params = array())
  {
    list($url, $request) = $this->prepareCall($action, $aliases, $params, 'DELETE');
    $this->setCallParameters($request->to_postdata());
    $response = $this->call($url, $this->getCallParameters(), $params, 'DELETE');

    return $this->formatResult($response);
  }

  /**
   *
   * @param array $parameters
   *
   * setter $parameters
   *
   * @author Maxime Picaud
   * @since 21 août 2010
   */
  public function setRequestParameters($parameters)
  {
    $this->request_parameters = $parameters;
  }

  /**
   *
   * @param mixed $key
   * @param mixed $value
   *
   * set a parameter
   *
   * @author Maxime Picaud
   * @since 21 août 2010
   */
  public function setRequestParameter($key, $value)
  {
    $this->request_parameters[$key] = $value;
  }

  /**
   * getter $parameters
   *
   * @return array
   *
   * @author Maxime Picaud
   * @since 21 août 2010
   */
  public function getRequestParameters()
  {
    return $this->request_parameters;
  }

  /**
   *
   * @param mixed $key
   * @param mixed $default
   *
   * Retrieve a parameter by its key and return $default if is undefined
   *
   * @return mixed
   *
   * @author Maxime Picaud
   * @since 21 août 2010
   */
  public function getRequestParameter($key, $default = null)
  {
    return isset($this->request_parameters[$key])?$this->request_parameters[$key]:$default;
  }

  /**
   *
   * @param array $parameters
   *
   * merge current parameters with this $parameters
   *
   * @author Maxime Picaud
   * @since 21 août 2010
   */
  public function addRequestParameters($parameters)
  {
    $this->request_parameters = array_merge($this->request_parameters, $parameters);
  }
}