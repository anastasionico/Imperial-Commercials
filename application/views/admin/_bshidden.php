<?php
// $name // required
$name = $data['name'];
$id = (isset($data['id'])) ? $data['id'] : $name;
$type = (isset($data['type'])) ? $data['type'] : 'text';
$class = (isset($data['class'])) ? 'form-control ' . $data['class'] : 'form-control';
$value = (isset($data['value'])) ? $data['value'] : set_value($name); // set to validation error, unless set
$error = form_error($name);
//
//echo strlen(form_error('date'));

?>
<input type="hidden" name="<?php echo $name; ?>" id="<?php echo $id; ?>" class="<?php echo $class; ?>"<?php if(! empty($value)) { ?> value="<?php echo $value; ?>"<?php } ?>>
