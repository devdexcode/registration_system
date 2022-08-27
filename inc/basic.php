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

});//ends doc ready
</script>