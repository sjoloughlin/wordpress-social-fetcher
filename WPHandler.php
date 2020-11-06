<?php
if (!defined('ABSPATH')) { exit; }

require_once(ABSPATH . 'wp-admin/includes/media.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/image.php');

class WPHandler
{
	public $data = [];
	public $new_posts = [];
  public $platform_obj = [];

	public function __construct($platforms, $wp_terms)
	{
    $this->platform_obj = $platforms;
		$this->wp_terms = $wp_terms;
	}

	public function fetch_latest()
	{
    foreach ($this->platform_obj as $platform => $platform_array) {
      $this->data[$platform] = $this->get_latest($platform);
    }

		return $this;
	}

	public function get_latest($platform)
	{
		$args = [
			'post_type' => 'socialfeed',
			'orderby' => 'post_date',
			'order' => 'DESC',
			'post_status' => 'publish',
			'posts_per_page' => 1,
			'tax_query' => [
				[
					'taxonomy' => 'socialplatform',
					'field'    => 'slug',
					'terms'    => $platform
				]
			]
		];

  	$social_query = new WP_Query($args);

  	if ($social_query->have_posts()) {
  		while ($social_query->have_posts()) {
  			$social_query->the_post();
  			return strtotime(get_the_date('Y-m-d H:i:s'));
  		}
  	}

  	return;
	}

	public function compare_latest($social_data)
	{
		$newer_posts = [];

		foreach ($this->data as $key => $platform_data) {

			if ($platform_data) {

				$data = [];
				$loop_index = 0;

				foreach ($social_data[$key] as $result) {

					$tempDate = null;

					(preg_match('~^[1-9][0-9]*$~', $result['datetime'])) ? $tempDate = $result['datetime'] : $tempDate = strtotime($result['datetime']);

					if ($tempDate > $platform_data) {
						array_push($data, $social_data[$key][$loop_index]);
					  $loop_index++;
					}
				}

				$newer_posts[$key] = $data;
			} else {
				// couldn't find date for WP latest post
				$newer_posts[$key] = $social_data[$key];
			}
		}

		$this->new_posts = $newer_posts;

		return $this;
	}

	public function add_posts()
	{
		global $wpdb;

		foreach ($this->new_posts as $key => $platform_posts) {

			switch (strtolower($key)) {
			  case 'twitter':
			    $platform_id = $this->wp_terms['twitter'];
			    break;
			  case 'facebook':
			    $platform_id = $this->wp_terms['facebook'];
			    break;
			  case 'instagram':
			    $platform_id = $this->wp_terms['instagram'];
			    break;
			}

			foreach ($platform_posts as $entry) {

				(preg_match('~^[1-9][0-9]*$~', $entry['datetime'])) ? $post_entry_date = date('Y-m-d H:i:s', $entry['datetime']) : $post_entry_date = date('Y-m-d H:i:s', strtotime($entry['datetime']));

				$post_data = [
					'post_author' => 1,
					'post_date' => $post_entry_date,
					'post_date_gmt' => $post_entry_date,
					'post_modified' => $post_entry_date,
					'post_modified_gmt' => $post_entry_date,
					'post_title' => $entry['text'],
					'post_name' => $entry['text'],
					'post_content' => $entry['text'],
					'post_type' => 'socialfeed',
					'post_status' => 'publish',
					'guid' => $entry['link']
				];

				$db_post_insert = wp_insert_post($post_data);

				wp_set_object_terms($db_post_insert, $platform_id, 'socialplatform');

				// add instagram video meta data
				if (isset($entry['video']) && $entry['video'] === true) {
					add_post_meta($db_post_insert, 'video', 'true');
				}

        if ($entry['image']) {
				  $this->generate_featured($entry['image'], $db_post_insert);
        }
			}
		}

		return $this;
	}

	public function generate_featured($image_url, $post_id)
	{
    $upload_dir = wp_upload_dir();
    $image_data = file_get_contents($image_url);

    if (strpos($image_url, 'jpg') !== false) {
    	$image_url_trimmed = substr($image_url, 0, strpos($image_url, '.jpg')+4);
    } else if (strpos($image_url, 'png') !== false) {
    	$image_url_trimmed = substr($image_url, 0, strpos($image_url, '.png')+4);
    } else {
    	die();
    }

    $filename = basename($image_url_trimmed);

    (wp_mkdir_p($upload_dir['path'])) ?	$file = $upload_dir['path'] . '/' . $filename :	$file = $upload_dir['basedir'] . '/' . $filename;

    file_put_contents($file, $image_data);

    $wp_filetype = wp_check_filetype($filename, null);

    $attachment = [
      'post_mime_type' => $wp_filetype['type'],
      'post_title' => sanitize_file_name($filename),
      'post_content' => '',
      'post_status' => 'inherit'
    ];

		$attach_id = wp_insert_attachment($attachment, $file, $post_id);
		$attach_data = wp_generate_attachment_metadata($attach_id, $file);
    wp_update_attachment_metadata($attach_id, $attach_data);
    $set_post = set_post_thumbnail($post_id, $attach_id);
	}
}
