<?php
if (!defined('ABSPATH')) { exit; }

class Facebook
{
  protected $api_url = null;
  public $data = null;

  public function __construct($config)
  {
    $this->config = $config;
  }

  public function init()
  {
    $this->api_url = 'https://graph.facebook.com/'.$this->config->getConfig()['user_id'].'/posts?limit=10&fields=message,full_picture,status_type,created_time,link&access_token=';
    $this->api = $this->api_url.$this->config->getConfig()['app_id'];
  }

  public function fetch_data()
  {
    $c = curl_init($this->api);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    $response = json_decode(curl_exec($c));
    curl_close($c);

    $this->data = $response->data;
  }

  public function filter_data()
  {
    $data = [];

    foreach ($this->data as $fb_response) {

      if (!empty($fb_response) && isset($fb_response->message) && $fb_response->status_type !== 'added_video' && $fb_response->status_type !== 'shared_story') {

        $image = null;
        $link = null;

        if (isset($fb_response->full_picture) && !(strpos($fb_response->full_picture, 'safe_image.php')) && $fb_response->link) {
          $image = $fb_response->full_picture;
          $link = $fb_response->link;
        }

        if ($this->config->getConfig()['facebook_only_images']) {

          if ($image && !(strpos($image, 'safe_image.php')) && $link) {
            array_push($data, [
              "text" => $fb_response->message,
              "datetime" => $fb_response->created_time,
              "image" => $image,
              "link" => $link
            ]);
          }

          continue;
        }

        array_push($data, [
          "text" => $fb_response->message,
          "datetime" => $fb_response->created_time,
          "image" => $image,
          "link" => $link
        ]);
      }
    }

    $this->data = $data;
  }
}
