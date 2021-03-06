<?php
function childThemeEnqueueScripts() {
   wp_enqueue_style('html5blank-child-style', get_stylesheet_directory_uri() . '/style.css', array(), wp_get_theme()->get('Version') );
   wp_enqueue_style('fontawesome-style', get_stylesheet_directory_uri() . '/css/font-awesome.min.css', array(), '4.7.0');

   /*wp_enqueue_style('slick', get_stylesheet_directory_uri() . '/js/slick/slick.css');
   wp_enqueue_style('slick-theme', get_stylesheet_directory_uri() . '/js/slick/slick-theme.css');*/
   wp_enqueue_style('app-style', get_stylesheet_directory_uri() . '/css/app-style.css');

   /*wp_enqueue_script('slick-script', get_stylesheet_directory_uri() . '/js/slick/slick.min.js', array(), '1.8.0', true);*/
   wp_enqueue_script('child-main-script', get_stylesheet_directory_uri() . '/js/scripts.js', array(), false, true);
}
add_action('wp_enqueue_scripts', 'childThemeEnqueueScripts', 11);

if (!function_exists('customWidgetsInit')) {
   /**
    * Register widget areas
    */
   function customWidgetsInit() {
      register_sidebar(array(
         'name' => __('Sidebar right', 'bootstrap-basic'),
         'id' => 'sidebar-right',
         'before_widget' => '<aside id="%1$s" class="widget %2$s">',
         'after_widget' => '</aside>',
         'before_title' => '<h1 class="widget-title">',
         'after_title' => '</h1>',
      ));

      register_sidebar(array(
         'name' => __('Sidebar left', 'bootstrap-basic'),
         'id' => 'sidebar-left',
         'before_widget' => '<aside id="%1$s" class="widget %2$s">',
         'after_widget' => '</aside>',
         'before_title' => '<h1 class="widget-title">',
         'after_title' => '</h1>',
      ));

      register_sidebar(array(
         'name' => __('Header right', 'bootstrap-basic'),
         'id' => 'header-right',
         'description' => __('Header widget area on the right side next to site title.', 'bootstrap-basic'),
         'before_widget' => '<div id="%1$s" class="widget %2$s">',
         'after_widget' => '</div>',
         'before_title' => '<h1 class="widget-title">',
         'after_title' => '</h1>',
      ));

      register_sidebar(array(
         'name' => __('Footer left', 'bootstrap-basic'),
         'id' => 'footer-left',
         'before_widget' => '<div id="%1$s" class="widget %2$s">',
         'after_widget' => '</div>',
         'before_title' => '<h1 class="widget-title">',
         'after_title' => '</h1>',
      ));

      register_sidebar(array(
         'name' => __('Footer right', 'bootstrap-basic'),
         'id' => 'footer-right',
         'before_widget' => '<div id="%1$s" class="widget %2$s">',
         'after_widget' => '</div>',
         'before_title' => '<h1 class="widget-title">',
         'after_title' => '</h1>',
      ));
      
      register_sidebar( array (
         'name' => __( 'Footer-Top-1'),
         'id' => 'footer-top-1',
         'description' => __('Footer-Top-1'),
         'before_widget' => '<div id="%1$s" class="widget %2$s">',
         'after_widget' => "</div>",
         'before_title' => '<h4 class="wg-title">',
         'after_title' => '</h4>',
      ) );
      
      register_sidebar( array (
         'name' => __( 'Footer-Top-2'),
         'id' => 'footer-top-2',
         'description' => __('Footer-Top-2'),
         'before_widget' => '<div id="%1$s" class="widget %2$s">',
         'after_widget' => "</div>",
         'before_title' => '<h4 class="wg-title">',
         'after_title' => '</h4>',
      ) );

      register_sidebar( array (
         'name' => __( 'Footer-Top-3'),
         'id' => 'footer-top-3',
         'description' => __('Footer-Top-3'),
         'before_widget' => '<div id="%1$s" class="widget %2$s">',
         'after_widget' => "</div>",
         'before_title' => '<h4 class="wg-title">',
         'after_title' => '</h4>',
      ) );

      register_sidebar( array (
         'name' => __( 'Footer-Top-4'),
         'id' => 'footer-top-4',
         'description' => __('Footer-Top-4'),
         'before_widget' => '<div id="%1$s" class="widget %2$s">',
         'after_widget' => "</div>",
         'before_title' => '<h4 class="wg-title">',
         'after_title' => '</h4>',
      ) );
   }// customWidgetsInit

}
add_action('widgets_init', 'customWidgetsInit', 11);

