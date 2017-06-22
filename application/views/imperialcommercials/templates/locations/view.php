<style type="text/css">
  .data-group{
    position: relative;
    padding: 0.3em 3em 0.3em;
    border: 1px solid #004B80;
    font-size: 1.5em;
  }
  .data-group i{
    position: absolute;
    top:0;
    left: 0;
    width: 50px;
    height: 100%;
    padding-top: 0.5em;
    line-height: 1.2em;
    text-align: center;
    color: #fff;
    background-color: #004B80;
  }

    .offer-group{
    border: 1px solid #ccc;
    height: 150px;
    margin-bottom:1em; 
    box-sizing: border-box;

  }
  .offer-image{
    display: inline-block;
    float: left;
    width: 150px;
    height: 100%;
    background-repeat: no-repeat;
    background-size: 120%;
    background-position: center; 
  }
  .offer-description{
    padding: 1em;
    display: inline-block;
    width: 66%; 
  }
  .fa-times{
    color: red;
  }
</style>
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
      center: new google.maps.LatLng(<?=$location['lat']?>, <?=$location['lng']?>),
      zoom: 7,
      mapTypeId: 'roadmap',
      mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU}
    });


    // locations
    var myLatLng<?=$location['id']?> = {lat: <?=$location['lat']?>, lng: <?=$location['lng']?>};
    var marker<?=$location['id']?> = new google.maps.Marker({
      position: myLatLng<?=$location['id']?>,
      map: map,
      title: '<?=$location['name']?>'
    });

    infoWindow = new google.maps.InfoWindow();

 }

 function searchLocations() {
   var address = document.getElementById("addressInput").value;
   var geocoder = new google.maps.Geocoder();
   geocoder.geocode({address: address}, function(results, status) {
     if (status == google.maps.GeocoderStatus.OK) {
      searchLocationsNear(results[0].geometry.location);
     } else {
       alert(address + ' not found');
     }
   });
 }

 function clearLocations() {
   infoWindow.close();
   for (var i = 0; i < markers.length; i++) {
     markers[i].setMap(null);
   }
   markers.length = 0;

   locationSelect.innerHTML = "";
   var option = document.createElement("option");
   option.value = "none";
   option.innerHTML = "See all results:";
   locationSelect.appendChild(option);
 }

 function searchLocationsNear(center) {
   clearLocations();

   var radius = document.getElementById('radiusSelect').value;
   var searchUrl = 'locations/lookup?lat=' + center.lat() + '&lng=' + center.lng() + '&radius=' + radius;
   downloadUrl(searchUrl, function(data) {
     var xml = parseXml(data);
     var markerNodes = xml.documentElement.getElementsByTagName("marker");
     var bounds = new google.maps.LatLngBounds();
     //markerNodes.length == 0 ?
     for (var i = 0; i < markerNodes.length; i++) {
       var name = markerNodes[i].getAttribute("name");
       var address = markerNodes[i].getAttribute("address");
       var distance = parseFloat(markerNodes[i].getAttribute("distance"));
       var latlng = new google.maps.LatLng(
            parseFloat(markerNodes[i].getAttribute("lat")),
            parseFloat(markerNodes[i].getAttribute("lng")));

       createOption(name, distance, i);
       createMarker(latlng, name, address);
       bounds.extend(latlng);
     }
     map.fitBounds(bounds);
     locationSelect.style.visibility = "visible";
     locationSelect.onchange = function() {
       var markerNum = locationSelect.options[locationSelect.selectedIndex].value;
       google.maps.event.trigger(markers[markerNum], 'click');
     };
    });
  }

  function createMarker(latlng, name, address) {
    var html = "<b>" + name + "</b> <br/>" + address;
    var marker = new google.maps.Marker({
      map: map,
      position: latlng
    });
    google.maps.event.addListener(marker, 'click', function() {
      infoWindow.setContent(html);
      infoWindow.open(map, marker);
    });
    markers.push(marker);
  }

  function createOption(name, distance, num) {
    var option = document.createElement("option");
    option.value = num;
    option.innerHTML = name + "(" + distance.toFixed(1) + ")";
    locationSelect.appendChild(option);
  }

  function downloadUrl(url, callback) {
    var request = window.ActiveXObject ?
        new ActiveXObject('Microsoft.XMLHTTP') :
        new XMLHttpRequest;

    request.onreadystatechange = function() {
      if (request.readyState == 4) {
        request.onreadystatechange = doNothing;
        callback(request.responseText, request.status);
      }
    };

    request.open('GET', url, true);
    request.send(null);
  }

  function parseXml(str) {
    if (window.ActiveXObject) {
      var doc = new ActiveXObject('Microsoft.XMLDOM');
      doc.loadXML(str);
      return doc;
    } else if (window.DOMParser) {
      return (new DOMParser).parseFromString(str, 'text/xml');
    }
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

<div class="container">
  <div class="row">
    <div class="col-xs-12 col-md-5 hidden-sm hidden-xs">
      <div id="map" style="width: 100%; height: 80%; min-height: 400px; margin-bottom: 20px"></div>
      <table style="width:100%">
        <tr>
          <?php  
            $i=0;
            foreach($vehicleByLocation as $value){
              if($i && $i%3 == 0){
                echo "</tr>";
              }
          ?>   
              
                <td style='padding: 0.50em;width:30%;'>
                  <a href="<?php echo site_url('/vehicle/' . $value['id'] . '-' . url_title($value['manufacturer_text'] . ' ' . $value['model_text'] . ' ' . $value['derivative_text'], '-', true) ); ?>">
                    <img style="width:100%" src="/assets/img/vehicles/<?=$value["image"]?>">
                    <div style="background-color:#004B80;color:#fff;height:5em; padding: 0.5em">
                      <span class="glyphicon glyphicon-chevron-right"></span>
                      <?=$value['manufacturer_text']?> <?=$value["model_text"]?>
                      <br>
                      <span class="glyphicon glyphicon-gbp"></span>
                      <?=$value["price"]?>
                    </div>
                 </a> 
                </td>  

              
              
          <?php
              $i++;
            } 
          ?>  
        </tr>
      </table>
    </div>
    
    <div class="col-xs-12 col-md-7">

      <h1><?=$location['manufacturer']?> - <?=$location['name']?></h1>
      <p class="data-group">
        <i class="fa fa-phone data-addon" aria-hidden="true"></i>
        <?= substr($location['phone'],0,19);?>
      </p>
      <p class="data-group">
        <i class="fa fa-map-marker" aria-hidden="true"></i>
        <?=$location['address']?>
      </p>
      <?=html_entity_decode($location['content'])?>

      <?php if(!empty($offers)): ?>
        <h3>Offers</h3>
        <?php foreach ($offers as $offer):?>
          <div class="offer-group">
            <a href="<?= $offer['url'] ?>">   
              <div class="offer-image" style="background-image: url(<?= base_url() ?>/perch/resources/<?= $offer['img']?>)">
              </div>
            </a>
            <span class="offer-description">
              <a href="<?= $offer['url'] ?>">      
                <b><?= ucfirst($offer['title']) ?></b>
              </a>
              <br>
              <p><?= $offer['offer_detail']?></p>  
            </span>
          </div>    
        <?php endforeach; ?>
      <?php endif; ?>
        
      <?php if(!empty($location['opening_content'])): ?>
        <h3>Opening Hours</h3>
        <div class="data-group">
          <i class="fa fa-clock-o data-addon" aria-hidden="true"></i>
          <span style="font-size: 0.7em;line-height: 0.7em;">
            <?=html_entity_decode($location['opening_content'])?>
          </span>
        </div>
       <?php endif; ?>    
      














     

    </div><!--/.col-->
  </div>
</div>
