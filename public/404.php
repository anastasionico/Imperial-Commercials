<?php if (!defined('PERCH_RUNWAY')) include($_SERVER['DOCUMENT_ROOT'].'/perch/runtime.php');
perch_layout('global.top');
?>

<div class="container">

  <div class="tile tile-grey tile-padded">
    <?php perch_content('Page Content'); ?>
  </div>

</div>

<?php
perch_layout('global.bottom');
?>
