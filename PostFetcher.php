<?php
if (!defined('ABSPATH')) { exit; }

include 'SocialConfig.php';
include 'SocialFetcher.php';
include 'WPManager.php';

class PostFetcher
{
  public $SocialFetcher = null;

  public function __construct()
  {
    $config = [
      'Twitter'   => new TwitterConfig(),
      'Facebook'  => new FacebookConfig(),
      'Instagram' => new InstagramConfig()
    ];

    $this->SocialFetcher = new SocialFetcher($config);
  }

  public function init()
  {
    $this->SocialFetcher->init()
      ->fetch_data()
      ->filter_data()
      ->get_data();

    $this->implementWP();
  }

  public function implementWP()
  {
    $wp_manager = (new WPManager($this->SocialFetcher->platforms, $this->SocialFetcher->post_data))->init();
  }
}