// remove HTML5 Blank Custom Post Type
function deregister_post_type(){
   unregister_post_type( 'html5-blank' );
}
add_action('init', 'deregister_post_type', 100);

/**
 *
 Sidebar column size configurations
 *
 */
// Left sidebar column size. Bootstrap have 12 columns this sidebar column size must not greater than 12.
if (!isset($sidebar_left_size)) {
   $sidebar_left_size = apply_filters('sidebar_column_left', 3);
}
// Right sidebar column size.
if (!isset($sidebar_right_size)) {
   $sidebar_right_size = apply_filters('sidebar_column_right', 4);
}
/**
 * Template functions
 */
require get_stylesheet_directory() . '/inc/template-functions.php';

/* Theme Settings */
if( function_exists('acf_add_options_page') ) {
   acf_add_options_page(array(
      'page_title'    => 'General Settings',
      'menu_title'    => 'Site Settings',
      'menu_slug'     => 'theme-general-settings',
      'capability'    => 'edit_posts',
      'redirect'      => false
   ));
   /*acf_add_options_page(array(
      'page_title'    => 'Testimonials',
      'menu_title'    => 'Testimonials',
      'menu_slug'     => 'testimonials',
      'capability'    => 'edit_posts',
      'redirect'      => false,
      'position'      => 5,
      'icon_url'      => 'dashicons-format-quote'
   ));*/
}

function cc_mime_types($mimes) {
   $mimes['svg'] = 'image/svg+xml';
   return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

/* Update wp_admin Section */
add_action("login_head", "generic_login_head");
function generic_login_head() {
   if(!is_user_logged_in()){ 
      $admin_login_logo = get_field('admin_login_logo', 'option');
      $admin_logo_width = get_field('admin_logo_width', 'option');
      $admin_logo_height = get_field('admin_logo_height', 'option');
      $admin_background_color = get_field('admin_background_colour', 'option');
      $admin_form_background_color = get_field('admin_form_background_color', 'option');
      $admin_form_text_color = get_field('admin_form_text_color', 'option');
      $admin_logo = ($admin_login_logo != '') ? $admin_login_logo : get_stylesheet_directory_uri()."/img/admin-logo.png";
      $admin_background_color = ($admin_background_color != '') ? $admin_background_color : "#fff";
      $admin_form_background_color = ($admin_form_background_color != '') ? $admin_form_background_color : "#fff";
      $admin_form_text_color = ($admin_form_text_color != '') ? $admin_form_text_color : "#72777c";
      echo "<style>
      body.login div#login h1 a {
         background-image: url('".$admin_logo."') !important;
         background-size: contain !important;
         background-position: center center;
         width: ".(!empty($admin_logo_width) ? $admin_logo_width.'px' : '280px')." !important;
         height: ".(!empty($admin_logo_height) ? $admin_logo_height.'px' : '80px')." !important;
      }
      html, body { background: ".$admin_background_color." !important; }
      .login form { background: ".$admin_form_background_color." !important; }
      .login label { color: ".$admin_form_text_color." !important; }
      .login .message, .login form { -webkit-box-shadow: 0 1px ".$admin_background_color." inset, 0 1px 3px rgba(34, 25, 25, 0.4); box-shadow: 0 1px ".$admin_background_color." inset, 0 1px 3px rgba(34, 25, 25, 0.4); }
      </style>";
   }
}
add_filter( 'login_headerurl', 'generic_login_url' );
function generic_login_url() {
   return home_url();
}
/* changing the alt text on the logo to show your site name */
add_filter( 'login_headertitle', 'generic_login_title' );
function generic_login_title() {
   return get_option( 'blogname' );
}
/* Update password protected login page */
add_action( 'password_protected_login_head', 'generic_login_head', 10, 2 );
add_action( 'password_protected_before_login_form', 'password_protected_login_custom_message' , 10, 2 );
function password_protected_login_custom_message() {
   $pp_message = get_field('password_protected_page_message', 'option');
   $message_html = '';
   if(!empty(trim($pp_message))) {
      $message_html .= '<div class="message password-protected-info">';
         $message_html .= $pp_message;
      $message_html .= '</div>';
   }
   echo $message_html;
}

