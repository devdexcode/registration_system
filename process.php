<?php
/***
 * Signup
 * ***/
add_action('wp_ajax_wp_signup', 'wp_signup');
add_action('wp_ajax_nopriv_wp_signup', 'wp_signup');

function wp_signup()
{
    // print_r($_REQUEST);

    foreach ($_REQUEST as $k => $v) {
        $$k = $v;
    }
// print_r($_REQUEST);
    // return;
    if (filter_var(!$user_email, FILTER_VALIDATE_EMAIL)) {
        $status = 0;
        $message = "Please provide a valid email address!";
    } elseif (email_exists($user_email)) {
        $status = 0;
        $message = "Email already registerd!";
    } elseif ($user_password == "") {
        $status = 0;
        $message = "Please provide a password!";
    } elseif ($username == "") {
        $status = 0;
        $message = "Please provide a username!";
    } else {
        $user_id = wp_create_user($username, $user_password, $user_email);
        $user = get_user_by('id', $user_id);
        // $user->remove_role('subscriber');
        // $user->add_role($_REQUEST['user_role']); //
        wp_update_user(array('ID' => $user_id, 'role' => ''));

        $name = $first_name . ' ' . $last_name;
        foreach ($_REQUEST as $key => $val) {
            if ($key == 'passowrd' || $key == 'submit' || $key == 'user_password' || $key == 'action') {continue;}
            update_user_meta($user_id, $key, $val);
            // add_update_usermeta($user_id, $key, $val);
        }
        update_user_meta($user_id, 'name', $name);
        add_user_meta($user_id, 'user_active', '0');
        $code = uniqid();
        add_user_meta($user_id, 'user_activation_code', $code);

        $to = $user_email;
        $subject = "Your " . get_bloginfo('name') . " Account";
        $body = "Hi " . $name . ",<br/><br/> Thanks for registering with Us.<br><br/>";
        $the_code = base64_encode($code);
        $uid = base64_encode($user_id);
        $un = base64_encode($username);
        $pwd = base64_encode($user_password);
        // $r = base64_encode($_REQUEST['user_role']);
        $body .= "You can activate your account by clicking this <a href='" . site_url() . "/user-activation?c=" . $the_code . "&nu=" . $un . "&i=" . $uid . "&dp=" . $pwd . "'>Activate Your account</a>.<br/><br/><br>";
        $headers = array('Content-Type: text/html; charset=UTF-8', 'From: ' . get_bloginfo('name'));
        $sent_message = wp_mail($to, $subject, $body, $headers);
        $sent_message_msg = ($sent_message ? 'Email sent' : 'There was an error sending your email!');

        $status = 1;
        $message = "<div class='rounded container p-4 border'><h2 class='row text-success pt-4 pb-2 pl-3'>Registered successfully</h2> <p class='row pb-4 pl-3'>Thank you for signing-up with Us.<br> Please check your inbox to activate your account.</p></div>";

    }
    echo json_encode(array('Status' => $status, 'msg' => $message, 'Error' => $error, 'sent_message_msg' => $sent_message_msg, 'email_body' => $body, 'uid' => $user_id, 'REQUEST' => $_REQUEST));
    exit;
}

/***
 * Update Profile
 * ***/
add_action('wp_ajax_wp_update_profile', 'wp_update_profile');
add_action('wp_ajax_nopriv_wp_update_profile', 'wp_update_profile');

    function wp_update_profile(){
        $update_info = array();
        global $current_user;
        foreach ($_REQUEST as $k => $v) {
            $$k = $v;
        }
      
        $user_updated = wp_update_user( array('ID' => $user_id, 'first_name' => $first_name, 'last_name' => $last_name, 'nickname' => $nickname, 'user_email' => $user_email ));

        $message = "Information updated successfully.";
        $status = 1;        
    echo json_encode(array('Status' => $status, 'msg' => $message));
    exit;
}

/***
 * CHANGE PASSWORD
 * ***/
