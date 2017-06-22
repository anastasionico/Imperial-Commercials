<?php
$name = (isset($data['name'])) ? $data['name'] : url_title($data['label'], 'underscore', TRUE); 
$value = (isset($data['value'])) ? $data['value'] : 1;
$checked = (isset($data['checked'])) ? $data['checked'] : set_checkbox($name, $value); // can be true or 1 to enable
$error = form_error($name);
$disabled = (isset($data['disabled'])) ? $data['disabled'] : FALSE;
if(! empty($error)) { ?><div class="has-error">
<?php } ?><div class="checkbox">
  <label>
    <input type="checkbox" name="<?php echo $name; ?>" value="<?php echo $value; ?>"<?php if($checked) { ?> checked<?php } ?><?php if($disabled) { ?> disabled<?php } ?>>
    <?php echo $data['label']; ?>
  </label>
</div>
<?php if(! empty($error)) { ?></div>
<?php } ?>
