<ul class="breadcrumb">
  <li><a href="/<?=$this->uri->segment(1)?>/part_order/">Orders</a> <span class="divider">/</span></li>
  <li class="active"><?=$site['company_name']?> <?=$site['fullname']?></li>
</ul>
<div class="page-header">
    <h1><?=$site['company_name']?> <?=$site['fullname']?> Orders</h1>
</div>
<table class="table table-striped table-hover table-clickrow table-bordered">
  <? foreach($orders as $order) { ?>
  <tr id="row_<?=$order['id']?>">
    <td><?=date("d/m/y", $order['timestamp']);?></td>
    <td><?=$order['username']?></td>
    <td><?=$order['status_human']?></td>
  </tr>
  <? } ?>
</table>
<script type="text/javascript" charset="utf-8">
  $(document).ready(function() {

    $(".table-clickrow tbody")
      .on("click", "tr", function() {
        var n=$(this).attr('id').split("_");
        window.location = '/<?=$this->uri->segment(1)?>/part_order/<?=$this->uri->segment(3)?>/'+ n[1];
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
