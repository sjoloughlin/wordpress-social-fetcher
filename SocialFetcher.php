<?php
if (!defined('ABSPATH')) { exit; }

include 'Twitter.php';
include 'Facebook.php';
include 'Instagram.php';

class SocialFetcher
{
  public $platforms = [];
  public $post_data = [];

  public function __construct($socialConfigs)
  {
    foreach ($socialConfigs as $socialName => $socialConfig) {
      if (!$socialConfig->isActive()) {
        continue;
      }

      $this->platforms[$socialName] = new $socialName($socialConfig);
    }
  }

  public function init()
  {
    foreach ($this->platforms as $platform) {
      $platform->init();
    }

    return $this;
  }

  public function fetch_data()
  {
    foreach ($this->platforms as $platform) {
      $platform->fetch_data();
    }

    return $this;
  }

  public function filter_data()
  {
    foreach ($this->platforms as $platform) {
      $platform->filter_data();
    }

    return $this;
  }

  public function get_data()
  {
    foreach ($this->platforms as $platform) {
      $this->post_data[get_class($platform)] = $platform->data;
    }

    return $this;
  }
}
