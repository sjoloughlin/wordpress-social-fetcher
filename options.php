<?php
if ( !defined('ABSPATH') ) { exit; }
?>

<style>
#poststuff h3.hndle {
  padding: 8px 0;
}
.welcome-panel, .has-right-sidebar .inner-sidebar {
  margin: 0 0 16px 0;
}
.side-link {
  margin: 5px 0;
  display: inline-block;
}
.js .postbox .hndle {
  cursor: initial;
}
.interval-sect {
  width: 70px !important;
}
</style>

<div class="wrap">
  <form method="post" action="options.php">
    <?php settings_fields('socialFetcher');?>

    <!-- <div id="icon-options-general" class="icon32"></div> add icon here -->
    <h2><?php _e('Social Fetcher Options'); ?></h2>

    <div id="poststuff" class="metabox-holder has-right-sidebar">
      <div class="inner-sidebar">
        <div id="sm_pnres" class="postbox">
          <div class="inside">
            <h3 class="hndle"><?php _e('About this Plugin:'); ?></h3>
            <!-- <a href="#" target="_blank">Plugin Homepage</a>
            <br />
            <a href="#" target="_blank">Rate this plugin</a>
            <br />
            <a href="#" target="_blank">Report a bug</a>
            <br /> -->
            <a class="side-link" href="https://www.sjoloughlin.com/" target="_blank">Developed by Stephen O'Loughlin</a>
            <br />
            <a class="side-link" href="https://www.paypal.me/sjoloughlinUK" target="_blank">Support the Developers</a>
          </div>
        </div>
      </div>

      <div>

        <div id="post-body-content" class="has-sidebar-content">

          <div id="welcome-panel" class="welcome-panel" style="padding: 23px 10px;">
            <div class="welcome-panel-content">
              <div class="welcome-panel-column-container">
                <p class="message"><?php _e('This plugin is freely developed and available to the WordPress community. Plenty of hours were necessary to develop this project and is constantly being improved and maintained.') ?></p>
              </div>
            </div>
          </div>

          <div class="postbox">

            <div class="inside">
              <h3 class="hndle"><span><?php _e('Facebook Preferences'); ?></span></h3>

              <table class="form-table">
                <tbody>
                  <tr>
                    <th scope="row">
                      <?php _e('Facebook'); ?>
                    </th>
                    <td>
                      <?php
                      $initiate_facebook = get_option('initiate_facebook');
                      ?>
                      <label for="initiate_facebook">
                        <input type="checkbox" name="initiate_facebook" id="initiate_facebook" value="1" <?php echo ($initiate_facebook == 1 ? 'checked="checked"' : ''); ?> />
                        <?php _e('Fetch posts from this platform'); ?>
                      </label>
                  </td>
                  </tr>
                  <tr>
                    <th>
                      <?php _e('Preferences:'); ?>
                    </th>
                  <td>
                      <?php
                      $facebook_only_images = get_option('facebook_only_images');
                      ?>
                      <label for="facebook_only_images">
                        <input type="checkbox" name="facebook_only_images" id="facebook_only_images" value="1" <?php echo ($facebook_only_images == 1 ? 'checked="checked"' : ''); ?> />
                        <?php _e('Only fetch posts with images'); ?>
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <th>
                      <?php _e('App ID:'); ?>
                      <br />
                      <small><a href="https://www.facebook.com/help/audiencenetwork/804209223039296" target="_blank">What is this?</a></small>
                    </th>
                    <td>
                      <?php $fb_app_id = get_option('facebook_appid'); ?>
                      <input type="text" size="60" name="facebook_appid" id="facebook_appid" class="code" value="<?php echo $fb_app_id; ?>" />
                    </td>
                  </tr>
                  <tr>
                    <th>
                      <?php _e('User ID:'); ?>
                    </th>
                    <td>
                      <?php $fb_display = get_option('facebook_user_id'); ?>
                      <input type="text" size="60" name="facebook_user_id" id="facebook_user_id" class="code" value="<?php echo $fb_display; ?>" />
                    </td>
                  </tr>
                </tbody>
              </table>

            </div>
          </div><!-- end facebook postbox -->

          <div class="postbox">

            <div class="inside">
              <h3 class="hndle"><span><?php _e('Twitter Preferences'); ?></span></h3>

              <table class="form-table">
                <tbody>
                  <tr>
                    <th scope="row">
                      <?php _e('Twitter'); ?>
                    </th>
                    <td>
                      <?php
                      $initiate_twitter = get_option('initiate_twitter');
                      ?>
                      <label for="initiate_twitter">
                        <input type="checkbox" name="initiate_twitter" id="initiate_twitter" value="1" <?php echo ($initiate_twitter == 1 ? 'checked="checked"' : ''); ?> />
                        <?php _e('Fetch posts from this platform'); ?>
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <th>
                      <?php _e('Preferences:'); ?>
                    </th>
                    <td>
                      <?php
                      $twitter_only_images = get_option('twitter_only_images');
                      ?>
                      <label for="twitter_only_images">
                        <input type="checkbox" name="twitter_only_images" id="twitter_only_images" value="1" <?php echo ($twitter_only_images == 1 ? 'checked="checked"' : ''); ?> />
                        <?php _e('Only fetch posts with images'); ?>
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <th>
                      <?php _e('Access Token:'); ?>
                      <br />
                      <small><a href="https://apps.twitter.com/" target="_blank">What is this?</a></small>
                    </th>
                    <td>
                      <?php $tw_token = get_option('twitter_token'); ?>
                      <input type="text" size="60" name="twitter_token" id="twitter_token" class="code" value="<?php echo $tw_token; ?>" />
                    </td>
                  </tr>
                  <tr>
                    <th>
                      <?php _e('Access Token Secret:'); ?>
                      <br />
                      <small><a href="https://apps.twitter.com/" target="_blank">What is this?</a></small>
                    </th>
                    <td>
                      <?php $tw_token_secret = get_option('twitter_token_secret'); ?>
                      <input type="text" size="60" name="twitter_token_secret" id="twitter_token_secret" class="code" value="<?php echo $tw_token_secret; ?>" />
                    </td>
                  </tr>
                  <tr>
                    <th>
                      <?php _e('Consumer Key:'); ?>
                      <br />
                      <small><a href="https://apps.twitter.com/" target="_blank">What is this?</a></small>
                    </th>
                    <td>
                      <?php $tw_consumer_key = get_option('twitter_consumer_key'); ?>
                      <input type="text" size="60" name="twitter_consumer_key" id="twitter_consumer_key" class="code" value="<?php echo $tw_consumer_key; ?>" />
                    </td>
                  </tr>
                  <tr>
                    <th>
                      <?php _e('Consumer Secret:'); ?>
                      <br />
                      <small><a href="https://apps.twitter.com/" target="_blank">What is this?</a></small>
                    </th>
                    <td>
                      <?php $tw_consumer_secret = get_option('twitter_consumer_secret'); ?>
                      <input type="text" size="60" name="twitter_consumer_secret" id="twitter_consumer_secret" class="code" value="<?php echo $tw_consumer_secret; ?>" />
                    </td>
                  </tr>
                  <tr>
                    <th>
                      <?php _e('Display Name:'); ?>
                    </th>
                    <td>
                      <?php $tw_display = get_option('twitter_display_name'); ?>
                      <input type="text" size="60" name="twitter_display_name" id="twitter_display_name" class="code" value="<?php echo $tw_display; ?>" />
                    </td>
                  </tr>
                </tbody>
              </table>

            </div>
          </div><!-- end twitter postbox -->

          <div class="postbox">

            <div class="inside">
              <h3 class="hndle"><span><?php _e('Instagram Preferences'); ?></span></h3>

              <table class="form-table">
                <tbody>
                  <tr>
                    <th scope="row">
                      <?php _e('Instagram'); ?>
                    </th>
                    <td>
                      <?php
                      $initiate_instagram = get_option('initiate_instagram');
                      ?>
                      <label for="initiate_instagram">
                        <input type="checkbox" name="initiate_instagram" id="initiate_instagram" value="1" <?php echo ($initiate_instagram == 1 ? 'checked="checked"' : ''); ?> />
                        <?php _e('Fetch posts from this platform'); ?>
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <th>
                      <?php _e('User ID:'); ?>
                      <br />
                      <small><a href="#" target="_blank">What is this?</a></small>
                    </th>
                    <td>
                      <?php $ig_userid = get_option('instagram_userid'); ?>
                      <input type="text" size="60" name="instagram_userid" id="instagram_userid" class="code" value="<?php echo $ig_userid; ?>" />
                    </td>
                  </tr>
                  <tr>
                    <th>
                      <?php _e('Access Token:'); ?>
                      <br />
                      <small><a href="#" target="_blank">What is this?</a></small>
                    </th>
                    <td>
                      <?php $ig_access = get_option('instagram_access'); ?>
                      <input type="text" size="60" name="instagram_access" id="instagram_access" class="code" value="<?php echo $ig_access; ?>" />
                    </td>
                  </tr>
                </tbody>
              </table>

            </div>
          </div><!-- end instagram postbox -->

          <div class="postbox">

            <div class="inside">
              <h3 class="hndle"><span><?php _e('Social Fetcher Preferences'); ?></span></h3>

              <table class="form-table">
                <tbody>
                  <tr>
                    <th scope="row" class="interval-sect">
                      <?php _e('Interval'); ?>
                    </th>
                    <td>
                      <?php
                      $time_interval = get_option('time_interval');
                      $time_options = [
                        1 => "1 minute",
                        5 => "5 minutes",
                        15 => "15 minutes",
                        60 => "1 hour",
                        120 => "2 hours",
                        180 => "3 hours",
                        1440 => "daily"
                      ];
                      ?>

                      <select id="time_interval" name="time_interval">
                        <?php
                        foreach ($time_options as $time_opt => $time_val) {
                          $selected = '';
                          if ($time_interval == $time_opt) { $selected = 'selected'; }
                          echo '<option value="'.$time_opt.'" '.$selected.'>'.$time_val.'</option>';
                        }
                        ?>
                      </select>
                      <?php _e('Set how often you want to fetch posts'); ?>
                    </td>
                  </tr>
                </tbody>
              </table>

            </div>
          </div><!-- end general postbox -->

          <div>
          <?php submit_button(); ?>
          </div>
        </div>
      </div>

  </form>
</div>
