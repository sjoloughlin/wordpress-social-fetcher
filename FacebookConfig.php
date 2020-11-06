<?php
if (!defined('ABSPATH')) { exit; }

class FacebookConfig extends SocialConfig
{
  public function __construct()
  {
    $this->setConfig([
      'is_enabled'           => get_option('initiate_facebook'),
      'app_id'               => get_option('facebook_appid'),
      'app_secret'           => get_option('facebook_appsecret'),
      'user_id'               => get_option('facebook_user_id'),
      'facebook_only_images' => get_option('facebook_only_images')
    ]);
  }
}