function all_year() {
   return date('Y');
}
add_shortcode('year', 'all_year');

/**
 * Post pagination
 */
if(!( function_exists('post_pagination') )){
   function post_pagination($pages = '', $range = 2){
      $showitems = ($range * 2)+1;

      global $paged;
      if(empty($paged)) $paged = 1;

      if($pages == ''){
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages) {
            $pages = 1;
         }
      }

      $output = '';

      if(1 != $pages){

         $output .= '<nav class="pagination clearfix">';
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) $output .= "<a href='".get_pagenum_link(1)."'><i class=\"fa fa-angle-left\"></i></a>";
         
         for ($i=1; $i <= $pages; $i++){
            if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )){
               $output .= ($paged == $i)? "<span class=\"page-numbers current\">".$i."</span>":"<a href='".get_pagenum_link($i)."'>".$i."</a>";
            }
         }

         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) $output .= "<a href='".get_pagenum_link($pages)."'><i class=\"fa fa-angle-right\"></i></a>";
         $output.= "</nav>";
      }

      return $output;
   }
}

function get_social_links($classes = '') {
   $links = '';
   if( have_rows('social_links', 'option') ):
      $links .= '<ul class="social-links '.$classes.'">';
      while( have_rows('social_links', 'option') ): the_row();
         $links .= '<li>';
            $links .= '<a href="'.get_sub_field('link').'" class="link" target="_blank"><span class="icon">'.get_sub_field('icon').'</span></a>';
         $links .= '</li>';
      endwhile;
      $links .= '</ul>';
   endif;
   return $links;
}
add_shortcode('do_social_links', 'get_social_links');

function get_top_header() {
   $enable_top_bar = get_field('enable_top_header', 'option');
   $top_bar = '';
   if($enable_top_bar) {
      $top_bar .= '<div class="top-header">';
         $top_bar .= '<div class="container flex-box align-middle">';
            $top_bar .= '<div class="info-bar top-bar-cell flex-grow-1">';
               $location = get_field('location', 'option');
               $email = get_field('email', 'option');
               $phone_number = get_field('phone_number', 'option');
               if(!empty($location)) {
                  $top_bar .= '<span class="info--item"><span class="fa fa-map-marker"></span>&nbsp;<span class="txt">'.$location.'</span></span>';
               }
               if(!empty($email)) {
                  $top_bar .= '<a class="info--item email" href="mailto:'.$email.'"><span class="fa fa-envelope-o"></span>&nbsp;<span class="txt">'.$email.'</span></a>';
               }
               if(!empty($phone_number)) {
                  $top_bar .= '<a class="info--item phone" href="tel:'.preg_replace('/[^0-9]/', '', $phone_number).'"><span class="fa fa-phone"></span>&nbsp;<span class="txt">'.$phone_number.'</span></a>';
               }
            $top_bar .= '</div>';
            $top_bar .= '<div class="social top-bar-cell flex-grow-1 text-right">';
               $top_bar .= get_social_links();
            $top_bar .= '</div>';
         $top_bar .= '</div>';
      $top_bar .= '</div>';
   }
   return $top_bar;
}

