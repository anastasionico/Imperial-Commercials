<div class="container">
  <div class="row">
    <div class="col-xs-12">

      <a href="/admin/locations/add" class="btn btn-primary btn-lg">Add Location</a>

      <div class="page-header">
        <h1>Locations</h1>
      </div>

      <table class="table table-hover table-striped">
        <thead>
          <tr>
            <th>Name</th>
            <th>Address</th>
          </tr>
        </thead>
        <tbody>
          <? if(! empty($locations) ) { ?>
            <? foreach($locations as $location) { ?>
            <tr>
              <td><a href="/admin/locations/edit/<?=$location['id']?>"><?=$location['name']?></a></td>
              <td><?=$location['address']?></td>
            </tr>
            <? } ?>
          <? } else { ?>
            <tr>
              <td colspan="2">There are currently no locations</td>
            </tr>
          <? } ?>
        </tbody>
      </table>

    </div>
  </div>
</div>
