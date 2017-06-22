<?php
include('../perch/runtime.php');
perch_layout('global.ford');
?>

<div class="container">
  <div class="row gutter-10">
    <div class="col-md-12">
      <?php perch_content('Top Image'); ?>
      <?php perch_content('Top Text'); ?>
    </div>
  </div>
  <div class="row gutter-10">
    <div class="col-md-6">
      <?php perch_content('Row 2 Image Left'); ?>
    </div>
    <div class="col-md-6">
      <?php perch_content('Row 2 Image Right'); ?>
    </div>
  </div>
  <div class="row gutter-10">
    <div class="col-md-12">
      <?php perch_content('Row 3 Text'); ?>
    </div>
  </div>

  <div class="row gutter-10">
    <div class="col-md-4">
      <?php perch_content('Row 4 Text Left'); ?>
    </div>
    <div class="col-md-4">
      <?php perch_content('Row 4 Image'); ?>
    </div>
    <div class="col-md-4">
      <?php perch_content('Row 4 Text Right'); ?>
    </div>
  </div>

  <div class="row gutter-10">
    <div class="col-md-4">
      <?php perch_content('Row 5 Text Left'); ?>
    </div>
    <div class="col-md-4">
      <?php perch_content('Row 5 Text Middle'); ?>
    </div>
    <div class="col-md-4">
      <?php perch_content('Row 5 Text Right'); ?>
    </div>
  </div>

  <div class="row gutter-10">
    <div class="col-md-4">
      <?php perch_content('Row 6 Text Left'); ?>
    </div>
    <div class="col-md-4">
      <?php perch_content('Row 6 Image'); ?>
    </div>
    <div class="col-md-4">
      <?php perch_content('Row 6 Text Right'); ?>
    </div>
  </div>

</div>

<?php
perch_layout('global.ford.bottom');
?>
