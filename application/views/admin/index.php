<div class="container">
  <div class="row">
    <div class="col-xs-12">

      <a href="/admin/vehicles/add" class="btn btn-primary btn-md">Add Vehicle</a>

      <div class="page-header">
        <h1>Current Vehicles</h1>
      </div>

      <form class="form-inline">
      <div class="form-group">
        <label for="location" class="control-label">Filter by Location</label>
        <select name="mydropdown" class="styled" onChange="document.location = this.value" value="GO">
          <?foreach($locations as $location) { ?>
          <option value="/admin/location/<?=$location['id']?>"><?=$location['name']?> <?=$location['manufacturer']?></option>
          <? } ?>
        </select>
      </div>
      </form>

      <table class="table table-hover table-striped table-clickrow table-bordered" id="mainData">
        <thead>
          <tr>
            <th>Vehicle No. (url)</th>
            <th>REG</th>
            <th>Manufacturer</th>
            <th>Model</th>
            <th>Derivative</th>
            <th>Price</th>
            <th>Images</th>
          </tr>
        </thead>
        <tbody>
          <? foreach($vehicles as $vehicle) { ?>
            
          <tr id="row_<?php echo $vehicle['id']; ?>">
            <td><?=$vehicle['id']; ?></td>
            <td><?=$vehicle['registration']; ?></td>
            <td><?=$vehicle['manufacturer_text']; ?></td>
            <td><?=$vehicle['model_text']; ?></td>
            <td><?=$vehicle['derivative_text']; ?></td>
            <td><?=$vehicle['price']; ?></td>
            <td>
              <?php if(count($vehicle['additional_images']) >= 6): ?>
                <span style='color:green;'> <?=count($vehicle['additional_images']);?> </span> 
              <?php  else: ?>
                <span style='color:red;font-size: 120%'> <?=count($vehicle['additional_images']);?> </span> 
              <?php  endif; ?>
            </td>
          </tr>
          <? } ?>
        </tbody>
      </table>

    </div>
  </div>
</div>
