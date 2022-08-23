<?php
/* * * *
 * Class: FormBuilder
 * Version: 4
 * Date: 22 Aug, 2022
 * Description: Creates form fields
 * Fields: 'text','password', 'textarea', 'email', 'checkbox', 'radio', 'select','countries','kvselect' 'multiselect', 'multiple', 'date','date_special', 'image','wp_color', 'wp_upload', 'range', 'submit'
 * * * * */
class FormBuilder
{

    public $args_help = array(
        'type' => 'THE TYPE OF THE FIELD, IF LEFT SHALL ASSUMED input type text<hr/>',
        'name' => 'THE NAME',
        'id' => 'THE ID',
        'label OR placeholder' => 'THE LABEL OR PLACEHOLDER',
        'NOTE FOR THE ABOVE 3' => 'IF ANY ONE OF THE name/id/label WAS PROVIDED, IT WILL TAKE CARE OF THE REST<hr/>',
        'label_col' => 'class of the label column for example col-md-4',
        'input_col' => 'class of the input column for example col-md-8',
        'required OR req' => 'IS REQUIRED OR NOT',
        'type_class' => 'alpha:alphabets only,numeric: numbers only,alphanumeric: exclude all special chars',
        'description' => 'DESCRIPTION DIV BELOW THE INPUT',
        'dbval' => 'THE VALUE COMING FROM DATABSE',
        'container_class' => 'CSS CLASS OF THE ABOVE div CONTINER',
        'options' => 'THE OPTIONS FOR: radio/select/multiple',
        'for range' => 'min & max: ARE MUST',
        'input_class' => 'APPLY COLUMN CLASSES DIRECT TO input EXCEPT ceheckbox/radiobutton/fileupload/multiple', //
        'NOTE:' => ' Want jQuery Validation? just add:  $form_builder = new FormBuilder(); $form_builder->jQuery_validation(); to your footer after jQuery and inside your onclick add: form_validator(".form_builder_submit",".form_builder_field.required"); And added new js classes alpha,numeric,alpha_numeric and alpha_numeric_dash or no_special_chars',
        'Available types in version 4' => "'wp_color', 'wp_upload','text','password', 'textarea', 'email', 'checkbox', 'radio', 'select','countries','kvselect' 'multiselect', 'multiple', 'date','date_special', 'image', 'range', 'submit' ",
    );

/****************************|THE FIELD|******************************/

    public function field($args)
    {
        
        foreach ($args as $k => $v) {
            $$k = $v;
        }
        $types = array('text','password', 'textarea', 'email', 'checkbox', 'radio', 'select','countries','kvselect','multiselect','multiple', 'date','date-special', 'image', 'range','wp_color', 'wp_upload', 'submit');

        if ((!isset($name) || empty($name)) ) {
            echo "<div class='text-danger form-group row'>Please specify field name.</div>";
            return;
        } elseif (  (!isset($id) || empty($id))  ) {
            echo "<div class='text-danger form-group row'>Please specify field id.</div>";
            return;
        } elseif ( !empty($id) && (!isset($label) )) {
            echo "<div class='text-danger form-group row'>Please specify field label.</div>";
            return;
        } elseif (  (!isset($id) || empty($id)) && (!isset($label) || empty($label))) {
            echo "<div class='text-danger form-group row'>Please specify field id and label.</div>";
            return;
        }
           $the_label = ucfirst($this->make_label($label));
            $the_id = $id;
            $the_name = $name;
        
        ?>
            <?php
        if ($type === "range") {
            if (($min == "") || ($min == "")) {
                echo "<div class='text-danger form-group row'>Please specify min & max values for range.</div>";
                return;
            }
        }
        ?>
<div class="form-group form_builder_row <?php echo $the_id ?>_container <?php echo $container_class != "" ? $container_class : ''; ?>">
<?php if (isset($label_col) && $label_col != "") {?><div class="<?php echo $label_col ?> form_builder_col"><?php }?>
<?php if($type != "submit"):?>
    <label class="control-label <?php echo @$label_class != "" ? $label_class : ''; ?> <?=$the_name;?>_label <?php echo ($type != 'checkbox') ? '' : 'order-md-2'; ?>" for="<?php echo $the_id; ?>">
            <?php if (($type == 'checkbox' || $type == 'radio')): ?><span><?php endif;?><?=@$the_label;?>:<?php if (($type == 'checkbox' || $type == 'radio')): ?></span><?php endif;?>
                <?php echo (isset($required) || @$required !== null || !empty(@$required) ? '<span class="text-danger">*</span>' : ''); ?>
    </label>
<?php endif;//ends type=submit?>            
<?php if (isset($label_col) && $label_col != "") {?></div><?php }?>
<?php if (isset($input_col) && $input_col != "") {?><div class="<?php echo $input_col ?> form_builder_col"><?php }?>
    <?php
    if (in_array($type, $types)) {
        // include 'fields/' . $type . '.php';
        $this->$type($args);
    } else {
        // include 'fields/text.php';
        $this->text($args);
    }
    ?>
<?php if (isset($input_col) && $input_col != "") {?></div><?php }?>
</div>
<?php if (!empty(@$help)): ?>
    <?php $this->help();?>
<?php endif;?>
<?php
}

