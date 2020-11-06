<?php
if (!defined('ABSPATH')) { exit; }

include 'TwitterConfig.php';
include 'FacebookConfig.php';
include 'InstagramConfig.php';

class SocialConfig
{
  public $config = null;

  public function setConfig($config)
  {
    $this->config = $config;
  }

  public function getConfig()
  {
    return $this->config;
  }

  public function isActive()
  {
    return $this->getConfig()['is_enabled'];
  }
}
