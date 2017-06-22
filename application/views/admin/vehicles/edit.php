<style>
  #sortable { list-style-type: none;  }
  #sortable li {  float: left;  }
  </style>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#sortable" ).sortable({
      update: function( event, ui ) {
        var postData = $(this).sortable('serialize');
        //console.log(postData);
        $.post(
          '<?=base_url()?>admin/orderAdditionalImage', 
          {list:postData}, 
          function(o) {
            console.log(o);
          }, 
          'json');
      }

    //$( "#sortable" ).disableSelection();
    });
  });
  
  </script>
<?php
  
  /*
  echo "<pre>";
  print_r($modelOfVehicle);
  echo "</pre>";
  */
  
    foreach ($modelOfVehicle as $key => $value) {
        $modelOfVehicleArray[$value['id']] = $value['model_text'];
        /*
        echo "<pre>"; 
        print_r($value['manufacturer']); 
        print_r($value['model_text']); 
        echo "</pre>";
        */
    }
    
?>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="/assets/js/fileupload/vendor/jquery.ui.widget.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="/assets/js/fileupload/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="/assets/js/fileupload/jquery.fileupload.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<?/*
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
*/?>
<script>
/*jslint unparam: true */
/*global window, $ */
$(function () {
    'use strict';
    // Change this to the location of your server-side upload handler:
    var url = '/admin/fileupload';
    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        done: function (e, data) {
          location.reload(true);
          /*
            $.each(data.result.files, function (index, file) {
                $('<p/>').text(file.name).appendTo('#files');
            });
            */
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
});
</script>


<div class="container">
  <div class="row">
    <form action="/admin/vehicles/edit/<?=$vehicle['id']?>" enctype="multipart/form-data" method="post" accept-charset="utf-8" id="vehicleForm">
      <div class="col-xs-12">
        <div class="page-header">
          <h1>Edit Vehicle</h1>
          <p>
            <?php
              echo "Vehicle Created: $vehicle[created_at] <br>";
              echo "Vehicle Updated: $vehicle[updated_at] <br>"; 
            ?>
          </p>
        </div>
      </div>
      <div class="col-xs-12">

        <?php echo partial('bscheckbox', array(
            'name' => 'new',
            'label' => 'This is a New Vehicle',
            'checked' => $vehicle['new'],
        )); ?>

        <?php echo partial('bscheckbox', array(
        'label' => 'Active Status',
        'checked' => $vehicle['active_status'],
        
        )); ?>
        
        <?php echo partial('bscheckbox', array(
        'label' => 'List on autotrader',
        'checked' => $vehicle['list_on_autotrader'],
        )); ?>

         <div class="form-group">
            <label for="autotrader_attention_grabbers">Autotrader Attention Grabbers description</label>
            <input type="text" name="autotrader_attention_grabbers" maxlength="30" class="form-control" value="<?=$vehicle['autotrader_attention_grabbers']?>">
        </div>
        <?php echo partial('bscheckbox', array(
        'label' => 'No VAT',
        'checked' => $vehicle['no_vat'],
        )); ?>

        <?php echo partial('bscheckbox', array(
        'label' => 'Sold',
        'checked' => $vehicle['sold'],
        )); ?>

        <div class="row">
          <div class="col-xs-2">
            <?php echo partial('bsinput', array(
            'label' => 'Priority',
            'value' => $vehicle['priority'],
            )); ?>
          </div>
        </div>

        <?php
        echo partial('bsdropdown', array(
            'label' => 'Location *',
            'options' => $locations,
            'value' => $vehicle['location_id'],
        )); ?>

        <?php
        echo partial('bsdropdown', array(
            'label' => 'Type *',
            'options' => $types,
            'value' => $vehicle['type_id'],
        )); ?>

      </div>
      <div class="col-xs-12 col-md-6">

        <?php echo partial('bsinput', array(
        'label' => 'Registration',
        'value' => $vehicle['registration'],
        )); ?>

        <?php
        echo partial('bsdropdown', array(
            'label' => 'Manufacturer *',
            'options' => $manufacturers,
            'class' => 'cap_manufacturer',
            'value' => $vehicle['manufacturer'],
        )); ?>

        <?php
        
        echo "<label>Model *</label>";
        echo form_dropdown('model_uid', $modelOfVehicleArray, $vehicle['model_id'],'class="form-control"' );
        echo "<br>";
        
        ?>
        
        <?php /*
        <?php echo partial('bsinput', array(
        'label' => 'Model',
        'value' => $vehicle['model_text'],
        )); 
        */ ?>
        
        <?php echo partial('bsinput', array(
        'label' => 'Derivative',
        'value' => $vehicle['derivative_text'],
        )); ?>

        <p><small>To change the model or derivative, start by reselecting
        the manufacturer, then model, then derivative. This downloads the latest
        lists from CAPs</small></p>


        <?php echo partial('bsinput', array(
        'label' => 'Model Year',
        'value' => $vehicle['model_year'],
        )); ?>

        <?php echo partial('bsinput', array(
        'label' => 'Engine Size *',
        'value' => $vehicle['engine_size'],
        )); ?>
        <?php echo partial('bsinput', array(
        'label' => 'Load Width',
        'value' => $vehicle['load_width'],
        )); ?>
        <?php echo partial('bsinput', array(
        'label' => 'Load Height',
        'value' => $vehicle['load_height'],
        )); ?>
        <?php echo partial('bsinput', array(
        'label' => 'Load Length',
        'value' => $vehicle['load_length'],
        )); ?>
        <?php echo partial('bsinput', array(
        'label' => 'Load Seats',
        'value' => $vehicle['load_seats'],
        )); ?>
        <?php echo partial('bsinput', array(
        'label' => 'Load Weight',
        'value' => $vehicle['load_weight'],
        )); ?>

        <?php echo partial('bsinput', array(
        'label' => 'Bullet Point 1',
        'value' => $vehicle['bullet_point_1'],
        )); ?>
        <?php echo partial('bsinput', array(
        'label' => 'Bullet Point 2',
        'value' => $vehicle['bullet_point_2'],
        )); ?>
        <?php echo partial('bsinput', array(
        'label' => 'Bullet Point 3',
        'value' => $vehicle['bullet_point_3'],
        )); ?>
        <?php echo partial('bsinput', array(
        'label' => 'Bullet Point 4',
        'value' => $vehicle['bullet_point_4'],
        )); ?>

      </div>
      <div class="col-xs-12 col-md-6">

        <?php echo partial('bsinput', array(
        'label' => 'Fuel Type',
        'value' => $vehicle['fuel_type'],
        )); ?>

        <?php echo partial('bsinput', array(
        'label' => 'Transmission',
        'value' => $vehicle['transmission'],
        )); ?>

        <?php echo partial('bsinput', array(
        'label' => 'Number of Seats',
        'value' => $vehicle['number_of_seats'],
        )); ?>

        <?php
        echo partial('bsdropdown', array(
            'label' => 'Body Type',
            'options' => $body_types,
            'value' => $vehicle['body_type_id'],
        )); ?>

        <?php echo partial('bsinput', array(
        'label' => 'Colour',
        'value' => $vehicle['colour'],
        )); ?>

        <?php echo partial('bsinput', array(
        'label' => 'Registered',
        'value' => $vehicle['registered'],
        )); ?>

        <?php echo partial('bsinput', array(
        'label' => 'Mileage',
        'value' => $vehicle['mileage'],
        )); ?>

        <?php echo partial('bsinput', array(
        'label' => 'Previous Owners',
        'value' => $vehicle['previous_owners'],
        )); ?>

        <h2>Finance</h2>

        <?php echo partial('bsinput', array(
        'label' => 'Price',
        'value' => $vehicle['price'],
        )); ?>
        <p class="help-block">Must be a number. For 'POA', set the price to 0.</p>

        <?php echo partial('bsinput', array(
        'label' => 'Price Month',
        'value' => $vehicle['price_month'],
        )); ?>

        <?php echo partial('bsinput', array(
        'label' => 'Price Month Term',
        'value' => $vehicle['price_month_term'],
        )); ?>

        <?php
        echo partial('bsdropdown', array(
            'label' => 'Finance Type',
            'options' => $finance_types,
            'value' => $vehicle['finance_type_id'],
        )); ?>

        <?php echo partial('bsinput', array(
        'label' => 'Upfront Months',
        'value' => $vehicle['upfront_months'],
        )); ?>

      </div>
     <div class="col-xs-12 col-md-6">
        <?php echo partial('bstextarea', array(
            'label' => 'Description',
            'value' => $vehicle['description'],
        )); ?>
      </div>
      <?php
        if($vehicle['video'] != ''){
      ?>
          <div class="col-xs-12 col-md-6">
            <?php echo partial('bstextarea', array(
                'label' => 'Video',
                'value' => $vehicle['video'],
            )); 
            preg_match('/[\\?\\&]v=([^\\?\\&]+)/',$vehicle['video'],$matches);
            ?>
            <iframe width="560" height="315" src="https://www.youtube.com/embed/<?=$matches[1]?>" frameborder="0" allowfullscreen></iframe>
          </div>  
      <?php
        }
      ?>
      
      <div class="col-xs-12">
        <button type="submit" class="btn btn-primary">Update</button>
        <button type="button" id="duplicateButton" class="btn btn-info">Duplicate</button>
        <a id="seeNewVehicle" class="hide btn btn-info">See New Vehicle</a>
        

      </div><!-- /.col -->
    </form>
  </div><!-- /.row -->

  <div class="page-header">
    <h1>Vehicle Pictures</h1>
  </div>

  <div id="images" class="row">
    <div class="col-xs-12 col-md-3">
      <h5>Main Lead Image</h5>
      <form enctype="multipart/form-data" method="post" accept-charset="utf-8">
        <input type="hidden" name="imageupload" value="1">
        <? if(!empty($vehicle['image'])) { ?>
        <img src="/assets/img/vehicles/<?php echo $vehicle['image']; ?>" class="img-responsive">
        <? } ?>
        <div class="form-group">
          <label for="userfile">Image</label>
          <input type="file" id="userfile" name="userfile" multiple>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <br><br><br>
      </form>
    </div><!--/.col-->
    <div class="col-xs-12 col-md-9">
      <h5>Additional Images</h5>
      <div class="clearfix"></div>
      <div class="row">
        <? 
          if(! empty($vehicle['additional_images']) ) { 
            echo "<ul id='sortable'>";
            $i=0;
            //echo "<pre>"; print_r($vehicle['additional_images']);
            foreach($vehicle['additional_images'] as $image) { 
        ?>
              
              <li class="ui-state-default" id="item-<?=$image['id']?>">
                <div class="" style="width:160px;height:160px;margin: 2em;text-align: center">
                  <span style="display:inline-block;width:31%;">
                    <a href="/admin/resizeImage/<?=$image['id']?>/320/" class="btn btn-xs btn-info" style='width: 100%;'>
                      320px
                    </a>
                  </span>
                  <span style="display:inline-block;width:31%;">
                    <a href="/admin/resizeImage/<?=$image['id']?>/480" class="btn btn-xs btn-info" style='width: 100%;'>
                      480px
                    </a>
                  </span>
                  <span style="display:inline-block;width:31%;">
                    <a href="/admin/resizeImage/<?=$image['id']?>/768" class="btn btn-xs btn-info" style='width: 100%;'>
                      768px
                    </a>
                  </span>
                  <img src="/assets/img/vehicles/<?php echo $image['image']; ?>" style="width:100%;height:100%;">
                  <a href="/admin/vehicles/delete_picture/<?=$vehicle['id']?>/<?=$image['id']?>" class="btn btn-xs btn-danger" style='width: 100%;'>Delete</a>
                </div>
              </li>
              
        <?
            $i++;
            }
            echo "</ul>";
          } 
        ?>
      </div>
      <br>
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-xs-12 col-md-8">
          <div class="well">
            <h4>Add New Picture</h4>
            <?php echo form_open_multipart("admin/AddAdditionaImage/$vehicle[id]");?>
              <input type="file" name="additionalImage[]" multiple />
              <br /><br />
              <input type="submit" value="upload" />
            </form>
  

            <!--
            <form>
              <input type="hidden" name="vehicle_id" value="<?=$vehicle['id']?>">
              <!-- The global progress bar - ->
              <div id="progress" class="progress">
                  <div class="progress-bar progress-bar-success"></div>
              </div>
            
              <!-- The fileinput-button span is used to style the file input field as button - ->
              <span class="btn btn-success fileinput-button">
                  <i class="glyphicon glyphicon-plus"></i>
                  <span>Select files...</span>
                  <!-- The file input field used as target for the file upload widget - ->
                  <input id="fileupload" type="file" name="files[]" multiple>
              </span>
              <!-- The container for the uploaded files - ->
              <div id="files" class="files"></div>
            </form>       
            -->
          </div><!--/.well -->
        </div><!--/.col-->
      </div>
    </div>


  </div><!--/.row -->

</div>
<script>
  /*
  function myDuplicateVehicle() {
    xhttp = new XMLHttpRequest(); 
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        console.log(this.responseText);
      }
    };
    xhttp.open("GET", "<?=base_url()?>admin/duplicateVehicle/<?=$vehicle['id'] ?>", true);
    xhttp.send();
  }
  */
</script>
<script>
  $("#duplicateButton").click(function(){
    var id = "<?=$vehicle['id'] ?>";
    //console.log(id);
    $.post(
      "<?=base_url()?>admin/duplicateVehicle", 
      {vehicle:id}, 
      function(data,status) {
        document.getElementById("seeNewVehicle").classList.remove("hide");
        document.getElementById("seeNewVehicle").className += " btn btn-info";
        
        document.getElementById("seeNewVehicle").href = data;
       
        

      });
  });
</script>
