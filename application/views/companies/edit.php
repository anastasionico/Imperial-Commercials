<ul class="breadcrumb">
  <li><a href="/<?=$this->uri->segment(1)?>/companies/<?=$section?>"><?php echo ucfirst($section); ?></a> <span class="divider">/</span></li>
  <li class="active">Edit <?=$company['name']?></li>
</ul>
<div class="page-header">
    <h1><?=$company['name']?></h1>
</div>

<form action="/<?=$this->uri->segment(1)?>/companies/<?=$section?>/<?=$company['id']?>" class="form-horizontal" method="post" accept-charset="utf-8" enctype="multipart/form-data">
  <div class="row fluid">
    <div class="span12">
      <div class="control-group">
        <label class="control-label" for="name">Company Name</label>
        <div class="controls">
          <input type="text" id="name" name="name" value="<?=$company['name']?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="url">URL</label>
        <div class="controls">
          <input type="text" id="url" name="url" value="<?=$company['url']?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="part_discount_m1_id">Discount Table for MB</label>
        <div class="controls">
          <select name="part_discount_m1_id">
            <option value="0">Select</option>
            <? foreach($discounts_m1 as $discount) { ?>
            <option value="<?=$discount['id']?>"<? if($discount['id'] == $company['part_discount_m1_id']) { ?> selected<? } ?>><?=$discount['name']?></option>
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
            <option value="<?=$discount['id']?>"<? if($discount['id'] == $company['part_discount_m2_id']) { ?> selected<? } ?>><?=$discount['name']?></option>
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

<hr>

<form action="/<?=$this->uri->segment(1)?>/companies/<?=$section?>/<?=$company['id']?>" class="form-horizontal" method="post" accept-charset="utf-8" enctype="multipart/form-data">
  <input type="hidden" name="logo_update" value="1" />
  <div class="row fluid">
    <div class="span12">
      <div class="control-group">
        <label class="control-label">Logo</label>
        <div class="controls">
          <? if(! empty($company['logo'])) { ?>
          <img src="/assets/img/logo/<?=$company['logo']?>" />
          <? } else { ?>
          <b>No logo uploaded</b>
          <? } ?>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="userfile">Upload new Logo</label>
        <div class="controls">
          <input type="file" name="userfile" size="20" />
          <span class="help-block">Max size: 300x140px, Max file size: 500kb. GIF, JPG or PNG only.</span>
        </div>
      </div>
      <div class="control-group">
        <div class="controls">
          <input type="submit" class="btn btn-primary" value="Upload" />
        </div>
      </div>
    </div><!--/.span12-->
  </div><!--/.row-->
</form>

<div class="page-header">
  <h1><?=$company['name']?> Users</h1>
  <a href="/<?=$this->uri->segment(1)?>/users/add/<?=$company['id']?>/<?=$section?>" class="btn btn-small">Add</a>
</div>

<table id="users" class="table table-striped table-hover table-clickrow table-bordered">
  <thead>
    <tr>
      <th>Username</th>
      <th>Full Name</th>
      <th>Account Type</th>
      <th>Last Login</th>
      <th>Email</th>
    </tr>
  </thead>
  <tbody>
  <? foreach($company['user'] as $user) { ?>
    <tr id="row_<?=$user['id']?>">
      <td><?=$user['username']?></td>
      <td><?=$user['fullname']?></td>
      <td><?php echo ($user['staff'] == 1) ? 'Supplier' : 'Customer'; ?></td>
      <td><?=$user['last_login']?></td>
      <td><?=$user['email']?></td>
    </tr>
  <? } ?>
  </tbody>
</table>

<script src="/assets/js/jquery.dataTables.min.js"></script>
<script src="/assets/js/jquery.dataTables.bootstrap.js"></script>
<script type="text/javascript" charset="utf-8">

$.extend( $.fn.dataTableExt.oStdClasses, {
    "sWrapper": "dataTables_wrapper form-inline"
});
jQuery.extend( jQuery.fn.dataTableExt.oSort, {
    "date-uk-pre": function ( a ) {
        var ukDatea = a.split('/');
        return (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
    },
    "date-uk-asc": function ( a, b ) {
        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
    },
    "date-uk-desc": function ( a, b ) {
        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
    }
});


  $(document).ready(function() {

    /*
    // datatables
    $('#parts-unlisted').dataTable( {
        "aoColumns": [
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null
        ],
        "sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
        "aLengthMenu": [
            [25, 50, 100, 200, -1],
            [25, 50, 100, 200, "All"]
        ], 
        "iDisplayLength" : -1,
        "sPaginationType": "bootstrap"
    });
    */

  $(".table-clickrow tbody")
    .on("click", "tr", function() {
      var n=$(this).attr('id').split("_");
      window.location = '/<?=$this->uri->segment(1)?>/users/<?=$section?>/'+ n[1];
    })
    .on("mouseover", "tr", function() {
      $(this)
        .addClass("over")
        .css('cursor', 'pointer');
    })
    .on("mouseout", "tr", function() {
      $(this)
        .removeClass("over")
        .css('cursor', 'auto');
    });

  });
</script>

