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
  <li>
    <a href="/<?=$this->uri->segment(1)?>/users/<?=$section?>/<?=$user_account['id']?>/passwordreset">Reset Password</a>
  </li>
  <? if($user_account['staff'] == 0) { ?>
  <li class="active">
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

<form action="/<?=$this->uri->segment(1)?>/users/<?=$section?>/<?=$user_account['id']?>/part_lists" class="form-horizontal" method="post" accept-charset="utf-8" enctype="multipart/form-data">
  <div class="row fluid">
    <div class="span12">
      <? foreach($manufacturers as $manufacturer) { ?>
      <h2><?=$manufacturer['name']?></h2>
      <? foreach($manufacturer['part_list'] as $part_list) { ?>
      <label class="checkbox">
        <input name="partlist_<?=$part_list['id']?>" type="checkbox" value="1"<?if($part_list['checked']) { ?> checked<? } ?>>
        <?=$part_list['name']?>
        <? if($part_list['imprest'] == 1) { ?><i>Imprest</i><? } ?>
      </label>
      <? } ?>
      <? } ?>
      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </div>
    </div><!--/.span12-->
  </div><!--/.row-->
</form>


