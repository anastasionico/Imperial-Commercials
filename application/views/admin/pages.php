<div class="container">
  <div class="row">
    <div class="col-xs-12">

      <a href="/admin/pages/add" class="btn btn-primary btn-lg">Add Page</a>

      <div class="page-header">
        <h1>Pages</h1>
      </div>

      <table class="table table-hover table-striped">
        <thead>
          <tr>
            <th>Name</th>
            <th>Address</th>
          </tr>
        </thead>
        <tbody>
          <? foreach($pages as $page) { ?>
          <tr>
            <td><a href="/admin/pages/edit/<?=$page['id']?>"><?=$page['name']?></a></td>
            <td><?=$page['address']?></td>
          </tr>
          <? } ?>
        </tbody>
      </table>

    </div>
  </div>
</div>
