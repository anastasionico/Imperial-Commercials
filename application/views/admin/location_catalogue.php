<style type="text/css">
  @media print and (color) {
    *{
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }
    header nav, footer, #location_selection {
    display: none;
    }
    img {
      max-width: 500px;
    }
    body {
      font: 12pt Georgia, "Times New Roman", Times, serif;
      line-height: 1;
       -webkit-print-color-adjust: exact;
    }
    a {
      word-wrap: break-word;
    }
    a:after {
      content: " (" attr(href) ")";
      font-size: 80%;
    }
    
    table th{
      border: 1px solid #999;
    }
    table tr{
      border: 1px solid #bbb;
    }
    table tr:nth-child(2n+1) {
      border: 1px solid #ddd;
    }  
    
    ul, img {
      page-break-inside: avoid;
    }

    .item_vehicle{
      margin-bottom: 5em;
      page-break-before: avoid;
    }


  }
  @page {
    margin: 0.2cm;
  }
  @page:left, @page:right {
    margin: 1cm;
  }
  


  .name_model{
    margin:1.5em 2% 0.5em 2%;
  }
  table{
    width: 100%;
  }
  tr > *{
    padding: 0.25em 0.5em;
  }
  table th{
    background: #ccc;
  }
  table tr{
    background: #f0f0f0;
  }
  table tr:nth-child(2n+1) {
    background: #fafafa;
  }  