/* breadcrumb */
if (!function_exists('get_breadcrumb')) {
   /*
   $delimiter
   # ;&#187;
   # |
   # -
   */
   function get_breadcrumb($home_text = 'Home', $delimiter = '-') {
      $enable_breadcrumb = get_field('enable_breadcrumb', 'options');
      if(!$enable_breadcrumb) { return; }
      
      global $post;
      $breadcrumb = '<div class="breadcrumb">';
      if(is_front_page()){
         $breadcrumb .= esc_html('Front Page', 'excitor');
      }elseif(is_home()){
         $breadcrumb .= esc_html('Blog', 'excitor');
      }else{
         $breadcrumb .= '<a href="' . esc_url(home_url('/')) . '" rel="nofollow">' . $home_text . '</a> ' . $delimiter . ' ';
      }

      if(is_category()){
         $thisCat = get_category(get_query_var('cat'), false);
         if ($thisCat->parent != 0) $breadcrumb .= get_category_parents($thisCat->parent, TRUE, ' ' . $delimiter . ' ');
         $breadcrumb .= '<span class="current">' . single_cat_title(esc_html__('Archive by category: ', 'excitor'), false) . '</span>';
      }elseif ( is_tag() ) {
         $breadcrumb .= '<span class="current">' . single_tag_title(esc_html__('Posts tagged: ', 'excitor'), false) . '</span>';
      }elseif(is_tax()){
         $breadcrumb .= '<span class="current">' . single_term_title(esc_html__('Archive by taxonomy: ', 'excitor'), false) . '</span>';
      }elseif(is_search()){
         $breadcrumb .= '<span class="current">' . esc_html__('Search results for: ', 'excitor') . get_search_query() . '</span>';
      }elseif(is_day()){
         $breadcrumb .= '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F').' '. get_the_time('Y') . '</a> ' . $delimiter . ' ';
         $breadcrumb .= '<span class="current">' . get_the_time('d') . '</span>';
      }elseif(is_month()){
         $breadcrumb .= '<span class="current">' . get_the_time('F'). ' '. get_the_time('Y') . '</span>';
      }elseif(is_single() && !is_attachment()){
         if(get_post_type() != 'post'){
            if(get_post_type() == 'team'){
               $terms = get_the_terms(get_the_ID(), 'team_category', '' , '' );
               if(!empty($terms) && !is_wp_error($terms)) {
                  the_terms(get_the_ID(), 'team_category', '' , ', ' );
                  $breadcrumb .= ' ' . $delimiter . ' ' . '<span class="current">' . get_the_title() . '</span>';
               }else{
                  $breadcrumb .= '<span class="current">' . get_the_title() . '</span>';
               }
            }elseif(get_post_type() == 'testimonial'){
               $terms = get_the_terms(get_the_ID(), 'testimonial_category', '' , '' );
               if(!empty($terms) && !is_wp_error($terms)) {
                  the_terms(get_the_ID(), 'testimonial_category', '' , ', ' );
                  $breadcrumb .= ' ' . $delimiter . ' ' . '<span class="current">' . get_the_title() . '</span>';
               }else{
                  $breadcrumb .= '<span class="current">' . get_the_title() . '</span>';
               }
            }elseif(get_post_type() == 'services'){
               $terms = get_the_terms(get_the_ID(), 'services_category', '' , '' );
               if(!empty($terms) && !is_wp_error($terms)) {
                  the_terms(get_the_ID(), 'services_category', '' , ', ' );
                  $breadcrumb .= ' ' . $delimiter . ' ' . '<span class="current">' . get_the_title() . '</span>';
               }else{
                  $breadcrumb .= '<span class="current">' . get_the_title() . '</span>';
               }
            }else{
               $post_type = get_post_type_object(get_post_type());
               $slug = $post_type->rewrite;
               $breadcrumb .= '<a href="' . esc_url(home_url('/')) . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a>';
               $breadcrumb .= ' ' . $delimiter . ' ' . '<span class="current">' . get_the_title() . '</span>';
            }
         }else{
            $cat = get_the_category(); $cat = $cat[0];
            $cats = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
            $breadcrumb .= ''.$cats;
            $breadcrumb .= '<span class="current">' . get_the_title() . '</span>';
         }
      }elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
         $post_type = get_post_type_object(get_post_type());
         if($post_type) $breadcrumb .= '<span class="current">' . $post_type->labels->singular_name . '</span>';
      }elseif ( is_attachment() ) {
         $parent = get_post($post->post_parent);
         $breadcrumb .= '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a>';
         $breadcrumb .= ' ' . $delimiter . ' ' . '<span class="current">' . get_the_title() . '</span>';
      }elseif ( is_page() && !is_front_page() && !$post->post_parent ) {
         $breadcrumb .= '<span class="current">' . get_the_title() . '</span>';
      }elseif ( is_page() && !is_front_page() && $post->post_parent ) {
         $parent_id  = $post->post_parent;
         $breadcrumbs = array();
         while ($parent_id) {
            $page = get_page($parent_id);
            $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
            $parent_id = $page->post_parent;
         }
         $breadcrumbs = array_reverse($breadcrumbs);
         for ($i = 0; $i < count($breadcrumbs); $i++) {
            $breadcrumb .= ''.$breadcrumbs[$i];
            if ($i != count($breadcrumbs) - 1)
               $breadcrumb .= ' ' . $delimiter . ' ';
         }
         $breadcrumb .= ' ' . $delimiter . ' ' . '<span class="current">' . get_the_title() . '</span>';
      }elseif ( is_author() ) {
         global $author;
         $userdata = get_userdata($author);
         $breadcrumb .= '<span class="current">' . esc_html__('Articles posted by ', 'excitor') . $userdata->display_name . '</span>';
      }elseif ( is_404() ) {
         $breadcrumb .= '<span class="current">' . esc_html__('Error 404', 'excitor') . '</span>';
      }

      if ( get_query_var('paged') ) {
         if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) $breadcrumb .= ' (';
         $breadcrumb .= ' ' . $delimiter . ' ' . esc_html__('Page', 'excitor') . ' ' . get_query_var('paged');
         if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) $breadcrumb .= ')';
      }

      $breadcrumb .= '</div>';
      return $breadcrumb;
   }
}

