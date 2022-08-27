<form action="#" name="change_password_form" id="change_password_form">
      <div class="row" id="response_password"></div>
    <?php $formBuilder->field([
    'container_class' => 'row',
    'name' => 'user_password',
    'label' => 'Enter current password',
    'id' => 'user_password',
    'required' => 'required',
    'type' => 'password',
    'label_class' => 'the_label',
    'input_class' => 'field password',
    'label_col' => '',
    'input_col' => '',
    // 'description'=>'(Leave blank to keep it unchanged)',
    // 'dbval'=> wp_hash_password($current_user->user_pass)
]);?>
    <hr class="row pt-4 pb-4">
    <div class="row">
    <?php $formBuilder->field([
    'container_class' => 'col-md-6 pl-0 mb-0',
    'name' => 'user_password_new',
    'label' => 'enter new password',
    'id' => 'user_password_new',
    'required' => 'required',
    'type' => 'password',
    'label_class' => 'the_label password',
    'input_class' => 'field',
    'label_col' => '',
    'input_col' => '',
]);?>  <?php $formBuilder->field([
    'container_class' => 'col-md-6 pr-0 mb-0',
    'name' => 'user_password_new_repeat',
    'label' => 'repeat new password',
    'id' => 'user_password_new_repeat',
    'required' => 'required',
    'type' => 'password',
    'label_class' => 'the_label',
    'input_class' => 'field repeat-password',
    'label_col' => '',
    'input_col' => '',
]);?></div>

<div class="row mt-4">
      <?php $formBuilder->field([
    'container_class' => 'col-md-8 pl-0',
    'name' => 'change_password',
    'label' => 'Update Password',
    'id' => 'change_password',
    'type' => 'submit',
    'input_class' => '',
]);?>
</div>

    </form>

<script>
$(document).ready(function () {

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

});//ends doc ready
</script>