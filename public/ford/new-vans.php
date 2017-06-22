<?php
include('../perch/runtime.php');
perch_layout('global.ford');
?>

<div class="container">
  <div class="row gutter-10">
    <div class="col-md-12">
      <?php perch_content('Top Image'); ?>
    </div>
  </div>
  <div class="row gutter-10">
    <div class="col-md-12">
      <div class="tile tile-ford-vans">
        <h1>Ford Vans</h1>
        <div class="subheading">
          <span>Ford Vans For Sale</span>
        </div>
        <div class="row gutter-10">

          <?php perch_content('Van Model Blocks'); ?>

        </div><!--/.row-->

      </div><!--/.tile-->

    </div><!--/.col -->
  </div><!--/.row-->
  <div class="row gutter-10">
    <div class="col-md-12">
      <?php perch_content('Content'); ?>
    </div>
  </div>

</div><!-- /.container -->

<?php
perch_layout('global.ford.bottom');
?>
