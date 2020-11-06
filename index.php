<?php
/*
Plugin Name: Social Fetcher
Description: Social Fetcher collects recent posts from Facebook, Twitter and Instagram.
Version: 1.0
Author: Stephen O'Loughlin
Author URI: TBC
Text Domain: social-fetcher
*/

if (!defined('ABSPATH')) { exit; }

include 'SocialFetcherConf.php';
include 'PostFetcher.php';

register_activation_hook(__FILE__, [SFSetup::get_instance(), 'plugin_activated']);
register_deactivation_hook(__FILE__, [SFSetup::get_instance(), 'plugin_deactivated']);

add_action('plugins_loaded', [SFSetup::get_instance(), 'plugin_setup']);

class SFSetup
{
  protected static $instance = null;
  public static $SocialFetcherConf = null;

  public function __construct()
  {
    if (null === self::$SocialFetcherConf) {
      self::$SocialFetcherConf = new SocialFetcherConf();
    }

    if (isset($_GET['settings-updated'])) {
      $this->update_cron();
    }
  }

  public static function get_instance()
  {
    if (null === self::$instance) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  public function plugin_setup()
  {
    add_action('social_fetcher_fetch', [$this, 'update_sf_posts']);
  }

  public function plugin_activated()
  {
    if (!wp_next_scheduled('social_fetcher_fetch')) {
      if (wp_schedule_event(time(), 'frequency', 'social_fetcher_fetch')) {
        $this->update_sf_posts();
      }
    }
  }

  public function update_cron()
  {
    wp_clear_scheduled_hook('social_fetcher_fetch');
    wp_schedule_event(time(), 'frequency', 'social_fetcher_fetch');
  }

  public static function plugin_deactivated()
  {
    wp_clear_scheduled_hook('social_fetcher_fetch');
  }

  public function update_sf_posts()
  {
    $post_fetcher = (new PostFetcher())->init();
  }
}
