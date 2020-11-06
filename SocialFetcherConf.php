<?php
if (!defined('ABSPATH')) { exit; }

class SocialFetcherConf
{
  public $menu_id = null;
  public $tax_term_ids = null;

  public function __construct()
  {
    add_action('admin_menu', [$this, 'add_admin_menu']);
    add_action('admin_init', [$this, 'sf_save_settings']);
    $this->capability = apply_filters('social_fetcher_cap', 'manage_options');

    if (!post_type_exists('socialfeed')) {
      $this->register_posttype();
      $this->register_taxonomy();
      $this->add_taxonomies();
    }

    add_filter('cron_schedules', [$this, 'cron_schedule']);
  }

  public function cron_schedule($schedules)
  {
    $interval_seconds = null;

    switch (get_option('time_interval')) {
      case 1:
        $interval_seconds = 60;
        break;
      case 5:
        $interval_seconds = 300;
        break;
      case 15:
        $interval_seconds = 900;
        break;
      case 60:
        $interval_seconds = 3600;
        break;
      case 120:
        $interval_seconds = 7200;
        break;
      case 180:
        $interval_seconds = 10800;
        break;
      case 1440:
        $interval_seconds = 86400;
        break;
      default:
        $interval_seconds = 10800;
    }

    $schedules['frequency'] = [
      'interval' => $interval_seconds,
      'display' => __('User set schedule')
    ];

    return $schedules;
  }

  public function add_admin_menu()
  {
    $this->menu_id = add_management_page(
      'Social Fetcher',
      'Social Fetcher',
      $this->capability,
      'social-fetcher',
      [$this, 'sf_settings_page']
    );
  }

  public function sf_settings_page()
  {
    $path = trailingslashit(dirname(__FILE__));
    if (!file_exists($path . 'options.php')) {
      return false;
    }
    require_once($path . 'options.php');
  }

  public function sf_save_settings()
  {
    register_setting('socialFetcher', 'initiate_facebook');
    register_setting('socialFetcher', 'initiate_twitter');
    register_setting('socialFetcher', 'initiate_instagram');
    register_setting('socialFetcher', 'facebook_only_images');
    register_setting('socialFetcher', 'facebook_appid');
    register_setting('socialFetcher', 'facebook_appsecret');
    register_setting('socialFetcher', 'facebook_user_id');
    register_setting('socialFetcher', 'twitter_only_images');
    register_setting('socialFetcher', 'twitter_token');
    register_setting('socialFetcher', 'twitter_token_secret');
    register_setting('socialFetcher', 'twitter_consumer_key');
    register_setting('socialFetcher', 'twitter_consumer_secret');
    register_setting('socialFetcher', 'twitter_display_name');
    register_setting('socialFetcher', 'instagram_userid');
    register_setting('socialFetcher', 'instagram_access');
    register_setting('socialFetcher', 'time_interval');
  }

  private function register_posttype()
  {
    $labels = [
      'name'               => _x('Social Feed', 'post type general name'),
      'singular_name'      => _x('Social Feed', 'post type singular name'),
      'menu_name'          => _x('Social Feed', 'admin menu'),
      'name_admin_bar'     => _x('Social Feed', 'add new on admin bar'),
      'add_new'            => _x('Add New', 'Social Feed'),
      'add_new_item'       => __('Add New Social Feed'),
      'new_item'           => __('New Social Feed'),
      'edit_item'          => __('Edit Social Feed'),
      'view_item'          => __('View Social Feed'),
      'all_items'          => __('All Social Feeds'),
      'search_items'       => __('Search Social Feed'),
      'parent_item_colon'  => __('Parent Social Feed:'),
      'not_found'          => __('No Social Feed found.'),
      'not_found_in_trash' => __('No Social Feed found in Trash.')
    ];
    $args = [
      'labels'             => $labels,
      'public'             => false,
      'publicly_queryable' => false,
      'menu_icon'          => 'dashicons-share',
      'show_ui'            => true,
      'show_in_menu'       => true,
      'query_var'          => false,
      'menu_position'      => 6,
      'capability_type'    => 'page',
      'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'page-attributes', 'custom-fields'],
      'rewrite'            => false,
      'has_archive'        => 'social-feed',
      'hierarchical'       => false,
    ];
    register_post_type('socialfeed', $args);
  }

  private function register_taxonomy()
  {
    $labels = [
      'name'              => _x('Social Platform', 'taxonomy general name'),
      'singular_name'     => _x('Social Platform', 'taxonomy singular name'),
      'search_items'      => __('Social Platform'),
      'all_items'         => __('Social Platform'),
      'parent_item'       => __('Social Platform'),
      'parent_item_colon' => __('Social Platform:'),
      'edit_item'         => __('Edit Social Platform'),
      'update_item'       => __('Update Social Platform'),
      'add_new_item'      => __('Add New Social Platform'),
      'new_item_name'     => __('New Social Platform'),
      'menu_name'         => __('Social Platform'),
    ];
    $args = [
      'public'       => false,
      'hierarchical' => false,
      'labels'       => $labels,
      'show_ui'      => true,
      'query_var'    => false,
      'rewrite'      => false,
    ];
    register_taxonomy('socialplatform', 'socialfeed', $args);
  }

  private function add_taxonomies()
  {
    $fb_term = wp_insert_term('Facebook', 'socialplatform');
    if (is_wp_error($fb_term)) {
      $this->tax_term_ids['facebook'] = $fb_term->error_data['term_exists'];
    } else {
      $this->tax_term_ids['facebook'] = $fb_term['term_id'];
    }

    $tw_term = wp_insert_term('Twitter', 'socialplatform');
    if (is_wp_error($tw_term)) {
      $this->tax_term_ids['twitter'] = $tw_term->error_data['term_exists'];
    } else {
      $this->tax_term_ids['twitter'] = $tw_term['term_id'];
    }

    $ig_term = wp_insert_term('Instagram', 'socialplatform');
    if (is_wp_error($ig_term)) {
      $this->tax_term_ids['instagram'] = $ig_term->error_data['term_exists'];
    } else {
      $this->tax_term_ids['instagram'] = $ig_term['term_id'];
    }
  }

}
