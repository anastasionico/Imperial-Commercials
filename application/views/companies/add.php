<ul class="breadcrumb">
  <li><a href="/<?=$this->uri->segment(1)?>/companies/">Customer Sites (Companies)</a> <span class="divider">/</span></li>
  <li class="active">Add</li>
</ul>
<div class="page-header">
    <h1>Add New Company</h1>
</div>

<form action="/<?=$this->uri->segment(1)?>/companies/add" class="form-horizontal" method="post" accept-charset="utf-8" enctype="multipart/form-data">
  <div class="row fluid">
    <div class="span12">
      <div class="control-group">
        <label class="control-label" for="name">Company Name</label>
        <div class="controls">
          <input type="text" id="name" name="name">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="url">URL</label>
        <div class="controls">
          <input type="text" id="url" name="url">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="part_discount_m1_id">Discount Table for MB</label>
        <div class="controls">
          <select name="part_discount_m1_id">
            <option value="0">Select</option>
            <? foreach($discounts_m1 as $discount) { ?>
            <option value="<?=$discount['id']?>"><?=$discount['name']?></option>
            <? } ?>
          </select>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="part_discount_m2_id">Discount Table for DAF</label>
        <div class="controls">
          <select name="part_discount_m2_id">
            <option value="0">Select</option>
            <? foreach($discounts_m2 as $discount) { ?>
            <option value="<?=$discount['id']?>"><?=$discount['name']?></option>
            <? } ?>
          </select>
        </div>
      </div>
      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </div>
    </div><!--/.span12-->
  </div><!--/.row-->
</form>
