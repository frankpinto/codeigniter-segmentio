<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

require_once(APPPATH."libraries/analytics-php/lib/Analytics.php");

class Segmentio
{
  public $CI;
  public $input;
  public $headers;
  public $context;

  public $API_key;
  public $secret;

  public function __construct()
  {
    $this->CI =& get_instance();
    $this->input =& $this->CI->input;

    $segment_config = $this->CI->config->item('segmentio');
    $this->API_key = $segment_config['API_key'];
    $this->secret = $segment_config['secret'];
    $this->context = array(
      'userAgent' => $this->input->user_agent(),
      'ip' => $this->input->ip_address()
    );

    Analytics::init($this->secret);
  }

  public function identify($user_id, $traits = array(), $timestamp = NULL, $context = array())
  {
    $phone = NULL;
    if (isset($headers['X-MSISDN']) && $headers['X-MSISDN'])
      $phone = $headers['X-MSISDN'];
    elseif (isset($headers['X-WAP-Network-Client-MSISDN']) && $headers['X-WAP-Network-Client-MSISDN'])
      $phone = $headers['X-WAP-Network-Client-MSISDN'];
    
    if (!isset($traits['phone']) && $phone)
      $traits['phone'] = $phone;

    $context = array_merge($this->context, $context);

    Analytics::identify($user_id, $traits, $timestamp, $context);
  }

  public function track($user_id, $event, $properties = NULL, $timestamp = NULL, $context = array())
  {
    // Server-side page views
    if ($event == 'Loaded a Page')
    {
      $additional_properties = array('url' => $_SERVER['REQUEST_URI']);
      if (isset($_SERVER['HTTP_REFERER']))
      {
        $additional_properties['referer'] = $_SERVER['HTTP_REFERER'];
        $additional_properties['referrer'] = $_SERVER['HTTP_REFERER'];
      }

      if ($properties)
        $properties = array_merge($properties, $additional_properties);
      else
        $properties = $additional_properties;
    }

    $context = array_merge($this->context, $context);

    Analytics::track($user_id, $event, $properties, $timestamp, $context);
  }
}

?>
