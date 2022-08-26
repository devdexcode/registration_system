<form name="signup" id="signup">
  <div id="response"></div>
  <div class="container"><?php if(is_user_logged_in()){ wp_safe_redirect(home_url()); exit();} ?>
    <div class="form_builder_row name_container row">
      <?php $formBuilder->field(array(
        'container_class' => 'col-md-6 pl-0 mb-0',
        'name' => 'first_name',
        'label'=>'First Name',
        'id'=>'first_name',
        'required' => 'required',
        'type' => 'text',
        'label_class'=>'the_label',
        'input_class'=>'field',
        'label_col'=>'',
        'input_col'=>''
    )); ?>
    <?php $formBuilder->field([
        'container_class' => 'col-md-6 pr-0 mb-0',
        'name' => 'last_name',
        'label'=>'Last Name',
        'id'=>'last_name',
        'required' => 'required',
        'type' => 'text',
        'label_class'=>'the_label',
        'input_class'=>'field',
        'label_col'=>'',
        'input_col'=>''
    ]); ?></div>
    <?php $formBuilder->field(array(
        'container_class' => 'row',
        'name' => 'username',
        'label'=>'Userame',
        'id'=>'username',
        'required' => 'required',
        'type' => 'text',
        'label_class'=>'the_label',
        'input_class'=>'field',
        'label_col'=>'',
        'input_col'=>''
    )); ?>
    <?php $formBuilder->field(array(
        'container_class' => 'row',
        'name' => 'user_email',
        'label'=>'email',
        'id'=>'user_email',
        'required' => 'required',
        'type' => 'email',
        'label_class'=>'the_label',
        'input_class'=>'field',
        'label_col'=>'',
        'input_col'=>''
    )); ?>
    <?php $formBuilder->field(array(
        'container_class' => 'row',
        'name' => 'user_password',
        'label'=>'password',
        'id'=>'user_password',
        'required' => 'required',
        'type' => 'password',
        'label_class'=>'the_label',
        'input_class'=>'field',
        'label_col'=>'',
        'input_col'=>''
    )); ?>
    <div class="row mt-4">
    <?php $formBuilder->field(array(
        'container_class' => 'col-md-8 pl-0',
        'name' => 'submit',
        'label'=>'submit',
        'id'=>'submit', 
        'type' => 'submit',
        'input_class'=>'',
    )); ?>
    <div class="col-md-4 pr-0 text-right">
      <p>Already have an account? <a href="<?php echo site_url();?>/signin">Sign-in here</a></p>
    </div>  
  </div>
    
  </div></form>
<script>
$(document).ready(function () {        
//Validation init
$(document).on('click','#submit',function(event){
  // event.preventDefault();
      $("#signup").validate({
      rules:{
        first_name: {
        required: true,
        minlength: 3,
        maxlength: 30
        },
        last_name: {
        required: true,
        minlength: 3,
        maxlength: 30
        },
        username: {
        required: true,
        minlength: 3,
        maxlength: 30
        },
        user_password: {
        required: true,
        minlength: 3,
        maxlength: 30
        }
      },
    submitHandler: function(form) {	
      event.preventDefault();
    let the_url = "<?php echo admin_url('admin-ajax.php') ?>?action=wp_signup";
    let form_data = $('#signup').serialize();
      $.ajax({
        url: the_url,
        type: "post",
        dataType: "json",
        data: form_data,
      }).done(function (response) {
          // console.log(response);
        if (response.Status == 1) { 
          // $('#response').removeClass('alert-error').addClass('text-success lead').html(response.msg).show();//.delay(30000).fadeOut();
          $('#response').removeClass('text-danger').html(response.msg).show();//.delay(30000).fadeOut();
          // $("html, body").animate({ scrollTop: $('#response') }, 2500);
          scroll_middle('response');
          $('#signup>.container').hide();
        }else{
          $('#response').addClass('text-danger').html(response.msg).show().delay(10000).fadeOut();
          // $("html, body").animate({ scrollTop: $("#response") }, 1500);
          scroll_middle('response');
        }
      }); //ajax done
      
    }//submit handler
    });//validation ends
});//ends on click
      
});//ends doc ready
</script> 