<?php
if (!defined('ABSPATH')) { exit; }

class TwitterConfig extends SocialConfig
{
  public function __construct()
  {
    $this->setConfig([
      'is_enabled'                => get_option('initiate_twitter'),
      'oauth_access_token'        => get_option('twitter_token'),
      'oauth_access_token_secret' => get_option('twitter_token_secret'),
      'consumer_key'              => get_option('twitter_consumer_key'),
      'consumer_secret'           => get_option('twitter_consumer_secret'),
      'display_name'              => get_option('twitter_display_name'),
      'twitter_only_images'       => get_option('twitter_only_images')
    ]);
  }
}
