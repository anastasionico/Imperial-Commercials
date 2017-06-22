<!-- AddToAny BEGIN -->
<?php $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
<div style="height:10%;position:fixed;top:40%;left:15%;">
  <a style="display: block;margin: 0.5em;" href="https://www.addtoany.com/add_to/facebook?linkurl=<?=$actual_link?>&amp;linkname=" target="_blank">
    <img src="https://static.addtoany.com/buttons/facebook.svg" width="32" height="32">
  </a>
  <a style="display: block;margin: 0.5em;" href="https://www.addtoany.com/add_to/twitter?linkurl=<?=$actual_link?>&amp;linkname=" target="_blank">
    <img src="https://static.addtoany.com/buttons/twitter.svg" width="32" height="32">
  </a>
  <a style="display: block;margin: 0.5em;" href="https://www.addtoany.com/add_to/linkedin?linkurl=<?=$actual_link?>&amp;linkname=" target="_blank">
    <img src="https://static.addtoany.com/buttons/linkedin.svg" width="32" height="32">
  </a>
  <a style="display: block;margin: 0.5em;" href="https://www.addtoany.com/add_to/google_gmail?linkurl=<?=$actual_link?>&amp;linkname=" target="_blank">
    <img src="https://static.addtoany.com/buttons/gmail.svg" width="32" height="32">
  </a>
</div>
<!-- AddToAny END -->



<div class="container">
  <div class="used-vehicle tile tile-grey">
    <div class="row">
      <div class="col-xs-12 col-md-6">
        <div>
          <a href="/assets/img/vehicles/<?php echo $vehicle['image']; ?>" class="thumbnail" title="Gallery" data-gallery>
            <? if($vehicle['new'] == 1) { ?><div class="new-banner"></div><? } ?>
            <img src="/assets/img/vehicles/<?php echo $vehicle['image']; ?>" class="img-responsive">
          </a>
        </div>
        <div class="row gutter-10">
          <? foreach($vehicle['additional_images'] as $image) { ?>
          <div class="col-xs-4 col-md-2">
            <a href="/assets/img/vehicles/<?php echo $image['image']; ?>" class="thumbnail" title="Gallery" data-gallery>
              <img src="/assets/img/vehicles/<?php echo $image['image']; ?>" alt="Gallery">
            </a>
          </div>
          <? } ?>
        </div>
      </div>
      <div class="col-xs-12 col-md-6">

        <h1><?=$vehicle['manufacturer_text']?> <?=$vehicle['model_text']?> <?=$vehicle['derivative_text']?></h1>

        <div class="row">
          <div class="col-md-5">
            <span>Reg:</span> <span><?=$vehicle['registration']?></span><br>
            <span>Year:</span> <span><?=$vehicle['model_year']?></span><br>
            <span>Mileage:</span> <span><?=number_format($vehicle['mileage'])?></span><br>

<? if(! empty($vehicle['engine_size']) ) { echo '<span>Engine Size: ' . $vehicle['engine_size'] . '</span><br>'; } ?>

<? if(! empty($vehicle['load_width']) ) { echo '<span>Load Width: ' . $vehicle['load_width'] . '</span><br>'; } ?>
<? if(! empty($vehicle['load_height']) ) { echo '<span>Load Height: ' .$vehicle['load_height'] . '</span><br>'; } ?>
<? if(! empty($vehicle['load_length']) ) { echo '<span>Load Length: ' .$vehicle['load_length'] . '</span><br>'; } ?>
<? if(! empty($vehicle['load_seats']) ) { echo '<span>Load Seats: ' . $vehicle['load_seats'] . '</span><br>'; } ?>
<? if(! empty($vehicle['load_weight']) ) { echo '<span>Load Width: ' . $vehicle['load_weight'] . '</span><br>'; } ?>

<? if(! empty($vehicle['fuel_type']) ) { echo '<span>Fuel Type: ' . $vehicle['fuel_type'] . '</span><br>'; } ?>
<? if(! empty($vehicle['transmission']) ) { echo '<span>Transmission: ' . $vehicle['transmission'] . '</span><br>'; } ?>
<? if(! empty($vehicle['number_of_seats']) ) { echo '<span>Number of seats: ' . $vehicle['number_of_seats'] . '</span><br>'; } ?>
<?/*<span><? if(! empty($vehicle['body_type_id']) ) { echo $vehicle['body_type_id']; } ?></span>*/?>
<? if(! empty($vehicle['colour']) ) { echo '<span>Colour: ' . $vehicle['colour'] . '</span><br>'; } ?>
<? if(! empty($vehicle['registered']) ) { echo '<span>Registered: ' . $vehicle['registered'] . '</span><br>'; } ?>
<? if(! empty($vehicle['previous_owners']) ) { echo '<span>Previous Owners: ' . $vehicle['previous_owners'] . '</span><br>'; } ?>

