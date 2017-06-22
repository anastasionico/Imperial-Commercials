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
      center: new google.maps.LatLng(52.633365, -1.138705),
      zoom: 7,
      mapTypeId: 'roadmap',
      mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU}
    });


    // locations
    <? foreach($locations as $location) { ?>
    var myLatLng<?=$location['id']?> = {lat: <?=$location['lat']?>, lng: <?=$location['lng']?>};
    var marker<?=$location['id']?> = new google.maps.Marker({
      position: myLatLng<?=$location['id']?>,
      map: map,
      title: '<?=$location['name']?>'
    });
    <? } ?>


    infoWindow = new google.maps.InfoWindow();

    locationSelect = document.getElementById("locationSelect");
    locationSelect.onchange = function() {
      var markerNum = locationSelect.options[locationSelect.selectedIndex].value;
      if (markerNum != "none"){
        google.maps.event.trigger(markers[markerNum], 'click');
      }
    };
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
      <div id="map" style="width: 100%; height: 80%; min-height: 650px; margin-bottom: 20px"></div>
    </div>
    <div class="col-xs-12 col-md-7">

      <? /*
      <div>
        <div>
          <select id="locationSelect" style="width:100%;visibility:hidden"></select>
        </div>
        <input type="text" id="addressInput" size="10"/>
        <select id="radiusSelect">
          <option value="25" selected>25mi</option>
          <option value="100">100mi</option>
          <option value="200">200mi</option>
        </select>
        <input type="button" onclick="searchLocations()" value="Search"/>
      </div>
      */ ?>

      <form class="form-inline dealer-finder" method="post" action="/locations/nearest">
        <label for="search">Find your nearest dealership: </label>
        <div class="input-group searchbar">
          <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
          <input id="search" name="search" type="text" class="form-control" placeholder="Type your postcode">
          <span class="input-group-btn">
            <button type="submit" class="btn btn-default" type="button">Go!</button>
          </span>
        </div><!-- /input-group -->
      </form>

      <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <tr>
            <th>Dealer</th>
            <th>Address</th>
            <th>Phone</th>
            <th>Distance</th>
          </tr>
          <? foreach($locations as $location) { ?>
          <tr>
            <td style="width: 30%; word-wrap:break-word">
              <a href="/locations/<?=$location['id']?>-<?=url_title($location['manufacturer'])?>-<?=url_title($location['name'])?>"><?=$location['manufacturer']?> - <?=$location['name']?></a>
            </td>
            <td><?=$location['address']?></td>
            <td><?=$location['phone']?></td> 
            <td><?=number_format($location['distance'],1); ?> Miles</td> 
          </tr>
          <? } ?>
        </table>
      </div>

    </div><!--/.col-->
  </div>
</div>
