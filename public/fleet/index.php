<?php if (!defined('PERCH_RUNWAY')) include($_SERVER['DOCUMENT_ROOT'].'/perch/runtime.php');
perch_layout('global.top');
?>

    <div class="container">
      <div class="page-header">
        <h1><?php perch_content('Page Header'); ?></h1>
      </div>
    </div>

    <div class="container">
      <?php perch_content('Page Content'); ?>
    </div>

<?php
perch_layout('global.bottom');
?>