<? if(! empty($vehicle['bullet_point_1']) ) { echo '<span>' . $vehicle['bullet_point_1'] . '</span><br>'; } ?>
<? if(! empty($vehicle['bullet_point_2']) ) { echo '<span>' . $vehicle['bullet_point_2'] . '</span><br>'; } ?>
<? if(! empty($vehicle['bullet_point_3']) ) { echo '<span>' . $vehicle['bullet_point_3'] . '</span><br>'; } ?>
<? if(! empty($vehicle['bullet_point_4']) ) { echo '<span>' . $vehicle['bullet_point_4'] . '</span><br>'; } ?>


          </div>
          <div class="col-md-7">
            <div class="price">
              <p><?php echo ($vehicle['price'] == 0) ? 'POA' : '&#163;' . number_format($vehicle['price']); ?> <?php if($vehicle['no_vat'] == 0) { echo  ' + VAT'; } ?></p>
            </div>
            <div class="contact_prominent">
              <p><a href="/locations/<?=$vehicle_location['id']?>-<?=url_title($vehicle_location['manufacturer'])?>-<?=url_title($vehicle_location['name'])?>"><?=$vehicle_location['manufacturer']?>
                <?=$vehicle_location['name']?>
              </a></p>
              <p><?=$vehicle_location['phone']?></p>
              <p><?=$vehicle_location['address']?></p>

              <a href="#" data-toggle="modal" data-target="#modal-enquiry" class="btn btn-block btn-dark">
                <span class="icon icon-email-light" aria-hidden="true"></span> Email
              </a>
              <a href="#" data-toggle="modal" data-target="#modal-callme" class="btn btn-block btn-dark">
                <span class="icon icon-phone-light" aria-hidden="true"></span> Call Back
              </a>
              <a href="#" data-toggle="modal" data-target="#modal-enquiry" class="btn btn-block btn-dark">
                <span class="icon icon-drive-light" aria-hidden="true"></span> Test Drive 
              </a>

            </div>
          </div>
        </div>

        <?/*
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-red btn-lg" data-toggle="modal" data-target="#modal-enquiry">
          Send an Enquiry
        </button>
        <button type="button" class="btn btn-red btn-lg" data-toggle="modal" data-target="#modal-callme">
          Call Me Request
        </button>
        */?>

      </div>
    </div><!-- /.row -->
    <div class="row">
      <div class="col-xs-12">
        <p><span class="icon icon-location-dark" aria-hidden="true"></span> <?=$vehicle_location['name']?></p>
        <p><?=$vehicle['description']?></p>
        <div class="nav-coa nav-coa-blue">
          <div class="col col3">
            <a href="#" data-toggle="modal" data-target="#modal-enquiry">
              <span class="icon icon-email-light" aria-hidden="true"></span> Email
            </a>
          </div>
          <div class="col col3">
            <a href="#" data-toggle="modal" data-target="#modal-callme">
              <span class="icon icon-phone-light" aria-hidden="true"></span> Call Back
            </a>
          </div>
          <div class="col col3">
            <a href="#" data-toggle="modal" data-target="#modal-enquiry">
              <span class="icon icon-drive-light" aria-hidden="true"></span> Test Drive
            </a>
          </div>
        </div>
      </div>

    </div><!-- /.row -->
    <div class="row">
      <div class="col-xs-12 col-md-6">
        <h4>
          <a href="/locations/<?=$vehicle_location['id']?>-<?=url_title($vehicle_location['manufacturer'])?>-<?=url_title($vehicle_location['name'])?>"><?=$vehicle_location['manufacturer']?>
            <?=$vehicle_location['name']?>
          </a>
        </h4>

        <p><?=$vehicle_location['phone']?></p>
        <p><?=$vehicle_location['address']?></p>

      </div>
      <div class="col-xs-12 hidden-xs hidden-sm col-md-6">
        <div id="map" style="width: 100%; height: 80%; min-height: 400px; margin-bottom: 20px;"></div>
      </div>
    </div>

  </div><!-- /.vehicle-listing-spotlight -->
