<ul class="breadcrumb">
  <li><a href="/<?=$this->uri->segment(1)?>/part_discounts/">Part Discounts</a> <span class="divider">/</span></li>
  <li class="active">New Part Discount List</li>
</ul>
<div class="page-header">
  <h1>New <?=$manufacturer['name']?> Discount List</h1>
</div>
<form action="/<?=$this->uri->segment(1)?>/part_discounts/<?=$manufacturer['id']?>/add" class="form-horizontal" method="post" accept-charset="utf-8" enctype="multipart/form-data">
  <div class="row fluid">
    <div class="span12">
      <div class="control-group">
        <label class="control-label" for="name">Name</label>
        <div class="controls">
          <input type="text" id="name" name="name" placeholder="Name" value="">
        </div>
      </div>
      <? foreach($columns as $column) { ?>
      <div class="control-group">
        <label class="control-label" for="c<?=$column?>"><?=$column?></label>
        <div class="controls">
          <input type="text" id="c<?=$column?>" name="c<?=$column?>" placeholder="0.0" value="">
        </div>
      </div>
      <? } ?>
      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-primary">Add</button>
        </div>
      </div>
    </div>
  </div>
</form>
