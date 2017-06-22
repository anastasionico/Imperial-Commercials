<ul class="breadcrumb">
  <li><a href="/<?=$this->uri->segment(1)?>/part_lists/">Part Lists</a> <span class="divider">/</span></li>
  <li class="active">New Part List</li>
</ul>
<div class="page-header">
  <h1>New Part List</h1>
</div>
<form action="/<?=$this->uri->segment(1)?>/part_lists/add" class="form-horizontal" method="post" accept-charset="utf-8" enctype="multipart/form-data">
  <div class="row fluid">
    <div class="span12">
      <div class="control-group">
        <label class="control-label" for="manufacturer_id">Manufacturer</label>
        <div class="controls">
          <select name="manufacturer_id">
            <? foreach($manufacturers as $manufacturer) { ?>
            <option value="<?=$manufacturer['id']?>"><?=$manufacturer['name']?></option>
            <? } ?>
          </select>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="name">Name</label>
        <div class="controls">
          <input type="text" id="name" name="name" placeholder="Name" value="">
        </div>
      </div>
      <div class="control-group">
        <div class="controls">
          <label class="checkbox">
            <input type="checkbox" name="imprest" value="1">
            Imprest Stock List
          </label>
        </div>
      </div>
      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-primary">Add</button>
        </div>
      </div>
    </div>
  </div>
</form>


