<?php
//$label = '';// required
//$options // required
$name = (isset($data['name'])) ? $data['name'] : url_title($data['label'], 'underscore', TRUE); 
$id = (isset($data['id'])) ? $data['id'] : $name;
$type = (isset($data['type'])) ? $data['type'] : 'text';
$class = (isset($data['class'])) ? 'form-control ' . $data['class'] : 'form-control';
$value = (isset($data['value'])) ? $data['value'] : NULL; // set to validation error, unless set
if($value == NULL) {
    foreach($data['options'] as $option_key => $option_value) { 
        if(strlen(set_select($name, $option_key)) > 0) {
            $value = $option_key;
        }
    }
}
$error = form_error($name);
//
//echo strlen(form_error('date'));

?><div class="form-group<?php if(! empty($error)) { ?> has-error<?php } ?>">
  <label for="<?php echo $id; ?>" class="control-label"><?php echo $data['label']; ?></label>
  <select name="<?php echo $name; ?>" id="<?php echo $id; ?>" class="<?php echo $class; ?>">
    <option value="">Select</option>
    <?php foreach($data['options'] as $option_key => $option_value) { ?>
    <option value="<?php echo $option_key; ?>"<?php if($option_key == $value) { ?> selected<?php } ?>><?php echo $option_value; ?></option>
    <? } ?>
  </select>
</div>
