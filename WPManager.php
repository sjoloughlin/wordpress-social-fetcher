<?php
if (!defined('ABSPATH')) { exit; }

include 'WPHandler.php';

class WPManager
{
  public $WPHandler = null;
  public $post_data = null;

  public function __construct($platform_data, $post_data)
  {
    $this->post_data = $post_data;
    $this->WPHandler = new WPHandler($platform_data, SFSetup::$SocialFetcherConf->tax_term_ids);
  }

  public function init()
  {
    $this->WPHandler->fetch_latest()
      ->compare_latest($this->post_data)
      ->add_posts();
  }
}
