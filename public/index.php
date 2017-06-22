<?php
include('perch/runtime.php');
perch_layout('global.top');
?>

<div class="container">

  <div class="tile tile-bordered hidden-xs">
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

  <nav class="hidden-xs margin-bottom">
    <?php perch_content('Nav Manufacturer'); ?>
  </nav>

  <div class="row gutter-10">
    <div class="col-md-8">
      <?php perch_content('Row 1 Tile Image'); ?>
    </div>
    <div class="col-md-4 hidden-xs">
      <?php perch_content('Row 1 Tile Text'); ?>
    </div>
  </div>
  <div class="row gutter-10">
    <div class="col-md-4">
      <?php perch_content('Row 2 Tile Icon 1'); ?>
      <?php perch_content('Row 2 Tile Icon 2'); ?>
    </div>
    <div class="col-md-8">
      <?php perch_content('Row 2 Tile Image'); ?>
    </div>
  </div>
  <div class="row gutter-10">
    <div class="col-md-8">
      <?php perch_content('Row 3 Tile Image'); ?>
    </div>
    <div class="col-md-4">
      <?php perch_content('Row 3 Tile Icon 1'); ?>
      <?php perch_content('Row 3 Tile Icon 2'); ?>
    </div>
  </div>
  <div class="row gutter-10">
    <div class="col-md-7 hidden-xs">
      <?php perch_content('Row 4 Tile Manufacturer'); ?>
    </div>
    <div class="col-md-5 hidden-xs">
      <?php perch_content('Row 4 Tile Text'); ?>
    </div>
    <div class="col-md-7 hidden-xs">
      <?php perch_content('Row 5 Tile Businesses'); ?>
    </div>
    <div class="col-md-5 hidden-xs">
      <div class="video-black-wrapper">
        <div style="position:relative;height:0;padding-bottom:56.25%"><iframe src="https://www.youtube.com/embed/Jm64yhc3HLw?ecver=2" width="640" height="360" frameborder="0" style="position:absolute;width:100%;height:100%;left:0" allowfullscreen></iframe></div>
      </div>
    </div>
  </div>

</div>

<?php
perch_layout('global.bottom');
?>