add_action('wp_ajax_wp_change_profile_password', 'wp_change_profile_password');
add_action('wp_ajax_nopriv_wp_change_profile_password', 'wp_change_profile_password');

    function wp_change_profile_password(){
        global $current_user;
        // echo $_REQUEST['user_passwrod'];
        $pass_check = wp_check_password( $_REQUEST['user_password'], $current_user->user_pass, $current_user->data->ID );
        
        if(strlen($_REQUEST['user_password_new']) > 0 && strlen($_REQUEST['user_password_new']) < 6){
            $message = "Password must be at least 6 characters.";
            $status = 0;
        }elseif($_REQUEST['user_password_new'] != $_REQUEST['user_password_new_repeat']){
            $message = "Passwords do not match! please re-check and try again with your new password and confirm your password.";
            $status = 0;
        }elseif($_REQUEST['user_password'] != ""){
            if($pass_check){
                wp_set_password( $_REQUEST['user_password_new'], $current_user->ID );
                $message = "Password changed successfully.";
                $status = 1;   
            }else{
                $message = "Incorrect Password!";
                $status = 0;
            }
        }

     
    echo json_encode(array('Status' => $status, 'msg' => $message, 'REQUEST'=>$_REQUEST));
    exit;
}

/***
 * ADD OR UPDATE USERMETA:Based on Existance
 * **/
// function add_update_usermeta($userID, $key, $to_save)
// {
//     $havemeta = get_user_meta($userID, $key, true);
//     if ($havemeta) {
//         update_user_meta($userID, $key, $to_save);
//     } else {
//         add_user_meta($userID, $key, $to_save);
//     }
// }

/***
 * Signin
 * ***/
add_action('wp_ajax_the_wp_signin', 'the_wp_signin');
add_action('wp_ajax_nopriv_the_wp_signin', 'the_wp_signin');

function the_wp_signin()
{

    if (empty($_POST['username'])) {
        $status = 0;
        $message = "Please provide a username/email!";
    } elseif (empty($_POST['user_password'])) {
        $status = 0;
        $message = "Please enter your password!";
    }
    $login = home_url() . "/signin/";
    $dashboard = home_url() . "/profile/";

    $email = $_POST['username'];
    $password = $_POST['user_password'];
    $creds = array();
    $creds['user_login'] = $email;
    $creds['user_password'] = $password;
    $creds['remember'] = false;
    $user = wp_signon($creds, false);

    
    if (is_wp_error($user)) {
        $message = $user->get_error_message();
        $status = 0;
        //   die;
    } else { //successfully logged in
        $user_active = get_user_meta($user_id, 'user_active', true);
        if ($user_active === 0) {
            $message = "<strong>User not active yet!</strong><br> <span>Please check your inbox and activate your account in order to sign-in!</span>";
        } else {
            $message = "Sucess! Redirecting you...";
            session_start(); //check for wp_session storage
            $_SESSION["new_dashboard"] = '1'; //if you want to redirect user to a new page or set any conditions on login

            //  if ($user->is_admin == '1') {
            //    $dashboard = home_url()."/?page=old-dashboard";
            //  } else {
            //    $dashboard = home_url()."/?page=new-dashboard";
            //  }

            //set cookie for remember me //save user login details as cookie if remember me is set, so that if user logs out next time and comes to this log in page, username & password auto fills by checking
            $user_login_details = $email . '_pass_' . $password;
            if (!empty($_POST["remember"])) {
                setcookie("user_login_details", $user_login_details, time() + (10 * 365 * 24 * 60 * 60)); //set cookie time as per you need
            } else { //remove login details from cookie
                if (isset($_COOKIE["user_login_details"])) {
                    setcookie("user_login_details", "");
                }
            }
            $wp_redirect = $dashboard;
            $status = 1;
            //   exit;
        } //ends else if user_active

    } //ends else if is_wp_error($user)

    if (isset($_COOKIE["user_login_details"])) {
        $login_details = $_COOKIE["user_login_details"];
        $login_details = explode('_pass_', $login_details);
        $email_set = $login_details[0];
        $pass_set = $login_details[1];
    }
    echo json_encode(array('Status' => $status, 'msg' => $message, 'Error' => $error, 'wp_redirect' => $wp_redirect));
    exit;
}

/***
 * User Activation
 * ***/

add_shortcode('user_activation', 'user_activation_cb');