function get_banner(){
   global $post;
   $banner = '';
   if(!is_front_page()) {
      $enable_page_header = get_field('enable_page_header', 'options');
      if(empty($enable_page_header)) {
         return '';
      }
      if(is_home()):
         $post_id = get_option( 'page_for_posts' );
      else:
         $post_id = $post->ID;
      endif;
      $header_default_img = get_field('page_header_default_image', 'options');
      $header_bg_color = get_field('page_header_background_color', 'options');
      $headers_overlay = get_field('page_headers_overlay', 'options');
      $page_header_image = get_field('ph_image', $post_id);
      $image_position = get_field('ph_image_position', $post_id);
      $header_style = '';
      if(!empty($page_header_image)) {
         $header_img = $page_header_image;
      } else {
         $header_img = $header_default_img;
      }
      $header_style .= ' style="background-color: '.$header_bg_color.';';
      $header_style .= ( !empty( $header_img ) ? 'background-image: url('.$header_img.');background-position: '.$image_position.';' : '' );
      $header_style .= '"';

      $banner .= '<div class="page-header-bar'.($headers_overlay ? ' header-overlay': '').'"'.$header_style.'>';
         $banner .= '<div class="container">';
            $banner .= '<div class="heading-strip">';
               $banner .= '<h1>';
                  if(is_404()):
                     $banner .= "Page not found";
                  elseif(is_search()):
                     $total_results = $wp_query->found_posts;
                     $items = ( $total_results == '1' ) ? ' item.' : ' items.';
                     $title = get_search_query() . ', ' . $total_results . $items;
                     $banner .= $title;
                  else:
                     $banner .= get_the_title($post_id);
                  endif;
               $banner .= '</h1>';
            $banner .= '</div>';
            $banner .= get_breadcrumb();
         $banner .= '</div>';
      $banner .= '</div>';
   } else {
      $slider_shortcode = get_field('slider_shortcode', 'option');
      $banner .= '<div class="slider-section">';
         $banner .= do_shortcode($slider_shortcode);
      $banner .= '</div>';
   }
   return  $banner;
}
add_shortcode('do_banner', 'get_banner');

/*testimonials*/
function get_testimonials() {
   $content = '';
   $slide_cnt = 1;
   if( have_rows('testimonials', 'options') ) {
      $content .= '<div id="testimonial-slider" class="slide-cnt-'.$slide_cnt.'">';
      while ( have_rows('testimonials', 'options') ) : the_row();
         $content .= '<div class="testimonial-item">';
            $content .= '<div class="t-content">'.get_sub_field('testimonial_content').'</div>';
            $content .= '<div class="t-user">'.get_sub_field('user_name').'</div>';
            $content .= '<div class="t-user-info">'.get_sub_field('user_info').'</div>';
         $content .= '</div>';
         $slide_cnt++;
      endwhile;
      $content .= '</div>';
   } else {
      $content .= '<p>No Testimonials...</p>';
   }
   return $content;
}
add_shortcode('do_testimonials', 'get_testimonials');

