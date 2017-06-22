<?php
//$label = '';// required
$name = (isset($data['name'])) ? $data['name'] : url_title($data['label'], 'underscore', TRUE); 
$id = (isset($data['id'])) ? $data['id'] : $name;
$type = (isset($data['type'])) ? $data['type'] : 'text';
$class = (isset($data['class'])) ? 'form-control ' . $data['class'] : 'form-control';
$value = (isset($data['value'])) ? $data['value'] : set_value($name); // set to validation error, unless set
$error = form_error($name);
$rows = (isset($data['rows'])) ? $data['rows'] : 3;
//
//echo strlen(form_error('date'));

?><div class="form-group<?php if(! empty($error)) { ?> has-error<?php } ?>">
  <label for="<?php echo $id; ?>" class="control-label"><?php echo $data['label']; ?></label>
  <textarea id="<?php echo $id; ?>" name="<?php echo $name; ?>" class="<?php echo $class; ?>" rows="<?php echo $rows; ?>"><?php echo $value; ?></textarea>
</div>
