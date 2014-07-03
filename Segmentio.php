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
  public $track;

  public function __construct($params)
  {
    if (isset($params[0]))
      $track = $params[0];
    else
      $track = TRUE;

    if (isset($params[1]))
      $config = $params[1];
    else
      $config = NULL;

    $this->CI =& get_instance();
    $this->input =& $this->CI->input;

    $this->headers = $this->input->request_headers();

    $this->track = $track;
    if (!$this->track)
      return;

    if (empty($config))
      $segment_config = $this->CI->config->item('segmentio');
    else
      $segment_config = $config;
    $this->API_key = $segment_config['API_key'];
    $this->secret = $segment_config['secret'];
    $this->context = array(
      'userAgent' => $this->input->user_agent(),
      'ip' => $this->input->ip_address()
    );

    //Analytics::init($this->secret);
  }

  public function identify($user_id, $traits = array(), $timestamp = NULL, $context = array())
  {
    return;

    if ($this->track)
    {
      $context = array_merge($this->context, $context);

      Analytics::identify($user_id, $traits, $timestamp, $context);
    }
  }

  public function track($user_id, $event, $properties = NULL, $timestamp = NULL, $context = array())
  {
    return;

    if ($this->track)
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
}

?>
