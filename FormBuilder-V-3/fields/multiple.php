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
