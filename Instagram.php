<?php
if (!defined('ABSPATH')) { exit; }

class Instagram
{
  protected $api_url = null;
  public $data = null;

  public function __construct($config)
  {
    $this->config = $config;
  }

  public function init()
  {
    $this->api_url = 'https://api.instagram.com/v1/users/'.$this->config->getConfig()['user_id'].'/media/recent/?access_token='.$this->config->getConfig()['access_token']; 
  }

  public function fetch_data()
  {
  	$c = curl_init($this->api_url);
  	curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
  	$response = json_decode(curl_exec($c));
  	curl_close($c);

  	$this->data = $response->data;
  }

  public function filter_data()
  {
    $data = [];

    foreach ($this->data as $ig_response) {

      if (!empty($ig_response) && $ig_response->caption) {

        ($ig_response->type === "video") ? $video = true : $video = false;

        array_push($data, [
          "text" => $ig_response->caption->text,
          "datetime" => $ig_response->created_time,
          "image" => $ig_response->images->standard_resolution->url,
          "link" => $ig_response->link,
          "video" => $video
        ]);
      }
    }

    $this->data = $data;
  }
}
