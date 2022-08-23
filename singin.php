<?php if(is_user_logged_in()){ wp_safe_redirect(home_url()); exit();} ?>
<form name="signin" id="signin">
  <div id="response"></div>
  <div class="container">
   
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
    <div class="row">
        
    </div>
        
    <div class="row mt-4">
    <?php $formBuilder->field(array(
        'container_class' =>  'col-md-4 pl-0',
        'name'            =>  'submit',
        'label'           =>  'submit',
        'id'              =>  'submit', 
        'type'            =>  'submit',
        'input_class'     =>  '',
    )); ?>
    <div class="col-md-4 text-center">
      <p class="pl-0" id="forgot_" style="display: none;">Forogt password?&nbsp;<a href="<?php echo site_url()?>/forgot-password/">Reset Here</a></p>
    </div> 
    <div class="col-md-4 pr-0 text-right">
      <p class="pl-0 text-right"">Don't have an account?&nbsp;<a href="<?php echo site_url()?>/signup/">Sign-up Here</a></p>
    </div>  
  </div>
    

</div></form>

    <script>
        $(document).ready(function () {
           
//Validation init
$(document).on('click','#submit',function(event){
  // event.preventDefault();
      $("#signin").validate({
      rules:{
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
    let the_url = "<?php echo admin_url('admin-ajax.php') ?>?action=the_wp_signin";
    let form_data = $('#signin').serialize();
      $.ajax({
        url: the_url,
        type: "post",
        dataType: "json",
        data: form_data,
      }).done(function (response) {
          console.log(response);
        if (response.Status == 1) { 
          $('#response').removeClass('text-danger').addClass('text-success').html(response.msg).show();
          scroll_middle('response');
          $('#signin>.container').hide();
          window.location.replace(response.wp_redirect);
        //   window.location.href = response.wp_redirect;
        }else{
          $('#response').removeClass('text-success').addClass('text-danger').html(response.msg).show().delay(10000).fadeOut();
          $('#forgot_').show();
          scroll_middle('response');
        }
      }); //ajax done
      
    }//submit handler
    });//validation ends
});//ends on click
      
});//ends doc ready

</script> 