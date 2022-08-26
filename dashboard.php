
<ul class="nav nav-tabs  flex-column col-md-4">
  <li class="nav-item">
    <a class="nav-link active btn btn-outline-secondary text-left" title="Dashboard" href="#dashboard" data-toggle="tab">Dashboard</a>
  </li>
  <li class="nav-item">
    <a class="nav-link btn btn-outline-secondary text-left" title="Profile" href="#profile" data-toggle="tab">Basic Information</a>
  </li>
  <li class="nav-item">
    <a class="nav-link btn btn-outline-secondary text-left" title="Chagnge Password" href="#change_password_tab" data-toggle="tab">Change Password</a>
  </li>
  <li class="nav-item">
    <a class="nav-link btn btn-outline-secondary text-left" href="#address" title="Address" data-toggle="tab">Address</a>
  </li>
  <li class="nav-item">
    <a class="nav-link btn btn-outline-secondary text-left" href="<?php echo wp_logout_url( home_url('/signin/') ); ?>" title="Logout" >Logout</a>
  </li>
</ul>
<div class="tab-content col-md-8">
  <article class="tab-pane container active" id="dashboard">
   <div class="">
     <a href="<?php echo wp_logout_url( home_url('/signin/') ); ?>" title="Logout" class="pull-right mr-0 ml-auto">Signout?</a>
     <h3>Welcome <?php echo $current_user->nickname?>!</h3>
     
   </div>
  </article>
  <article class="tab-pane container" id="profile">
    <form action="#" name="profile_form" id="profile_form">
    <div class="row"><h3>Profile</h3></div>
    <div id="response_profile"></div>
      <div class="row">
        <?php 
    $first_name       =   get_user_meta($current_user->ID,'first_name',true );
    $last_name        =   get_user_meta($current_user->ID,'last_name',true );
    $username         =   get_user_meta($current_user->ID,'username',true );
    $email            =   get_user_meta($current_user->ID,'user_email',true );
    $nickname         =   get_user_meta($current_user->ID,'nickname',true );?>
<input type="hidden" name="user_id" value="<?php echo $current_user->ID?>">

 <?php    $formBuilder->field([
        'container_class' => 'col-md-6 pl-0 mb-0',
        'name' => 'first_name',
        'label'=>'First Name',
        'id'=>'first_name',
        'required' => 'required',
        'type' => 'text',
        'label_class'=>'the_label',
        'input_class'=>'field',
        'label_col'=>'',
        'input_col'=>'',
        'dbval'=> $first_name
    ]); ?>   <?php $formBuilder->field([
      'container_class' => 'col-md-6 pr-0 mb-0',
      'name' => 'last_name',
      'label'=>'Last Name',
      'id'=>'last_name',
      'required' => 'required',
      'type' => 'text',
      'label_class'=>'the_label',
      'input_class'=>'field',
      'label_col'=>'',
      'input_col'=>'',
      'dbval'=> $last_name
    ]); ?></div>

<?php $formBuilder->field([
  'container_class' => 'row',
  'name' => 'nickname',
  'label'=>'Display Name',
  'id'=>'nickname',
  'required' => 'required',
  'type' => 'text',
  'label_class'=>'the_label',
  'input_class'=>'field',
  'label_col'=>'',
  'input_col'=>'',
  'dbval'=>$nickname,
  'description'=>'(This will be displayed in the account section and in reviews)'
]); ?>
<?php $formBuilder->field([
  'container_class' => 'row',
  'name' => 'username',
  'label'=>'Userame',
  'id'=>'username',
  'required' => 'required',
  'type' => 'text',
  'label_class'=>'the_label',
  'input_class'=>'field',
  'label_col'=>'',
  'input_col'=>'',
  'dbval'=>$username,
  'readonly'=>'yes',
  'description'=>'(Username can not be changed!)'
]); ?>
    <?php $formBuilder->field([
      'container_class' => 'row',
      'name' => 'user_email',
      'label'=>'email',
      'id'=>'user_email',
      'required' => 'required',
      'type' => 'email',
      'label_class'=>'the_label',
      'input_class'=>'field',
      'label_col'=>'',
      'input_col'=>'',
      'dbval'=>$email,
      'description'=>'',
      'disabled'=>'disabled',
      'description'=>'(User Email can not be changed!)'
    ]); ?>

   <!-- <div class="row"> Want to change password? &nbsp; <a href="#chPassForm"> Reset it here </a></div> -->

    <div class="row mt-4">
      <?php $formBuilder->field([
        'container_class' => 'col-md-8 pl-0',
        'name' => 'submit',
        'label'=>'Update profile',
        'id'=>'update_profile', 
        'type' => 'submit',
        'input_class'=>'',
      ]); ?>
    </div>
 
</form>