function user_activation_cb()
{
    ob_start();
    $username = base64_decode($_GET['nu']);
    $password = base64_decode($_GET['dp']);
    $code = base64_decode($_GET['c']);
    $id = base64_decode($_GET['i']);
    $uac = get_user_meta($id, 'user_activation_code', true);
    $is_active_yet = get_user_meta($id, 'user_active', true);

    if (isset($username) && isset($password) && $code === $uac && $is_active_yet == 0) {

        update_user_meta($id, 'user_active', '1');
        wp_update_user(array('ID' => $id, 'role' => 'subscriber'));

        $creds = array();
        $creds['user_login'] = $username;
        $creds['user_password'] = $password;
        $creds['remember'] = true;
        $user = wp_signon($creds, false);

        if (is_wp_error($user)) {
            $message = $user->get_error_message();
            $status = 0;
        } else { //successfully logged in

            session_start(); //check for wp_session storage
            $_SESSION["new_dashboard"] = '1';

            //set cookie for remember me //save user login details as cookie if remember me is set, so that if user logs out next time and comes to this log in page, username & password auto fills by checking
            $user_login_details = $email . '_pass_' . $password;
            if (!empty($_POST["remember"])) {
                setcookie("user_login_details", $user_login_details, time() + (10 * 365 * 24 * 60 * 60)); //set cookie time as per you need
            } else { //remove login details from cookie
                if (isset($_COOKIE["user_login_details"])) {
                    setcookie("user_login_details", "");
                }
            } //ends if post remember
            if (isset($_COOKIE["user_login_details"])) {
                $login_details = $_COOKIE["user_login_details"];
                $login_details = explode('_pass_', $login_details);
                $email_set = $login_details[0];
                $pass_set = $login_details[1];
            }?>
                    <div class='rounded container p-4 border'>
                        <h3 class='text-success pt-4 '>Account Activated!</h3>
                        <div class="pt-4 bp-4"> Your account has been activated. Redirecting you....</div>
                        <br><br>
                    </div>
                    <?php
                        $the_redirect = site_url().'/profile?complete-profile=1';?>
                    <script>
                    let the_redirect = "<?php echo $the_redirect ?>";
                        setTimeout(function(){
                            window.location.replace(the_redirect);
                        }, 6000);//
                    </script>
                    <?php
            } //ends if err logging in
            } else {?>
            <div class='rounded container p-4 border'>
                <h3 class='text-danger pt-4 '>Wrong Information!</h3>
                <div class="pt-4 bp-4">Wrong Information. Redirecting you....</div>
                <br><br>
            </div>
            <script>
            let the_redirect = "<?php echo site_url(); ?>";
                setTimeout(function(){
                    window.location.replace(the_redirect);
                }, 4000);//
            </script>
            <?php
            }//ends else wrong info
           
}




// 
/***
 * Reset Password
 * ***/
add_action('wp_ajax_forgot_password', 'forgot_password');
add_action('wp_ajax_nopriv_forgot_password', 'forgot_password');

function forgot_password(){
    $user_info = get_user_by( 'login', $_REQUEST['username'] );
    if($user_info == false){
        $message = "Username doesn't exist in our system!";
    }else{
        $new_password = uniqid();
            wp_set_password( $new_password, $user_info->ID );


$to             = $user_info->user_email;
$subject        = "Your request for new password";
$body           = "Hi " . $user_info->first_name . ",<br/><br/> The new password for your account is ".$new_password." <br><br> Your can log in to your account <a href='".site_url()."/signup'>Here</a>";
$headers        = array('Content-Type: text/html; charset=UTF-8', 'From: ' . get_bloginfo('name'));
$sent_message   = wp_mail($to, $subject, $body, $headers);
$sent_message_msg = ($sent_message ? 'Email sent' : 'There was an error sending your email!');

$status = 1;

            $message = "<div class='rounded container p-4 border'>
            <h3 class='text-success pt-4 '>Password Reset Successfull!</h3>
            <div class='pt-4 bp-4'> New password was sent to your inbox.</div>
            <br><br></div>";
    }
    echo json_encode(array('Status' => $status, 'msg' => $message, 'Error' => $error, 'email_body' => $body));
    exit;
}



/***
 * UPDATE USER ADDRESS
 * ***/
add_action('wp_ajax_wp_update_user_address', 'wp_update_user_address');
add_action('wp_ajax_nopriv_wp_update_user_address', 'wp_update_user_address');

function wp_update_user_address(){
    global $current_user;
    foreach($_POST as $k => $v){
        update_user_meta($current_user->ID, $k, $v);
    }
    $status = 1;
    $message = "Information updated successfully";
    echo json_encode(array('Status' => $status, 'msg' => $message, 'REQUEST' => $_REQUEST));
    exit;
}


/***
 * CLEAN FORM INPUT
 * ***/

function clean_input($inp){
    return stripslashes(strip_tags($inp));
}