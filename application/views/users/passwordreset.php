<ul class="breadcrumb">
  <li><a href="/<?=$this->uri->segment(1)?>/companies/<?=$section?>/"><?php echo ucfirst($section); ?></a> <span class="divider">/</span></li>
  <li><a href="/<?=$this->uri->segment(1)?>/companies/<?=$section?>/<?=$user_account['company']['id']?>"><?php echo $user_account['company']['name']; ?></a> <span class="divider">/</span></li>
  <li class="active">Edit User</li>
</ul>
<div class="page-header">
    <h1><?=$user_account['fullname']?></h1>
</div>

<ul class="nav nav-tabs">
  <li>
    <a href="/<?=$this->uri->segment(1)?>/users/<?=$section?>/<?=$user_account['id']?>">User Details</a>
  </li>
  <li>
    <a href="/<?=$this->uri->segment(1)?>/users/<?=$section?>/<?=$user_account['id']?>/permissions">Permissions</a>
  </li>
  <li class="active">
    <a href="/<?=$this->uri->segment(1)?>/users/<?=$section?>/<?=$user_account['id']?>/passwordreset">Reset Password</a>
  </li>
  <? if($user_account['staff'] == 0) { ?>
  <li>
    <a href="/<?=$this->uri->segment(1)?>/users/<?=$section?>/<?=$user_account['id']?>/part_lists">Part Lists</a>
  </li>
  <? } ?>
  <? if($user_account['staff'] == 1) { ?>
  <li>
    <a href="/<?=$this->uri->segment(1)?>/users/<?=$section?>/<?=$user_account['id']?>/dispatch_groups">Dispatch Groups</a>
  </li>
  <? } ?>
  <li>
    <a href="/<?=$this->uri->segment(1)?>/users/<?=$section?>/<?=$user_account['id']?>/imprest_list">Imprest Stock List</a>
  </li>
</ul>

<form action="/<?=$this->uri->segment(1)?>/users/<?=$section?>/<?=$user_account['id']?>/passwordreset" class="form-horizontal" method="post" accept-charset="utf-8" enctype="multipart/form-data">
  <div class="row fluid">
    <div class="span12">
      <div class="control-group">
        <label class="control-label" for="password1">New Password</label>
        <div class="controls">
          <input type="password" id="password1" name="password1">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="password2">Repeat Password</label>
        <div class="controls">
          <input type="password" id="password2" name="password2">
        </div>
      </div>
      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-primary">Reset</button>
        </div>
      </div>
    </div><!--/.span12-->
  </div><!--/.row-->
</form>

