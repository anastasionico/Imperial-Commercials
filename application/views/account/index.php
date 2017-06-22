<div class="page-header">
    <h1>Change Password</h1>
</div>
<div class="row-fluid">
  <div class="span12">
    <form action="/<?=$this->uri->segment(1)?>/account/change_password" method="post" class="form-horizontal">
      <div class="control-group">
        <label class="control-label" for="password">Password</label>
        <div class="controls">
          <input type="password" id="password" name="password" placeholder="Password">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="passconf">Confirm Password</label>
        <div class="controls">
          <input type="password" id="passconf" name="passconf" placeholder="Confirm Password">
        </div>
      </div>
        <div class="form-actions">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
  </div>
</div>
