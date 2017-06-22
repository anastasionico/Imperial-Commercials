<style type="text/css">
  .clickable:hover{
    cursor: pointer;
  }
</style>
<div class="container">
  <div class="row">
    <div class="col-xs-12">
      <a href="/admin/users/add" class="btn btn-primary btn-lg">Add User</a>
      <div class="page-header">
        <h1>Users</h1>
      </div>
      <table class="table table-hover table-striped">
        <thead>
          <tr>
            <th>Full Name</th>
            <th>Email</th>
            <th>Included</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <? 
            if(!empty($users)){
              foreach($users as $user){ 
                $created_at = new Datetime($user['created_at']); 
                $created_at = $created_at->format('d-m-Y');
                

          ?>
                <tr class="clickable" onclick="document.location='/admin/users/edit/<?=$user['id']?>' " >
                  <td>
                    <?=$user['fullname']?>
                  </td>
                  <td><?=$user['email']?></td>
                  <td><?= $created_at ?></td>
                  <td>
                    <a href="users/delete/<?=$user['id']?>" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove-sign"></span></a>
                  </td>
                </tr>
          <?  }
            }else{ 
          ?>
              <tr>
                <td colspan="2">There are currently no users</td>
              </tr>
          <? } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>