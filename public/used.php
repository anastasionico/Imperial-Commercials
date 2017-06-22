<?php if (!defined('PERCH_RUNWAY')) include($_SERVER['DOCUMENT_ROOT'].'/perch/runtime.php');
perch_layout('global.top');
?>

<div class="container">
  <?php perch_content('Page Breadcrumbs'); ?>
  <div class="tile tile-grey tile-padded">
    <?php perch_content('Page Content Top'); ?>
  </div>

  <div class="row gutter-10">
    <div class="col-md-6">
      <div class="tile tile-image tile-bordered">
        <a href="/used/vans">
          <?php perch_content('Image Vans'); ?>
        </a>
      </div>
    </div>
    <div class="col-md-6">
      <div class="tile tile-image tile-bordered">
        <a href="/used/trucks">
          <?php perch_content('Image Trucks'); ?>
        </a>
      </div>
    </div>
  </div>

  <div class="tile tile-grey tile-padded">
    <?php perch_content('Page Content Bottom'); ?>
  </div>

</div>

<?php
perch_layout('global.bottom');
?>
