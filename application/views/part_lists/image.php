<ul class="breadcrumb">
  <li><a href="/<?=$this->uri->segment(1)?>/part_lists/">Part Lists</a> <span class="divider">/</span></li>
  <li><a href="/<?=$this->uri->segment(1)?>/part_lists/<?=$part_list['id']?>"><?=$part_list['name']?></a> <span class="divider">/</span></li>
  <li class="active">Add Image</li>
</ul>
<div class="page-header">
  <h1><?=$part['pnumber']?> <?=$part['description']?></h1>
</div>
<img src="<?=$part['image']?>">

<form action="/<?=$this->uri->segment(1)?>/part_lists/image/<?=$part_list['id']?>/<?=$part['id']?>" class="form-horizontal" method="post" accept-charset="utf-8" enctype="multipart/form-data">

  <div class="control-group">
    <label class="control-label" for="picture">New Picture</label>
    <div class="controls">
      <input name="picture" type="file">
    </div>
  </div>

  <div class="control-group">
    <div class="controls">
      <input type="submit" class="btn btn-primary" value="Upload">
    </div>
  </div>
</form>