/*dynamic custom post*/
function custom_post_type() {
   /**
   * use multiple array for each custom post.
   * enable the post array and use it.
   */
   $custom_post_type_array = array(
      /*array(
         'post_type' => 'service',
         'singular_name' => 'Service',
         'plural_name' => 'Services',
         'menu_icon' => 'dashicons-admin-tools',
         'taxonomies' => array('services-category'),
         'taxonomy_array' => array(
            array('slug' => 'service-category', 'singular_name' => 'Category', 'plural_name' => 'Categories')
         )
      )*/
   );
   if(!empty($custom_post_type_array) && is_array($custom_post_type_array)) {
      foreach($custom_post_type_array as $key => $value) {
         $labels = array(
            'name'                  => _x( $value['plural_name'], 'Post Type General Name', 'text_domain' ),
            'singular_name'         => _x( $value['singular_name'], 'Post Type Singular Name', 'text_domain' ),
            'menu_name'             => __( $value['plural_name'], 'text_domain' ),
            'name_admin_bar'        => __( 'Post Type', 'text_domain' ),
            'parent_item_colon'     => __( 'Parent '.$value['singular_name'].':', 'text_domain' ),
            'all_items'             => __( 'All '.$value['plural_name'].'', 'text_domain' ),
            'add_new_item'          => __( 'Add New '.$value['singular_name'].'', 'text_domain' ),
            'add_new'               => __( 'New '.$value['singular_name'].'', 'text_domain' ),
            'new_item'              => __( 'New Item', 'text_domain' ),
            'edit_item'             => __( 'Edit '.$value['singular_name'].'', 'text_domain' ),
            'update_item'           => __( 'Update '.$value['singular_name'].'', 'text_domain' ),
            'view_item'             => __( 'View '.$value['singular_name'].'', 'text_domain' ),
            'search_items'          => __( 'Search '.$value['singular_name'].'', 'text_domain' ),
            'not_found'             => __( 'No '.strtolower($value['singular_name']).' found', 'text_domain' ),
            'not_found_in_trash'    => __( 'No '.strtolower($value['singular_name']).' found in Trash', 'text_domain' ),
            'items_list'            => __( 'Items list', 'text_domain' ),
            'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
            'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
         );
         $args = array(
            'label'                 => __( $value['singular_name'], 'text_domain' ),
            'description'           => __( $value['singular_name'].' information pages', 'text_domain' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields' ),
            'hierarchical'          => true,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_icon'             => $value['menu_icon'],
            'menu_position'         => 5,
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
            'taxonomies'            => $value['taxonomies']
         );
         register_post_type( $value['post_type'], $args );
         
         // Register Taxonomies for Category
         if( isset($value['taxonomy_array']) && !empty($value['taxonomy_array']) ) {
            $custom_taxonomy_array = $value['taxonomy_array'];
            custom_taxonomy( $custom_taxonomy_array, $value['post_type'] );
         }
      }
   }
}
/**
*enable it if you need re register custom post
*/
// add_action( 'init', 'custom_post_type', 0 );

function custom_taxonomy($taxonomy, $post_type){
   foreach($taxonomy as $key => $value) {
      $labels = array(
         'name'              => _x( $value['plural_name'], 'taxonomy general name', 'textdomain' ),
         'singular_name'     => _x( $value['singular_name'], 'taxonomy singular name', 'textdomain' ),
         'search_items'      => __( 'Search '.$value['plural_name'], 'textdomain' ),
         'all_items'         => __( 'All '.$value['plural_name'], 'textdomain' ),
         'parent_item'       => __( 'Parent '.$value['singular_name'], 'textdomain' ),
         'parent_item_colon' => __( 'Parent '.$value['singular_name'].":", 'textdomain' ),
         'edit_item'         => __( 'Edit '.$value['singular_name'], 'textdomain' ),
         'update_item'       => __( 'Update '.$value['singular_name'], 'textdomain' ),
         'add_new_item'      => __( 'Add New '.$value['singular_name'], 'textdomain' ),
         'new_item_name'     => __( 'New '.$value['singular_name'], 'textdomain' ),
         'menu_name'         => __( $value['plural_name'], 'textdomain' ),
      );

      $args = array(
         'hierarchical'      => true,
         'labels'            => $labels,
         'show_ui'           => true,
         'show_admin_column' => true,
         'query_var'         => true,
         'rewrite'           => array( 'slug' => $value['slug']),
      );

      register_taxonomy( $value['slug'], array( $post_type ), $args );
   }
}
?>