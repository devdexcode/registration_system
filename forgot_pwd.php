<form name="forgot_password" id="forgot_password">
  <div id="response"></div>
  <div class="container">
   <?php if(is_user_logged_in()){ wp_safe_redirect(home_url()); exit();} ?>
    <?php $formBuilder->field(array(
        'container_class'   =>  'row',
        'name'              =>  'username',
        'label'             =>  'Username',
        'id'                =>  'username',
        'required'          =>  'required',
        'type'              =>  'text',
        'label_class'       =>  'the_label',
        'input_class'       =>  'field',
        'label_col'         =>  '',
        'input_col'         =>  ''
    )); ?>

    <div class="row">
        
    </div>
        
    <div class="row mt-4">
    <?php $formBuilder->field(array(
        'container_class' => 'col-md-4 pl-0',
        'name' => 'submit',
        'label'=>'submit',
        'id'=>'submit', 
        'type' => 'submit',
        'input_class'=>'',
    )); ?> 
  </div>

</div>

</form>

<script>
$(document).ready(function () {
           
//Validation init
    $(document).on('click','#submit',function(event){
    
        event.preventDefault();
        let the_url = "<?php echo admin_url('admin-ajax.php') ?>?action=forgot_password";
        let form_data = $('#forgot_password').serialize();
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
                $('#forgot_password>.container').hide();
            }else{
                $('#response').removeClass('text-success').addClass('text-danger').html(response.msg).show().delay(10000).fadeOut();
                scroll_middle('response');
            }
        }); //ajax done
        
    });//ends on click
      
});//ends doc ready
</script> 