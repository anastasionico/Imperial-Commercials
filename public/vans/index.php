<?php
include('../perch/runtime.php');
perch_layout('global.top');
?>

<div class="container">
  <?php perch_content('Page Breadcrumbs'); ?>
  <div class="row">
    <div class="col-md-12">
      <?php perch_content('Row 1 Tile Text'); ?>
    </div><!-- /.col -->
  </div><!-- /.row -->
  <?php perch_content('Van Manufacturer Logos'); ?>
  <div class="row">
    <div class="col-xs-12">
      <div class="tile tile-bordered">
        <?php 
          perch_content_create('Carousel', array(
              'template' => 'carousel-main.html',
              'multiple' => true,
          )); 
        ?>
        <?php
            perch_content_custom('Carousel', array(
                'template' => 'carousel-indicators.html',
            ));
        ?>
        <?php
            perch_content_custom('Carousel', array(
                'template' => 'carousel-slides.html',
            )); 
        ?> 
      </div>
    </div>
  </div><!-- /.row -->
  <div class="row">
    <div class="col-md-12">
      <?php perch_content('Row 3 Tile Text'); ?>
    </div><!-- /.col -->
  </div><!-- /.row -->
</div><!-- /.container -->

<?php
perch_layout('global.bottom');
?>