</article>
<article class="tab-pane container" id="change_password_tab">
    <form action="#" name="change_password_form" id="change_password_form">
      <div class="row" id="response_password"></div>
    <?php $formBuilder->field([
      'container_class' => 'row',
      'name' => 'user_password',
      'label'=>'Enter current password',
      'id'=>'user_password',
      'required' => 'required',
      'type' => 'password',
      'label_class'=>'the_label',
      'input_class'=>'field password',
      'label_col'=>'',
      'input_col'=>'',
      // 'description'=>'(Leave blank to keep it unchanged)',
      // 'dbval'=> wp_hash_password($current_user->user_pass)
    ]); ?>
    <hr class="row pt-4 pb-4"> 
    <div class="row">
    <?php $formBuilder->field([
      'container_class' => 'col-md-6 pl-0 mb-0',
      'name' => 'user_password_new',
      'label'=>'enter new password',
      'id'=>'user_password_new',
      'required' => 'required',
      'type' => 'password',
      'label_class'=>'the_label password',
      'input_class'=>'field',
      'label_col'=>'',
      'input_col'=>''
    ]); ?>  <?php $formBuilder->field([
  'container_class' => 'col-md-6 pr-0 mb-0',
  'name' => 'user_password_new_repeat',
  'label'=>'repeat new password',
  'id'=>'user_password_new_repeat',
  'required' => 'required',
  'type' => 'password',
  'label_class'=>'the_label',
  'input_class'=>'field repeat-password',
  'label_col'=>'',
  'input_col'=>''
]); ?></div>

<div class="row mt-4">
      <?php $formBuilder->field([
        'container_class' => 'col-md-8 pl-0',
        'name' => 'change_password',
        'label'=>'Update Password',
        'id'=>'change_password', 
        'type' => 'submit',
        'input_class'=>'',
      ]); ?>
</div>

    </form>
</article>
<article class="tab-pane container" id="address">
  <div class="row"><h3>Address</h3></div>
  <form action="#" id="update_address_form" name="update_address_form">
  <div id="response_update_address"></div>
  <div class="row">
        <?php 
    $billing_country       =   get_user_meta($current_user->ID,'billing_country',true );
    $billing_state         =   get_user_meta($current_user->ID,'billing_state',true );
    $billing_city         =   get_user_meta($current_user->ID,'billing_city',true );
    $billing_postcode         =   get_user_meta($current_user->ID,'billing_postcode',true );
    $billing_phone         =   get_user_meta($current_user->ID,'billing_phone',true );
    $billing_email         =   get_user_meta($current_user->ID,'billing_email',true );
    $billing_address_1         =   get_user_meta($current_user->ID,'billing_address_1',true );

    $formBuilder->field([
        'container_class' => 'col-md-6 pl-0 mb-0',
        'name' => 'first_name',
        'label'=>'First Name',
        'id'=>'first_name',
        'required' => 'required',
        'type' => 'text',
        'label_class'=>'the_label',
        'input_class'=>'field',
        'label_col'=>'',
        'input_col'=>'',
        'dbval'=> $first_name
    ]); ?>   <?php $formBuilder->field([
      'container_class' => 'col-md-6 pr-0 mb-0',
      'name' => 'last_name',
      'label'=>'Last Name',
      'id'=>'last_name',
      'required' => 'required',
      'type' => 'text',
      'label_class'=>'the_label',
      'input_class'=>'field',
      'label_col'=>'',
      'input_col'=>'',
      'dbval'=> $last_name
    ]); ?></div>

<div class="row">
        <?php 
    $formBuilder->field([
        'container_class' => 'col-md-6 pl-0 mb-0',
        'name' => 'billing_country',
        'label'=>'Country',
        'id'=>'billing_country',
        'required' => 'required',
        'type' => 'countries',
        'label_class'=>'the_label',
        'input_class'=>'field',
        'label_col'=>'',
        'input_col'=>'',
        'dbval'=> $billing_country
    ]); ?>   <?php $formBuilder->field([
      'container_class' => 'col-md-6 pr-0 mb-0',
      'name' => 'billing_state',
      'label'=>'State',
      'id'=>'billing_state',
      'required' => 'required',
      'type' => 'text',
      'label_class'=>'the_label',
      'input_class'=>'field',
      'label_col'=>'',
      'input_col'=>'',
      'dbval'=> $billing_state
    ]); ?></div>
    
    <div class="row">
            <?php 
        $formBuilder->field([
            'container_class' => 'col-md-6 pl-0 mb-0',
            'name' => 'billing_city',
            'label'=>'City',
            'id'=>'billing_city',
            'required' => 'required',
            'type' => 'text',
            'label_class'=>'the_label',
            'input_class'=>'field',
            'label_col'=>'',
            'input_col'=>'',
            'dbval'=> $billing_city
        ]); ?>   <?php $formBuilder->field([
          'container_class' => 'col-md-6 pr-0 mb-0',
          'name' => 'billing_postcode',
          'label'=>'Zipcode',
          'id'=>'billing_postcode',
          'required' => 'required',
          'type' => 'text',
          'label_class'=>'the_label',
          'input_class'=>'field',
          'label_col'=>'',
          'input_col'=>'',
          'dbval'=> $billing_postcode
        ]); ?></div>

    <div class="row">
            <?php 
        $formBuilder->field([
            'container_class' => 'col-md-6 pl-0 mb-0',
            'name' => 'billing_phone',
            'label'=>'Phone Number',
            'id'=>'billing_phone',
            'required' => 'required',
            'type' => 'text',
            'label_class'=>'the_label',
            'input_class'=>'field',
            'label_col'=>'',
            'input_col'=>'',
            'dbval'=> $billing_phone
        ]); ?>   <?php $formBuilder->field([
          'container_class' => 'col-md-6 pr-0 mb-0',
          'name' => 'billing_email',
          'label'=>'Email address',
          'id'=>'billing_email',
          'required' => 'required',
          'type' => 'text',
          'label_class'=>'the_label',
          'input_class'=>'field',
          'label_col'=>'',
          'input_col'=>'',
          'dbval'=> $billing_email
        ]); ?></div>

