#### Social Fetcher ####

Social Fetcher (SF) collates posts from Facebook, Twitter and Instagram in the background and stores them within WordPress making them easily queryable and allowing for a fast frontend experience.

#### Introduction ####

Social Fetcher was developed to collect social media feed data and store them within WordPress, this helps to render web pages quicker as all the posts get fecthed server side in the background.

The plugin currently supports Facebook, Twitter and Instagram. Each platform gets stored into a custom post type with corresponding taxonomies that makes it easily queryable.

#### Installation ####

1. Upload to `/wp-content/plugins/` directory.
2. Navigate to the WordPress Plugins page and Activate.
3. Populate each platforms credentials via WordPress Tools menu > Social Fetcher.
4. Enable/Disable social media platforms.
5. Set how often you want the posts to be fetched.
6. Complete. You'll now notice new posts have been created in the Social Feed post type menu.

#### How It Works ####

* Add your application credentials for your chosen platform.
* Chose the cron job cycle frequency, this will set how often the posts are fetched.
* Posts will get added to the Social Feed post type ready to be queried.
* Start querying your posts to display on front end.

#### Example Query ####

`$args = [
  'post_type' => 'socialfeed',
  'orderby' => 'post_date',
  'order' => 'DESC',
  'post_status' => 'publish',
  'posts_per_page' => 5,
  'tax_query' => [
    [
      'taxonomy' => 'socialplatform',
      'field'    => 'slug',
      'terms'    => 'facebook'
    ]
  ]
];

$facebook_query = new WP_Query($args);`

#### Disclaimer ####

This plugin was developed to eliminate client requests and reduce the time it takes to load the web page.

#### Contributors ####

Contributions are welcome. Please see the 'Issues' tab for more details or create your own.
