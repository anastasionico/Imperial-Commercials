<?php
//$label = '';// required
$name = (isset($data['name'])) ? $data['name'] : url_title($data['label'], 'underscore', TRUE); 
$id = (isset($data['id'])) ? $data['id'] : $name;
$type = (isset($data['type'])) ? $data['type'] : 'text';
$class = (isset($data['class'])) ? 'form-control ' . $data['class'] : 'form-control';
$value = (isset($data['value'])) ? $data['value'] : set_value($name); // set to validation error, unless set
$readonly = (isset($data['readonly'])) ? $data['readonly'] : FALSE;
$error = form_error($name);
//
//echo strlen(form_error('date'));

?><div class="form-group<?php if(! empty($error)) { ?> has-error<?php } ?>">
  <label for="<?php echo $id; ?>" class="control-label"><?php echo $data['label']; ?></label>
  <input type="<?php echo $type; ?>" name="<?php echo $name; ?>" id="<?php echo $id; ?>" class="<?php echo $class; ?>"<?php if(! empty($value)) { ?> value="<?php echo $value; ?>"<?php } ?><?php if($readonly) { ?> readonly="true"<?php } ?>>
</div>
