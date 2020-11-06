<?php
if (!defined('ABSPATH')) { exit; }

class InstagramConfig extends SocialConfig
{
  public function __construct()
  {
    $this->setConfig([
      'is_enabled'   => get_option('initiate_instagram'),
      'access_token' => get_option('instagram_access'),
      'user_id'      => get_option('instagram_userid')
    ]);
  }
}
