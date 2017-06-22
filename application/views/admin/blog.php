<div class="container">
  <div class="row">
    <div class="col-xs-12">

      <a href="/admin/blog/add" class="btn btn-primary btn-lg">Add Blog</a>

      <div class="page-header">
        <h1>Blog</h1>
      </div>

      <table class="table table-hover table-striped">
        <thead>
          <tr>
            <th>Name</th>
            <th>Address</th>
          </tr>
        </thead>
        <tbody>
          <? if(! empty($blogs) ) { ?>
            <? foreach($blogs as $blog) { ?>
            <tr>
              <td><a href="/admin/blog/edit/<?=$blog['id']?>"><?=$blog['name']?></a></td>
              <td><?=$blog['address']?></td>
            </tr>
            <? } ?>
          <? } else { ?>
            <tr>
              <td colspan="2">There are currently no posts</td>
            </tr>
          <? } ?>
        </tbody>
      </table>

    </div>
  </div>
</div>