<?php $formBuilder->field([
          'container_class' => 'row',
          'name' => 'billing_address_1',
          'label'=>'Street address',
          'id'=>'billing_address_1',
          'required' => 'required',
          'type' => 'textarea',
          'label_class'=>'the_label',
          'input_class'=>'field',
          'label_col'=>'',
          'input_col'=>'',
          'dbval'=> $billing_address_1
        ]); ?>

    <div class="row mt-4">
      <?php $formBuilder->field([
        'container_class' => 'col-md-8 pl-0',
        'name' => 'update_address',
        'label'=>'Update Information',
        'id'=>'update_address', 
        'type' => 'submit',
        'input_class'=>'',
      ]); ?>
    </div>
    </form>
</article>

</div>

<script>
$(document).ready(function () {        
//Update profile
$(document).on('click','#update_profile',function(event){
     
      event.preventDefault();
    let the_url = "<?php echo admin_url('admin-ajax.php') ?>?action=wp_update_profile";
    let form_data = $('#response_update_address').serialize();
      $.ajax({
        url: the_url,
        type: "post",
        dataType: "json",
        data: form_data,
      }).done(function (response) {
          // console.log(response);
        if (response.Status == 1) { 
          $('#response_update_address').removeClass('text-danger').addClass('text-success').html(response.msg).show();//.delay(30000).fadeOut();
           $("html, body").animate({ scrollTop: $('#response_profile') }, 2500);
          $('#signup>.container').hide();
        }else{
          $('#response_update_address').addClass('text-danger').html(response.msg).show().delay(10000).fadeOut();
           $("html, body").animate({ scrollTop: $("#response_profile") }, 1500);
        }
      }); //ajax done
      
 
});//ends update profile

// change_password
$(document).on('click','#change_password',function(event){
     
   event.preventDefault();
   let the_url = "<?php echo admin_url('admin-ajax.php') ?>?action=wp_change_profile_password";
   let form_data = $('#change_password_form').serialize();
     $.ajax({
       url: the_url,
       type: "post",
       dataType: "json",
       data: form_data,
     }).done(function (response) {
         // console.log(response);
       if (response.Status == 1) { 
         $('#response_password').removeClass('text-danger').addClass('text-success').html(response.msg).show();//.delay(30000).fadeOut();
          $("html, body").animate({ scrollTop: $('#response_password') }, 2500);
         $('#signup>.container').hide();
       }else{
         $('#response_password').addClass('text-danger').html(response.msg).show().delay(10000).fadeOut();
          $("html, body").animate({ scrollTop: $("#response_password") }, 1500);
       }
     }); //ajax done
     

});//ends change password

// update_address
$(document).on('click','#update_address',function(event){
  
   event.preventDefault();
   let the_url = "<?php echo admin_url('admin-ajax.php') ?>?action=wp_update_user_address";
   let form_data = $('#update_address_form').serialize();
     $.ajax({
       url: the_url,
       type: "post",
       dataType: "json",
       data: form_data,
     }).done(function (response) {
         // console.log(response);
       if (response.Status == 1) { 
         $('#response_update_address').removeClass('text-danger').addClass('text-success').html(response.msg).show();//.delay(30000).fadeOut();
          $("html, body").animate({ scrollTop: $('#response_update_address') }, 2500);
         $('#signup>.container').hide();
       }else{
         $('#response_update_address').addClass('text-danger').html(response.msg).show().delay(10000).fadeOut();
          $("html, body").animate({ scrollTop: $("#response_update_address") }, 1500);
       }
     }); //ajax done
     

});//ends change password

});//ends doc ready
</script> 