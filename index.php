<?php 
/*
Plugin Name: wp_lite Signup
Plugin URI: 
Description: [signin_form][signup_form][user_activation][wp_lite_dashboard][wp_lite_forgot_password] in later versions: sanitzation, auto generate pages, layout css to display responses more better, add admin page with dynamic fields.
Author:  Aamir Hussain
Version: 3
Author URI: 
Text Domain: wp_lite signup
*/
$path = plugin_dir_path( __FILE__ );
define('PATH', $path);

 function active(){
  update_option( 'wp_lite_signup_activated', time() );
  $pages = [
    [
      'page_title'    => 'Signin',
      'page_content'  => '[signin_form]'
    ],
    [
      'page_title'    => 'signup',
      'page_content'  => '[signup_form]'
    ],
    [
      'page_title'    => 'User Activation',
      'page_content'  => '[user_activation]'
    ],
    [
      'page_title'    => 'Profile',
      'page_content'  => '[wp_lite_dashboard]'
    ],
    [
      'page_title'    => 'Forgot Password',
      'page_content'  => '[wp_lite_forgot_password]'
    ],
  ];
print_r($pages);
  foreach($pages as $page){
    wpl_create_page($page_title, $page_content);
  }
}
register_activation_hook(__FILE__,   'active');

function wpl_create_page($page_title, $page_content)
{
    $page_obj = get_page_by_title($page_title, 'OBJECT', 'page');

    if ($page_obj) {

        return false;

        exit();

    }

    $page_args = array(

        'post_type'      => 'page',

        'post_status'    => 'publish',

        'post_title'     => ucwords($page_title),

        'post_name'      => strtolower(trim($page_title)),

        'post_content'   => $page_content,

    );

    $page_id = wp_insert_post($page_args);

    return $page_id;

}
/***
 *  HEADERS.... FIX (Warning: Cannot modify header information - headers already sent by).... FIX
 * **/
add_action('template_redirect', function () {
  ob_start();
});
/***
 *  REMOVE ADMINBAR FOR NON ADMINS
 * **/
add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
if (!current_user_can('administrator') && !is_admin()) {
  show_admin_bar(false);
}
}

/***
 *  ASSETS
 * **/
function assets(){
    include_once(PATH.'/FormBuilder.php');
?>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>html{scroll-behavior: smooth !important;}#response{padding:10px 0;}.error{color: #dc3545 !important;}.form-control.error{border-color: #dc3545 !important;}#response a{display: none !important;}</style>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
<?php
}

include_once(PATH.'process.php');

/***
 *  SIGNUP FORM
 * **/
add_shortcode( 'signup_form', 'signup_form_cb' );

function signup_form_cb(){
    assets();
    $formBuilder = new FormBuilder(); 
    ob_start();
  ?>
    <?php include_once(PATH.'singup.php');?>          
    <?php $html = ob_get_clean();
    return $html;
}

/***
 *  SIGNIN FORM
 * **/
add_shortcode( 'signin_form', 'signin_form_cb' );

function signin_form_cb(){
    assets();
    $formBuilder = new FormBuilder(); 
    ob_start();
  ?>
    <?php include_once(PATH.'singin.php');?>          
    <?php $html = ob_get_clean();
    return $html;
}

/***
 *  PROFILE PAGE
 * **/
add_shortcode('wp_lite_dashboard', 'wp_lite_dashboard_cb');

function wp_lite_dashboard_cb(){
  if(!is_user_logged_in()){ wp_safe_redirect(home_url()); exit();}
  $current_user = wp_get_current_user();
  assets();
  $formBuilder = new FormBuilder(); 
  ob_start();?>
<?php include_once(PATH.'dashboard.php');?>   
<?php 
$html = ob_get_clean();
return $html;
}


/***
 *  FORGOT PASSWORD
 * **/
add_shortcode('wp_lite_forgot_password', 'wp_lite_forgot_password_cb');

function wp_lite_forgot_password_cb(){
  ob_start();
  assets();
  
$formBuilder = new FormBuilder(); 
 include_once(PATH.'forgot_pwd.php');

$html = ob_get_clean();
return $html;
}



/***
 *  FOOTER SCRIPT
 * **/
add_action('wp_footer','plugin_script');

function plugin_script(){
  ob_start();?>
  <script>
function scroll_middle(id){
  document.getElementById(id).scrollIntoView({
    behavior: 'auto',
    block: 'center',
    inline: 'center'
  }); 
}
</script> 
  <?php $html =ob_get_clean();
  echo $html;
}
