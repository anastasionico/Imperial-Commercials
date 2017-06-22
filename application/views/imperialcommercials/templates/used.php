
<style type="text/css">
  /* Dropdown Button */
  .dropbtn {
      background-color: #337ab7;
      color: white;
      padding: 16px;
      width: 100%;
      font-size: 16px;
      border: none;
      cursor: pointer;
  }

  /* Dropdown button on hover & focus */
  .dropbtn:hover, .dropbtn:focus {
      background-color: #00ABE6;
  }

  /* The container <div> - needed to position the dropdown content */
  .dropdown {
      position: relative;
      display: inline-block;
      width: 100%;
      margin: 1em 0em 1em 0em;
  }

  /* Dropdown Content (Hidden by Default) */
  .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f9f9f9;
      width: 100%;
      box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      z-index: 99;
      text-align: right;
  }

  /* Links inside the dropdown */
  .dropdown-content a {
      color: #004B80;

      padding: 12px 16px;
      text-decoration: none;
      display: block;
  }

  /* Change color of dropdown links on hover */
  .dropdown-content a:hover {background-color: #f1f1f1}

  /* Show the dropdown menu (use JS to add this class to the .dropdown-content container when the user clicks on the dropdown button) */
  .show {display:block;}
</style>

<div class="container">
  <div class="row hidden-xs hidden-sm">
    <div class="col-md-12">
      <div class="tile tile-grey tile-padded">
        
        <?=$content[$type['url']]?>
      </div>
    </div>
  </div>
  <div class="row gutter-10">
    <div class="col-md-3">
      <div class="used-sidebar">
        Number of Vehicles in current search: <div id="used-sidebar-count"><?=count($stock);?></div>
        <form method="POST" id="used-search" action="/used/<?=$type['url']?>">
          <input type="hidden" name="type_url" value="<?=$type['url']?>">
          <div class="form-group">
            <input id="search-postcode" name="postcode" type="text" class="form-control" placeholder="Type your postcode"<? if($selected['postcode'] != NULL) { ?> value="<?=$selected['postcode']?>"<? } ?>>
          </div>
          <? if($this->uri->segment(2) != 'ford') { ?>
          <div class="form-group">
            <select id="manufacturer" name="manufacturer" class="form-control">
              <option value='' disabled selected>Select Manufacturer</option>
              <? foreach($menu_manufacturers as $manufacturer) { ?>
              <option value="<?=$manufacturer['id']?>"<? if($selected['manufacturer'] == $manufacturer['id']) { ?> selected<? } ?>><?=$manufacturer['name']?></option>
              <? } ?>
            </select>
          </div>
          <? } ?>
          
          <div class="form-group">
            <select id="search-model" name="model" class="form-control">
              <option value='' disabled selected>Select Model</option>
              <? 
                foreach($menu_make_models as $makemodel) {
              ?>
                  <optgroup label="<?=$makemodel['manufacturer']?>">
                  <? 
                    foreach($makemodel['models'] as $model) { 
                  ?>
                      <option value="<?=$model['model']?>"<? if($selected['model'] == $model['model']) { ?> selected<? } ?>>
                        <?=$model['model']?>
                      </option>
                  <? 
                    } 
                  ?>
                  </optgroup>
              <? 
                } 
              ?>
            </select>
          </div>
          <div class="form-group">
            <select id="transmission" name="transmission" class="form-control">
              <option value='' disabled selected>Select Transmission</option>
              <? foreach($menu_transmissions as $transmission) { ?>
              <option value="<?=$transmission['transmission']?>"<? if($selected['transmission'] == $transmission['transmission']) { ?> selected<? } ?>><?=$transmission['transmission']?></option>
              <? } ?>
            </select>
          </div>
          <div class="row gutter-10">
            <div class="col-xs-6">
              <div class="form-group">
                <select id="search-price-from" name="price-from" class="form-control">
                  <option value='' disabled selected>Min Price</option>
                  <? foreach($menu_prices['from'] as $value => $text) { ?>
                  <option value="<?=$value?>"<? if($selected['price-from'] == $value && $selected['price-from'] != NULL) { ?> selected<? } ?>><?=$text?></option>
                  <? } ?>
                </select>
              </div>
            </div>
            <div class="col-xs-6">
              <div class="form-group">
                <select id="search-price-form" name="price-to" class="form-control">
                  <option value='' disabled selected>Max Price</option>
                  <? foreach($menu_prices['to'] as $value => $text) { ?>
                  <option value="<?=$value?>"<? if($selected['price-to'] == $value) { ?> selected<? } ?>><?=$text?></option>
                  <? } ?>
                </select>
              </div>
            </div>
          </div>
          <div class="form-group">
            <select id="search-location" name="location" class="form-control">
              <option value='' disabled selected>Select Location</option>
              <? foreach($menu_locations as $location) { ?>
              <option value="<?=$location['location_id']?>"<? if($selected['location'] == $location['location_id']) { ?> selected<? } ?>><?=$location['name']?> <?=$location['manufacturer']?></option>
              <? } ?>
            </select>
          </div>

          <button type="submit" class="btn btn-primary btn-lg btn-block">Search</button>
          

        </form>

      </div>
    </div>
    <div class="col-md-9">
      <?php
        $sorting = array(
          $this->uri->segment(1)."/".$this->data['type']['url'] .'/created_at/desc',
          $this->uri->segment(1)."/".$this->data['type']['url'] .'/price/asc',
          $this->uri->segment(1)."/".$this->data['type']['url'] .'/price/desc',
          $this->uri->segment(1)."/".$this->data['type']['url'] .'/manufacturer_text/asc',
          $this->uri->segment(1)."/".$this->data['type']['url'] .'/manufacturer_text/desc',
          $this->uri->segment(1)."/".$this->data['type']['url'] .'/model_year/asc',
          $this->uri->segment(1)."/".$this->data['type']['url'] .'/model_year/desc',

        );
        //echo $this->uri->segment(1) . '/' .$this->data['type']['id'] .'/create_at/desc';
        
      ?>
      <div class="dropdown">
        <button onclick="myFunction()" class="dropbtn" >Sort by</button>
        <div id="myDropdown" class="dropdown-content">
          <a href="/<?=$sorting[0];?>">Lastest</a>
          <a href="/<?=$sorting[1];?>">Price (Lowest)</a>
          <a href="/<?=$sorting[2];?>">Price (Highest)</a>
          <a href="/<?=$sorting[3];?>">Manufacturer (A - Z)</a>
          <a href="/<?=$sorting[4];?>">Manufacturer (Z - A)</a>
          <a href="/<?=$sorting[5];?>">Age (Newest)</a>
          <a href="/<?=$sorting[6];?>">Age (Oldest)</a>
        </div>
      </div>
      <? 
      foreach($stock as $vehicle) { 
      ?>
        <div class="used-vehicle">
          <div class="row">
            <div class="col-md-5">
              <a href="<?php echo site_url('/vehicle/' . $vehicle['id'] . '-' . url_title($vehicle['manufacturer_text'] . ' ' . $vehicle['model_text'] . ' ' . $vehicle['derivative_text'], '-', true) ); ?>" class="used-vehicle-image">
                <? if($vehicle['new'] == 1) { ?><div class="new-banner"></div><? } ?>
                <div class="count"  style="margin: 0.5em; background-color: #337ab7; opacity: 1; border-radius: 5px">
                  <?=count($vehicle['additional_images']) + 1 ?> <span class="glyphicon glyphicon-camera"></div>
                <img data-original="<?php echo base_url('assets/img/vehicles/' . $vehicle['image']); ?>" class="lazy img-responsive">
              </a>
              <? if(isset($vehicle['location_distance'])) { echo '<div class="location_distance">' . $vehicle['location_distance'] . '</div>'; } ?>
            </div>
            <div class="col-md-7">
              <h2><a href="<?php echo site_url('/vehicle/' . $vehicle['id'] . '-' . url_title($vehicle['manufacturer_text'] . ' ' . $vehicle['model_text'] . ' ' . $vehicle['derivative_text'], '-', true) ); ?>">
                <?=$vehicle['manufacturer_text']?> <?=$vehicle['model_text']?> <?=$vehicle['derivative_text']?></a>
              </h2>
              <p>
                <?php
                   $sentences = explode(".", $vehicle['description']);
                   echo (! empty($sentences[0]) ) ? $sentences[0] : '';
                   echo (! empty($sentences[1]) ) ? $sentences[1] : '';
                ?>
              </p>
              <div class="row">
                <div class="col-md-5">
                  <span>Reg:</span> <span><?=$vehicle['registration']?></span><br>
                  <span>Year:</span> <span><?=$vehicle['model_year']?></span><br>
                  <span>Mileage:</span> <span><?=number_format( (int) $vehicle['mileage'])?></span>
                </div>
                <div class="col-md-7 border-left">
                  <div class="price">
                    <?php echo ($vehicle['price'] == 0) ? 'POA' : '&#163;' . number_format($vehicle['price']); ?> 
                    <?php if($vehicle['no_vat'] == 0) { echo  ' + VAT'; } ?>
                  </div>
                  <?= 
                    "<span class='glyphicon glyphicon-map-marker'></span> ".
                    $vehicle['address'] 
                    ."<br>".
                    "<span class='glyphicon glyphicon-phone-alt'></span> ".
                    $vehicle['phone'] ?>
                </div>
              </div>
              <a href="<?php echo site_url('/vehicle/' . $vehicle['id'] . '-' . url_title($vehicle['manufacturer_text'] . ' ' . $vehicle['model_text'] . ' ' . $vehicle['derivative_text'], '-', true) ); ?>" class="btn btn-block btn-dark">
                Click here for more information
              </a>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- used-vehicle -->
      <? 
      } 
      ?>
    </div><!-- /.col -->
  </div><!-- /.row -->
</div><!-- /.container -->
<script type="text/javascript">
  /* When the user clicks on the button, 
  toggle between hiding and showing the dropdown content */
  function myFunction() {
      document.getElementById("myDropdown").classList.toggle("show");
  }

  // Close the dropdown menu if the user clicks outside of it
  window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {

      var dropdowns = document.getElementsByClassName("dropdown-content");
      var i;
      for (i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains('show')) {
          openDropdown.classList.remove('show');
        }
      }
    }
  }
</script>