</div><!-- /.container -->
<? if(!empty($stocks)) { ?>
<div class="container pad-bottom">
  <div class="tile tile-grey">
    <div class="row">
      <div class="col-xs-12">
        <h2>People who viewed this also viewed</h2>

        <div class="row">
          <? 
            foreach($stocks as $stock) { ?>
              <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="used-vehicle used-vehicle-small">
                  <?php 
                    $relatedImageUrl =  base_url()."assets/img/vehicles/".$stock['image'];
                    //echo $relatedImageUrl;
                  ?>
                    <div class="picture" style="background-image: url('<?=$relatedImageUrl?>'); background-size: cover;background-position: center; height: 200px">
                      <a href="/vehicle/<?=$stock['url']?>" class="used-vehicle-image">
                        <? if($stock['new'] == 1) { ?><div class="new-banner"></div><? } ?>
                        <div class="count"  style="margin: 0.5em; background-color: #337ab7; opacity: 1; border-radius: 5px">
                          <?=count($stock['additional_images']) + 1 ?>
                          <span class="glyphicon glyphicon-camera"></span></div>
                        <!--<img src="/assets/img/vehicles/<?php echo $stock['image']; ?>" class="img-responsive">-->
                      </a>
                    </div>
                    <h4  style="padding:0 1em">
                      <a href="/vehicle/<?=$stock['url']?>">
                      <?=$stock['manufacturer_text']?> <?=$stock['model_text']?> <?=$stock['derivative_text']?>
                        
                      </a>
                    </h4>
                    <table class="newTableDesign">
                      <tbody>
                        <tr>
                          <td colspan="2">
                            <?php echo ($stock['price'] == 0) ? 'POA' : '&#163;' . number_format($stock['price']) . ' + VAT'; ?>
                          </td>
                        </tr>
                        <tr>
                          <td>Registration</td>
                          <td><?=$stock['registration']?></td>
                        </tr>
                        <tr>
                          <td>Year</td>
                          <td><?=$stock['model_year']?></td>
                        </tr>
                        <tr>
                          <td>Mileage</td>
                          <td><?=number_format($stock['mileage'])?>
                        </tr>
                      </tbody>
                    </table>
                    <div class="buttons">
                      <div class="btn-group btn-group-justified" role="group" aria-label="More Details">
                        <a href="/vehicle/<?=$stock['url']?>" class="btn btn-dark">Click here for more information</a>
                      </div>
                    </div>
                  </div>
                </div><!-- /.col -->
          <? } ?>
        </div><!-- /.row -->

      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.tile -->
</div><!-- /.container -->
<? } ?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDj8w13rbTUCPIGgdHBgXaiF5FZKqQ32Fo"
        type="text/javascript"></script>
<script type="text/javascript">
  //<![CDATA[
  var map;
  var markers = [];
  var infoWindow;
  var locationSelect;

  function load() {
    map = new google.maps.Map(document.getElementById("map"), {
      center: new google.maps.LatLng(<?=$vehicle_location['lat']?>, <?=$vehicle_location['lng']?>),
      zoom: 10,
      mapTypeId: 'roadmap',
      mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU}
    });


    // locations
    var myLatLng<?=$vehicle_location['id']?> = {lat: <?=$vehicle_location['lat']?>, lng: <?=$vehicle_location['lng']?>};
    var marker<?=$vehicle_location['id']?> = new google.maps.Marker({
      position: myLatLng<?=$vehicle_location['id']?>,
      map: map,
      title: '<?=$vehicle_location['name']?>'
    });


    infoWindow = new google.maps.InfoWindow();

 }

  function doNothing() {}

  // onload
  // Dean Edwards/Matthias Miller/John Resig

  function init() {
    // quit if this function has already been called
    if (arguments.callee.done) return;

    // flag this function so we don't do the same thing twice
    arguments.callee.done = true;

    // kill the timer
    if (_timer) clearInterval(_timer);

    // do stuff
    load();
  };

  /* for Mozilla/Opera9 */
  if (document.addEventListener) {
    document.addEventListener("DOMContentLoaded", init, false);
  }

  /* for Internet Explorer */
  /*@cc_on @*/
  /*@if (@_win32)
    document.write("<script id=__ie_onload defer src=javascript:void(0)><\/script>");
    var script = document.getElementById("__ie_onload");
    script.onreadystatechange = function() {
      if (this.readyState == "complete") {
        init(); // call the onload handler
      }
    };
  /*@end @*/

  /* for Safari */
  if (/WebKit/i.test(navigator.userAgent)) { // sniff
    var _timer = setInterval(function() {
      if (/loaded|complete/.test(document.readyState)) {
        init(); // call the onload handler
      }
    }, 10);
  }

  /* for other browsers */
  window.onload = init;

  //]]>
</script>
<script type="application/ld+json">
{
  "@context": "http://schema.org/",
  "@type": "Product",
  "name": "<?=$vehicle['manufacturer_text']?> <?=$vehicle['model_text']?> <?=$vehicle['derivative_text']?>",
  "image": "<?=site_url('/assets/img/vehicles/' . $vehicle['image'])?>",
  "description": <?php json_encode($vehicle['description']); ?>,
  "brand": {
    "@type": "Thing",
    "name": "Imperial Commercials"
    },
    "offers": {
    "@type": "Offer",
    "priceCurrency": "GBP",
    "price": "<?php echo $vehicle['price']; ?>",
    "availability": "http://schema.org/InStock"
    }
  }
}
 </script>
