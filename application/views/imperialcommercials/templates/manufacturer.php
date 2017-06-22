<div class="container pad-bottom">
  <div class="row">
    <div class="col-xs-12">
      <?=$content['main']?>

      <div class="row">
        <? for ($x = 0; $x < 4; $x++) { ?>
        <div class="col-xs-12 col-sm-6 col-md-6">
          <div class="vehicle-listing">
            <h4><a href="/vehicle/<?=$stock[$x]['url']?>"><?=$stock[$x]['manufacturer_text']?> <?=$stock[$x]['model_text']?> <?=$stock[$x]['derivative_text']?></a></h4>
            <div class="picture">
              <a href="/vehicle/<?=$stock[$x]['url']?>">
                <img src="/assets/img/vehicles/<?php echo $stock[$x]['image']; ?>" class="img-responsive">
              </a>
            </div>
            <div class="buttons">
              <div class="btn-group btn-group-justified" role="group" aria-label="...">
                <a href="/vehicle/<?=$stock[$x]['url']?>" class="btn btn-red">£<?=ceil($stock[$x]['price_month'])?></a>
                <a href="/vehicle/<?=$stock[$x]['url']?>" class="btn btn-red">See Deal</a>
              </div>
            </div>
          </div>
        </div><!-- /.col -->
        <? } ?>
      </div><!-- /.row -->

      <h2>Current Stock</h2>

      <div class="row">
        <? for ($x = 4; $x < count($stock); $x++) { ?>
        <div class="col-xs-12 col-sm-6 col-md-3">
          <div class="vehicle-listing">
            <h4><a href="/vehicle/<?=$stock[$x]['url']?>"><?=$stock[$x]['manufacturer_text']?> <?=$stock[$x]['model_text']?> <?=$stock[$x]['derivative_text']?></a></h4>
            <div class="picture">
              <a href="/vehicle/<?=$stock[$x]['url']?>">
                <img src="/assets/img/vehicles/<?php echo $stock[$x]['image']; ?>" class="img-responsive">
              </a>
            </div>
            <div class="buttons">
              <div class="btn-group btn-group-justified" role="group" aria-label="...">
                <a href="/vehicle/<?=$stock[$x]['url']?>" class="btn btn-red">£<?=ceil($stock[$x]['price_month'])?></a>
                <a href="/vehicle/<?=$stock[$x]['url']?>" class="btn btn-red">See Deal</a>
              </div>
            </div>
          </div>
        </div><!-- /.col -->
        <? } ?>

      </div><!-- /.row -->

    </div><!-- /.col -->
  </div><!-- /.row -->

</div><!-- /.container -->
