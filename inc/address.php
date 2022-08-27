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

<script>
$(document).ready(function () {

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
    

});//ends address

});//ends doc ready
</script>