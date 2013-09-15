<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

require_once(APPPATH."libraries/analytics-php/lib/Analytics.php");

class Segmentio
{
  public $CI;
  public $input;
  public $headers;

  public $API_key;
  public $secret;

  public function __construct()
  {
    $this->CI =& get_instance();
    $this->input =& $this->CI->input;

    $segment_config = $this->CI->config->item('segmentio');
    $this->API_key = $segment_config['API_key'];
    $this->secret = $segment_config['secret'];

    Analytics::init($this->secret);
  }

  public function identify($user_id, $properties = array(), $additional_context = array())
  {
    $context = array(
      'userAgent' => $this->input->user_agent(),
      'ip' => $this->input->ip_address()
    );
    $context = array_merge($context, $additional_context);

    Analytics::identify($user_id, $properties, null, $context);
  }
}

?>
