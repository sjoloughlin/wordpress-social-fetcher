<?php
if (!defined('ABSPATH')) { exit; }

require_once('TwitterAPIExchange.php');

class Twitter
{
  protected $api_url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
  protected $api_params = null;
  public $data = null;

  public function __construct($config)
  {
    $this->config = $config;
  }

  public function init()
  {
    $this->api_params = '?screen_name='.$this->config->getConfig()['display_name'].'&exclude_replies=true&include_rts=false&include_entities=true&count=100&tweet_mode=extended';
    $this->api = new TwitterAPIExchange($this->config->getConfig());
  }

  public function fetch_data()
  {
    $response = $this->api
      ->setGetfield($this->api_params)
      ->buildOauth($this->api_url, 'GET')
      ->performRequest();

    $this->data = json_decode($response);
  }

  public function filter_data()
  {
    $data = [];

    foreach ($this->data as $tw_response) {

      $post_image = null;

      if (isset($tw_response->entities->media)) {
        foreach ($tw_response->entities->media as $media) {
          $post_image = $media->media_url;
        }
      }

      if ($this->config->getConfig()['twitter_only_images']) {

        if (isset($tw_response->entities->media)) {
          array_push($data, [
            "text" => $tw_response->full_text,
            "datetime" => $tw_response->created_at,
            "image" => $post_image,
            "link" => 'https://twitter.com/' . $tw_response->user->screen_name . '/status/' . $tw_response->id
          ]);
        }

        continue;
      }

      array_push($data, [
        "text" => $tw_response->full_text,
        "datetime" => $tw_response->created_at,
        "image" => $post_image,
        "link" => 'https://twitter.com/' . $tw_response->user->screen_name . '/status/' . $tw_response->id
      ]);
    }

    $this->data = $data;
  }
}