</style>
<div class="container">
  <form class="form-inline" id="location_selection">
    <div class="form-group">
      <label for="location" class="control-label">Filter by Location</label>
      <select name="mydropdown" class="styled" onChange="document.location = this.value" value="GO">
        <?foreach($locations as $llocation) { ?>
        <option value="/admin/location_catalogue/<?=$llocation['id']?>"<? if($llocation['id'] == $location['id']) { ?> selected<? } ?>><?=$llocation['name']?> <?=$llocation['manufacturer']?></option>
        <? } ?>
      </select>
    </div>
  </form>
  <div class="row">
    <!--<a href="/admin/vehicles/add" class="btn btn-primary btn-md">Add Vehicle</a>-->
    <div class="page-header">
      <h1>Catalogue</h1>
      <h3><?=$location['name']?></h3>
      <h4><?=$location['manufacturer']?></h4>
      <a href="<?=base_url()?>admin/index_location/<?=$location['id']?>" class="btn btn-primary" style="margin-bottom: 2em">Vehicle list</a>
    </div>
  </div>  
  <?php foreach($vehicles as $vehicle) { ?>
    <div class="row" class="item_vehicle" >
      <!--
      <div class="col-md-12" style="background-color: #fff;">
          <h4>Name Model</h4>
          <div>
            <div class="col-md-7" style="border: 2px solid #faa; ">
            lead image
            </div>
            <div class="col-md-4 col-md-offset-1" >
              <div class="" style="border: 2px solid #faa;">image 1</div>
              <br>
              <div class=""  style="border: 1px solid #800;">image 2</div>
            </div>
            &nbsp;
          </div>
      </div>
      &nbsp;
      -->
      <h3 class="name_model" style=""><?=$vehicle['model_text'];?></h3>
      <div style="margin:0 2.5%;width:47%;display:inline-block;vertical-align: top;">
        <table>
          <thead>
            <tr>
              <th colspan="2">Technical Information</th>
            </tr>
          </thead>
          <?php if(! empty($vehicle['registration']) ) { ?>
            <tr>
              <td><?=ucfirst("registration")?></td>
              <td><?=$vehicle['registration'];?></td>
            </tr>
          <?php } ?>
          <?php if(! empty($vehicle['model_year']) ) { ?>
            <tr>
              <td><?=ucfirst("model year")?></td>
              <td><?=$vehicle['model_year'];?></td>
            </tr>
          <?php } ?>
          <?php if(! empty($vehicle['mileage']) ) { ?>
            <tr>
              <td><?=ucfirst("mileage")?></td>
              <td><?=$vehicle['mileage'];?></td>
            </tr>
          <?php } ?>
          <?php if(! empty($vehicle['load_width']) ) { ?>
            <tr>
              <td><?=ucfirst("load width")?></td>
              <td><?=$vehicle['load_width'];?></td>
            </tr>
          <?php } ?>
          <?php if(! empty($vehicle['load_height']) ) { ?>
            <tr>
              <td><?=ucfirst("load height")?></td>
              <td><?=$vehicle['load_height'];?></td>
            </tr>
          <?php } ?>
          <?php if(! empty($vehicle['engine_size']) ) { ?>
            <tr>
              <td><?=ucfirst("engine size")?></td>
              <td><?=$vehicle['engine_size'];?></td>
            </tr>
          <?php } ?>
          <?php if(! empty($vehicle['load_length']) ) { ?>
            <tr>
              <td><?=ucfirst("load length")?></td>
              <td><?=$vehicle['load_length'];?></td>
            </tr>
          <?php } ?>
          <?php if(! empty($vehicle['load_seats']) ) { ?>
            <tr>
              <td><?=ucfirst("load seats")?></td>
              <td><?=$vehicle['load_seats'];?></td>
            </tr>
          <?php } ?>
          <?php if(! empty($vehicle['load_weight']) ) { ?>
            <tr>
              <td><?=ucfirst("load weight")?></td>
              <td><?=$vehicle['load_weight'];?></td>
            </tr>
          <?php } ?>
          <?php if(! empty($vehicle['fuel_type']) ) { ?>
            <tr>
              <td><?=ucfirst("fuel type")?></td>
              <td><?=$vehicle['fuel_type'];?></td>
            </tr>
          <?php } ?>
          <?php if(! empty($vehicle['transmission']) ) { ?>
            <tr>
              <td><?=ucfirst("transmission")?></td>
              <td><?=$vehicle['transmission'];?></td>
            </tr>
          <?php } ?>
          <?php if(! empty($vehicle['number_of_seats']) ) { ?>
            <tr>
              <td><?=ucfirst("number of seats")?></td>
              <td><?=$vehicle['number_of_seats'];?></td>
            </tr>
          <?php } ?>
          <?php if(! empty($vehicle['colour']) ) { ?>
            <tr>
              <td><?=ucfirst("colour")?></td>
              <td><?=$vehicle['colour'];?></td>
            </tr>
          <?php } ?>
          <?php if(! empty($vehicle['registeredprevious_owners']) ) { ?>
            <tr>
              <td><?=ucfirst("registeredprevious_owners")?></td>
              <td><?=$vehicle['registeredprevious_owners'];?></td>
            </tr>
          <?php } ?>
          <?php if(! empty($vehicle['previous_owners']) ) { ?>
            <tr>
              <td><?=ucfirst("previous owners")?></td>
              <td><?=$vehicle['previous_owners'];?></td>
            </tr>
          <?php } ?>
          <?php if(! empty($vehicle['bullet_point_1']) ) { ?>
            <tr>
              <td><?=ucfirst("Feature")?></td>
              <td><?=$vehicle['bullet_point_1'];?></td>
            </tr>
          <?php } ?>
          <?php if(! empty($vehicle['bullet_point_2']) ) { ?>
            <tr>
              <td><?=ucfirst("Feature")?></td>
              <td><?=$vehicle['bullet_point_2'];?></td>
            </tr>
          <?php } ?>
          <?php if(! empty($vehicle['bullet_point_3']) ) { ?>
            <tr>
              <td><?=ucfirst("Feature")?></td>
              <td><?=$vehicle['bullet_point_3'];?></td>
            </tr>
          <?php } ?>
          <?php if(! empty($vehicle['bullet_point_4']) ) { ?>
            <tr>
              <td><?=ucfirst("Feature")?></td>
              <td><?=$vehicle['bullet_point_4'];?></td>
            </tr>
          <?php } ?>
        
        </table>
      </div>
      <div style="display:inline-block;width:47%;">
        <table style="margin-top:0px;">
          <thead>
            <tr>
              <th colspan="2">General Information</th>
            </tr>
          </thead>
          <tr>
            <td>Price</td>
            <td>
              <?php echo ($vehicle['price'] == 0) ? 'POA' : '&#163;' . number_format($vehicle['price']); ?> <?php if($vehicle['no_vat'] == 0) { echo  ' + VAT'; } ?>
            </td>
          </tr>
          <tr>
            <td><?=ucfirst("manufacturer")?></td>
            <td><?=$location['manufacturer']?></td>
          </tr>
          <tr>
            <td><?=ucfirst("name")?></td>
            <td><?=$location['name']?></td>
          </tr>
          <tr>
            <td><?=ucfirst("address")?></td>
            <td><?=$location['address'];?></td>
          </tr>
          <tr>
            <td><?=ucfirst("phone")?></td>
            <td><?=$location['phone'];?></td>
          </tr>
        </table>
      </div> 
      
      <div style="margin:1em 0 0 2.5%;">
        <table>
          <thead>
            <tr>
              <th>Description</th>
            </tr>
          </thead>
          <tr>
            <td><?=$vehicle['description'];?></td>
          </tr>
        </table>
      </div>   
    </div>
  <?php } ?>
  </div>
</div>

