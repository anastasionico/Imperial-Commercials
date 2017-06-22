<?php
include('../perch/runtime.php');
perch_layout('global.ford');
?>

<div class="container">
  <div class="row gutter-10">
    <div class="col-md-12">
      <a href="<?php perch_content('Top Image Link Address'); ?>">
        <?php perch_content('Top Image'); ?>
      </a>
    </div>
  </div>
  <div class="row gutter-10">
    <?php perch_content('Image/Link Blocks'); ?>
  </div>

</div><!-- /.container -->

<?php
perch_layout('global.ford.bottom');
?>