    public function make_label($str)
    {
        // Remove all characters except A-Z, a-z, 0-9
        $str = preg_replace('/[^A-Za-z0-9 -_]/', ' ', $str);
        // Replace sequences of spaces
        $str = preg_replace('/  */', ' ', $str);
        $str = preg_replace('/-/', ' ', $str);
        $str = preg_replace('/_/', ' ', $str);
        return $str;
    }
 
/**********************************************************************************************************************/
/******************************** | THE FIELDS | *********************************************************************/
/**********************************************************************************************************************/


/*  
 * 1. TEXT
 * * * * * * * * */
public function text($args){
    foreach ($args as $k => $v) {
        $$k = $v;
    }
    ?>
      <input type="text" 
  class="<?=isset($type_class) && $type_class!="" ? $type_class :'';?><?=(@$required != ""?'required':'');?> form_builder_field form-control <?=$input_class != "" ? $input_class:''; ?> <?=$the_id?> input-<?=$type;?> field_<?=$the_id?>" 
  id="<?=$the_id?>" name="<?=$the_name?>" 
  value="<?=(@$dbval != ""?$dbval:(isset($_REQUEST[$the_name])?$_REQUEST[$the_name]:''));?>" 
  <?=(@$required != ""?'required="required"':'');?> 
  placeholder="<?=$the_label?>" 
  data-id="<?=$the_id?>" 
  minlength="<?=(isset($min) && $min !="") ? $min : '';?>" maxlength="<?=(isset($max) && $max !="") ? $max : '';?>">
  <div class="description response"><?=@$desc || @$description !=""?@$desc || @$description :'';?></div>
    <?php 
}


/*  
 * 2. TEXTAREA
 * * * * * * * * */
public function textarea($args){
    foreach ($args as $k => $v) {
        $$k = $v;
    }
    ?>
  <textarea class="form_builder_field <?=(@$required != ""?'required':'');?> form-control <?=($input_class !="" ? $input_class:''); ?> <?=$the_id?> input-<?=$type;?> field_<?=$the_id?>" id="<?=$the_id?>" name="<?=$the_name?>" <?=(@$required != ""?'required="required"':'');?> placeholder="<?=$the_label?>" data-id="<?=$the_id?>"><?=(@$dbval != ""?$dbval:(isset($_REQUEST[$the_name])?$_REQUEST[$the_name]:''));?></textarea>
  <div class="description response"><?=@$desc || @$description !=""?@$desc || @$description :'';?></div>
    <?php 
}


/*  
 * 3. EMAIL
 * * * * * * * * */
public function email($args){
    foreach ($args as $k => $v) {
        $$k = $v;
    }
    ?>
<input type="email" 
  class="form_builder_field <?=(@$required != ""?'required':'');?> form-control <?= $input_class != "" ? $input_class:''; ?> <?=$the_id?> input-<?=$type;?> field_<?=$the_id?>" 
  id="<?=$the_id?>" name="<?=$the_name?>" 
  value="<?=(@$dbval != ""?$dbval:(isset($_REQUEST[$the_name])?$_REQUEST[$the_name]:''));?>" 
  <?=(@$required != ""?'required="required"':'');?> 
  placeholder="<?=$the_label?>"
   data-id="<?=$the_id?>">
  <div class="description response"><?=@$desc || @$description !=""?@$desc || @$description :'';?></div>
    <?php 
}



/*  
 * 4. CHECKBOX
 * * * * * * * * */
public function checkbox($args){
    foreach ($args as $k => $v) {
        $$k = $v;
    }
    ?>
<?php if( @$input_class != "" ) {?>
  <div class="order-md-1 <?=@$input_class;?> display-table" style=" display:table;">
<?php }?>

  <input type="checkbox" class=" form_builder_field <?=(@$required != ""?'required':'');?>
  form-control  <?=$the_id?> input-<?=$type;?> field_<?=$the_id?> table-cell" 
  id="<?=$the_id?>" 
  name="<?=$the_name?>" 
  value="yes" <?=(@$required != ""?'required="required"':'');?> 
  data-id="<?=$the_id?>" 
  <?php echo (@$dbval == "yes"?'checked="checked"':(isset($_REQUEST[$the_name]) ? 'checked="checked"':''));?>  style=" display:table-cell;">
  <?php if( @$input_class != "" ) {?>
  </div>
  <?php }?>    
  <div class="description response"><?=@$desc || @$description !=""?@$desc || @$description :'';?></div>
    <?php 
}


/*  
 * 5. RADIO BUTTON
 * * * * * * * * */
public function radio($args){
    foreach ($args as $k => $v) {
        $$k = $v;
    }
    ?>
<?php foreach($options as $option):?>
  <label class="<?=$input_class != "" ? $input_class:''; ?> "><input type="radio" 
  class="form_builder_field <?=(@$required != ""?'required':'');?> <?=$the_id?> input-<?=$type;?> field_<?=$the_id?>" 
  id="<?=$option;?>" 
  name="<?=@$the_name?>" 
  <?php echo (@$dbval == @$option?'checked="checked"':(isset($_REQUEST[@$the_name]) && $_REQUEST[@$the_name]==@$option? 'checked="checked"':''));?>
  data-id="<?=@$the_name?>"
  value="<?=$option;?>">
  <span><?=ucfirst(@$option);?></span>
</label>
<?php endforeach;?>
  <div class="response description"><?=@$desc || @$description !=""?@$desc || @$description :'';?></div>
    <?php 
}




/*  
 * 6. SELECT
 * * * * * * * * */
public function select($args){
    foreach ($args as $k => $v) {
        $$k = $v;
    }
    ?>
<select class="form_builder_field <?=(@$required != ""?'required':'');?> <?=$input_class != "" ? $input_class:''; ?> <?=$the_id?> input-<?=$type;?> field_<?=$the_id?> form-control" id="<?=$the_id?>" 
  name="<?=$the_name?>" data-id="<?=$the_name?>">
  <option></option>
<?php foreach(@$options as $option):?>
    <option value="<?=(@$option);?>" <?php echo (@$dbval == @$option?'selected="selected"':((isset($_REQUEST[@$the_name]) && $_REQUEST[@$the_name]==@$option) ? 'selected="selected"':''));?>><?=ucfirst(@$option);?></option>
<?php endforeach;?>
</select>
  <div class="description response"><?=@$desc || @$description !=""?@$desc || @$description :'';?></div>
    <?php 
}




/*  
 * 7. MULTISELECT
 * * * * * * * * */
public function multiselect($args){
    foreach ($args as $k => $v) {
        $$k = $v;
    }
    ?>
<select class="form_builder_field <?=(@$required != ""?'required':'');?> <?=$input_class != "" ? $input_class:''; ?> <?=$the_id?> input-<?=$type;?> field_<?=$the_id?> form-control" id="<?=$the_id?>" 
  name="<?=$the_name?>[]" multiple="multiple" data-id="<?=$the_name?>">
  <option></option>
<?php foreach(@$options as $option):?>
    <option value="<?=(@$option);?>" <?php echo (@$dbval == $option ?'selected="selected"':(isset($_REQUEST[@$the_name]) && in_array($option,$_REQUEST[@$the_name]) ? 'selected="selected"':''));?>><?=ucfirst(@$option);?></option>
<?php endforeach;?>
</select>
  <div class="description response"><?=@$desc || @$description !=""?@$desc || @$description :'';?></div>
    <?php 
}


/*  
 * 8. MULTIPLE
 * * * * * * * * */
public function multiple($args){
    foreach ($args as $k => $v) {
        $$k = $v;
    }
    ?>
<?php foreach(@$options as $option):?>
  <label class="<?=$input_class != "" ? $input_class:''; ?> "> 
  <input type="checkbox" 
  class="form_builder_field <?=(@$required != ""?'required':'');?> <?=$the_id?> input-<?=$type;?> input-checkbox field_<?=$the_id?>" 
  id="<?=$option;?>" 
  name="<?=$the_name?>[]" 
  <?php echo (@$dbval == $option ?'checked="checked"':(isset($_REQUEST[@$the_name]) && in_array($option,$_REQUEST[@$the_name]) ? 'checked="checked"':''));?>
  data-id="<?=$the_name?>"
  value="<?=$option;?>">
  <span><?=ucfirst(@$option);?></span>
  </label>
<?php endforeach;?>
<div class=" response description"><?=@$desc || @$description !=""?@$desc || @$description :'';?></div>
    <?php 
}



/* 
 * 9. COUNTRIES
 * * * * * * * * */
public function countries($args){
    foreach ($args as $k => $v) {
        $$k = $v;
    }
    ?>
 <?php $countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");?>
<select class="form_builder_field <?=(@$required != ""?'required':'');?> <?=$input_class != "" ? $input_class:''; ?> <?=$the_id?> input-<?=$type;?> type-select field_<?=$the_id?> form-control" id="<?=$the_id?>" 
  name="<?=$the_name?>" data-id="<?=$the_name?>">
  <option></option>
<?php foreach(@$countries as $country):?>
    <option value="<?=(@$country);?>" <?php echo (@$dbval == @$country?'selected="selected"':((isset($_REQUEST[@$the_name]) && $_REQUEST[@$the_name]==@$country) ? 'selected="selected"':''));?>><?=ucfirst(@$country);?></option>
<?php endforeach;?>
</select>
  <div class="description response"><?=@$desc || @$description !=""?@$desc || @$description :'';?></div>
    <?php 
}



/* 
 * 10. PASSWORD
 * * * * * * * * */
public function password($args){
    foreach ($args as $k => $v) {
        $$k = $v;
    }
    ?>
  <input type="password" 
  class="<?=isset($type_class) && $type_class!="" ? $type_class :'';?><?=(@$required != ""?'required':'');?> 
  form_builder_field form-control <?=$input_class != "" ? $input_class:''; ?> <?=$the_id?> 
  input-<?=$type;?> field_<?=$the_id?>" 
  id="<?=$the_id?>" name="<?=$the_name?>" 
  value="<?=(@$dbval != ""?$dbval:(isset($_REQUEST[$the_name])?$_REQUEST[$the_name]:''));?>" 
  <?=(@$required != ""?'required="required"':'');?> 
  placeholder="<?=$the_label?>" 
  data-id="<?=$the_id?>" 
  minlength="<?=(isset($min) && $min !="") ? $min : '';?>" maxlength="<?=(isset($max) && $max !="") ? $max : '';?>">
  <div class="description response"><?=@$desc || @$description !=""?@$desc || @$description :'';?></div>
    <?php 
}



/* 
 * 11. DATE
 * * * * * * * * */
public function date($args){
    foreach ($args as $k => $v) {
        $$k = $v;
    }
    ?>
  <div class="<?=$input_class != "" ? $input_class:''; ?>">

<?php if(isset($dbval)){ $time = strtotime($dbval);$the_date = date('d-m-Y',$time);}elseif(isset($_REQUEST[$the_name])){ $time = strtotime($_REQUEST[$the_name]);$the_date = date('d-m-Y',$time);}?>
<input type="date" 
class="form_builder_field <?=(@$required != ""?'required':'');?> form-control <?=$the_id?> input-<?=$type;?> type-date field_<?=$the_id?>"
 id="<?=$the_id?>" name="<?=$the_name?>" 
 value="<?=(@$dbval != ""?$dbval:(isset($_REQUEST[$the_name])?$_REQUEST[$the_name]:''));?>" 
 <?=(@$required != ""?'required="required"':'');?> 
 data-id="<?=$the_id?>" 
 data-date="<?=$the_date;?>">
</div>
<div class="response description"><?=@$desc || @$description !=""?@$desc || @$description :'';?></div>
    <?php 
}


/* 
 * 12. SELECT KEY VALUE
 * * * * * * * * */
public function kvselect($args){
    foreach ($args as $k => $v) {
        $$k = $v;
    }
    ?>
<select class="form_builder_field <?=(@$required != ""?'required':'');?> <?=$input_class != "" ? $input_class:''; ?> <?=$the_id?> input-<?=$type;?> type-select kvselect field_<?=$the_id?> form-control" id="<?=$the_id?>" 
  name="<?=$the_name?>" data-id="<?=$the_name?>">
  <option></option>
<?php foreach(@$options as $k => $v):?>
    <option value="<?=(@$k);?>" <?php echo (@$dbval == @$k?'selected="selected"':((isset($_REQUEST[@$the_name]) && $_REQUEST[@$the_name]==@$k) ? 'selected="selected"':''));?>><?=ucfirst(@$v);?></option>
<?php endforeach;?>
</select>
  <div class="description response"><?=@$desc || @$description !=""?@$desc || @$description :'';?></div>
    <?php 
}



/* 
 * 13. IMAGE
 * * * * * * * * */
public function image($args){
    foreach ($args as $k => $v) {
        $$k = $v;
    }
    ?>
<div class="<?=$input_class != "" ? $input_class : '';?> <?=$the_id?> input-<?=$type;?> field_<?=$the_id?>">
    <input type="hidden" 
    value="<?=(@$dbval != "" ? @$dbval : @$val);?>" 
    id="<?=$the_name?>" name="<?=$the_name?>_value" 
    class="img_src hidden" data-id="<?=$the_id?>">
    <input type="file" class="form_builder_field <?=(@$required != ""?'required':'');?> 
    <?=$the_name?>_file btn btn-outline pull-left" 
    id="<?=$the_id?>" name="<?=$the_name?>" 
    <?=(@$required != "" ? 'required="required"' : '');?>
     accept="image/*" 
     style="width:70%;"
     onChange="document.getElementById('<?=$the_id?>_preview').src = window.URL.createObjectURL(this.files[0]);document.getElementById('<?=$the_id?>_preview').style.display = 'block'"/>
    <!-- <button type="button" id="<?=$the_name?>_btn" class="btn btn-info btn-upload">Upload</button> -->
    <img src="<?=(@$dbval != "" ? $dbval : '');?>" id="<?=$the_name?>_preview" class="img-disp pull-right img-thumbnail" style="max-width:90px;display:none;"/>
    <div class="col-sm-12 text-danger" id="<?=$the_name?>_photo_resp"></div>
    <div class="description response"><?=@$desc || @$description !=""?@$desc || @$description :'';?></div>
</div>
    <?php 
}



/* 
 * 14. DATE SPECIAL
 * * * * * * * * */
public function date_special($args){
    foreach ($args as $k => $v) {
        $$k = $v;
    }
    ?>
  <div class="<?=$input_class != "" ? $input_class:''; ?>">

    <?php if(isset($dbval)){ $time = strtotime($dbval);$the_date = date('d-m-Y',$time);}elseif(isset($_REQUEST[$the_name])){ $time = strtotime($_REQUEST[$the_name]);$the_date = date('d-m-Y',$time);}?>
    <input type="text" 
    class="form_builder_field <?=(@$required != ""?'required':'');?> form-control <?=$the_id?> input-<?=$type;?> field_<?=$the_id?>"
     id="<?=$the_id?>" name="<?=$the_name?>" 
     value="<?=(@$dbval != ""?$dbval:(isset($_REQUEST[$the_name])?$_REQUEST[$the_name]:''));?>" 
     <?=(@$required != ""?'required="required"':'');?> 
     data-id="<?=$the_id?>" 
     data-date="<?=$the_date;?>">
     <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
     <script>
(function($){
  //$('head').append('<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript" />');
  $('head').append('<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />');
  
  $('#<?=$the_name?>').datepicker({
    uiLibrary: 'bootstrap4',
    format: 'dd mmm yyyy' 
  });
  
})(jQuery);
</script>    
</div>
<div class="response description"><?=@$desc || @$description !=""?@$desc || @$description :'';?></div>
    <?php 
}



/* 
 * 15. RANGE
 * * * * * * * * */
public function range($args){
    foreach ($args as $k => $v) {
        $$k = $v;
    }
    ?>
<div class="<?=$input_class != "" ? $input_class : '';?>">
<input type="range" 
class="form_builder_field  form-control <?=(@$required != ""?'required':'');?> <?=$the_id?> input-<?=$type;?> field_<?=$the_id?>"
name="weight" id="<?=$the_id?>" 
value="<?=(@$dbval != ""?$dbval:(isset($_REQUEST[$the_name])?$_REQUEST[$the_name]:''));?>" <?=(@$required != ""?'required="required"':'');?>
min="<?=@$min?>" max="<?=@$max?>" 
oninput="range_weight_disp.value = <?=$the_name?>.value">
   <output id="range_weight_disp"><?=$_POST[$the_name];?></output>
   <div class="description response"><?=@$desc || @$description !=""?@$desc || @$description :'';?></div>
</div>   
    <?php 
}


/* 
 * 16. WORDPRESS COLOR
 * * * * * * * * */
public function color($args){
    foreach ($args as $k => $v) {
        $$k = $v;
    }
    ?>
  <input type="text" 
  class="cpa-color-picker <?=isset($type_class) && $type_class!="" ? $type_class :'';?><?=(@$required != ""?'required':'');?> form_builder_field form-control <?=$input_class != "" ? $input_class:''; ?> <?=$the_id?> input-<?=$type;?> field_<?=$the_id?>" 
  id="<?=$the_id?>" name="<?=$the_name?>" 
  value="<?=(@$dbval != ""?$dbval:'');?>" 
  <?=(@$required != ""?'required="required"':'');?> 
  data-id="<?=$the_id?>">
  <div class="description response"><?=@$desc || @$description !=""?@$desc || @$description :'';?></div>
    <?php 
}



/* 
 * 17. WORDPRESS UPLOAD
 * * * * * * * * */
public function wp_upload($args){
    foreach ($args as $k => $v) {
        $$k = $v;
    }
    ?>
<input type="text" readonly name="<?=$the_name?>" id="<?=$the_id?>" value="<?= ($dbval  != "") ? ($dbval ) : ''; ?>" 
class=" col-sm-6 form-control <?=isset($type_class) && $type_class!="" ? $type_class :'';?><?=(@$required != ""?'required':'');?> form_builder_field form-control <?=$input_class != "" ? $input_class:''; ?> <?=$the_id?> input-<?=$type;?> field_<?=$the_id?>" />
<input class="btn btn-primary" type="button" name="<?=$the_id?>" id="<?=$the_id?>-btn" class="btn btn-primary" value="Upload Image" data-id="<?=$the_id?>">
<div class="<?=$the_id?>_imagearea  col-sm-3">
    <div class="images_parent_class">
        <div class="<?=$the_id?>-delete delete_btn">X</div>
        <img src="<?= ($dbval  != "") ? ($dbval) : ''; ?>" id="<?=$the_id?>-img" class="<?= ($dbval  != "") ? 'img-thumbnail' : ''; ?>" style="margin-left: auto; margin-right: auto; display: block;"/>
    </div>
</div>

<div class="description response"><?=@$desc || @$description !=""?@$desc || @$description :'';?></div>
        <script>
var $ = jQuery;
jQuery(document).ready(function ($) {
$("#<?=$the_id?>-btn").click(function (e) {
    e.preventDefault();
    var image = wp.media({
        title: "Upload Image",
        // mutiple: true if you want to upload multiple files at once
        multiple: false
    }).open()
            .on("select", function (e) {
                // This will return the selected image from the Media Uploader, the result is an object
                var uploaded_image = image.state().get("selection").first();
                // We convert uploaded_image to a JSON object to make accessing it easier
                // Output to the console uploaded_image
                console.log(uploaded_image);
                var image_url = uploaded_image.toJSON().url;
                // Lets assign the url value to the input field
                $('#<?=$the_id?>').val(image_url);
                $('#<?=$the_id?>-img').attr('src', image_url);
                $('#<?=$the_id?>-img').addClass();
                $('.<?=$the_id?>-delete').show();
            });
});
});
$(document).on('click', '.<?=$the_id?>-delete', function () {
$('#<?=$the_id?>').val('');
$('#<?=$the_id?>-img').attr('src', '');
$('.<?=$the_id?>-delete').hide();
});
</script>
<style>.<?=$the_id?>-delete{display: none;<?= ($dbval != "") ? 'display: block;' : '' ?> color: white;font-weight: bold;cursor: pointer;position: absolute;top: -10px;right: -10px;border: 2px solid red;border-radius: 50px;text-align: center; width: 18px;height: 18px;background-color: red;}
.images_parent_class{display: inline-block;position:relative;width: 150px;height: 150px;}
.images_parent_class img{max-width:100%;width:100%;height:auto;}.<?=$the_id?>_imagearea {float: right;}</style>
    <?php 
}



/* 
 * 18. SUBMIT
 * * * * * * * * */
public function submit($args){
    foreach ($args as $k => $v) {
        $$k = $v;
    }
    ?>
  <button type="submit" 
  class="form_builder_submit submit_button button_<?=$the_id?> button btn btn-primary" 
  id="<?=$the_id?>" name="<?=$the_name?>" 
  data-id="<?=$the_id?>"><?=$the_label?></button>
  <div class="description response"><?=@$desc || @$description !=""?@$desc || @$description :'';?></div>
    <?php 
}





/* 
 * THE HELP
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
public function help()
{
    ob_start();?>
        <div class="container">
        <div class="row">
<h3 style="width:100%;">Help:</h3>
<p><strong>Available args with notes:</strong></p>
<ul>
<?php foreach ($this->args_help as $key => $value): ?>
    <li><strong><?=$key?></strong> <?=$value;?></li>
<?php endforeach;?>
</ul>
<small><em>To hide this remove h or help from the function args</em></small>
        </div>
        </div>
<?php $html = ob_get_clean();
    echo $html;
}


}

?>