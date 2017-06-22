<? if(! empty($sites) ) { ?>
<div class="row-fluid">
  <div class="span12">
    <div class="page-header">
      <h1>Outstanding Orders</h1>
    </div>
    <? if( count($outstanding_orders) > 0 ) { ?>
    <table class="table table-striped table-hover table-clickrow table-bordered">
      <? foreach($outstanding_orders as $order) { ?>
      <tr id="row_<?=$order['site']?>_<?=$order['id']?>">
        <td><?=date("d/m/y", $order['timestamp']);?></td>
        <td><?=$order['company_name']?></td>
        <td><?=$order['username']?></td>
        <td><?=$order['status_human']?></td>
      </tr>
      <? } ?>
    </table>
    <? } else { ?>
      <div>There are currently no outstanding orders. <a href="/<?=$this->uri->segment(1)?>/part_order/">Re Check</a></div>
    <? } ?>
  </div>
</div>
<div class="row-fluid">
  <div class="span12">
    <div class="page-header">
      <h1>Users</h1>
    </div>
    <ul class="site-list">
    <?
    foreach($sites as $site)
    {
        echo "<li><a href='/" . $this->uri->segment(1) . "/part_order/" . $site['id'] . "'>" . $site['company_name'] . " / " . $site['fullname'] . "</a>";

        /*
        if($site['outstanding'] > 0)
        {
            echo "<span class='badge badge-important'>" . $site['outstanding'] . "</span>";
        }
         */

        echo "</li>";
    }
    ?>
    </ul>
  </div>
</div>
<style type="text/css" media="all">
  ul.site-list {
    margin: 0;
  }
  ul.site-list li {
    float: left;
    list-style: none;
    width: 250px;
    margin-right: 10px;
    margin-bottom: 5px;
    padding: 8px 12px; 
    border: 1px solid #DDD;
  -webkit-border-radius: 4px;
     -moz-border-radius: 4px;
          border-radius: 4px;
  }
  ul.site-list li span.badge {
    float: right;
  }
</style>
<script type="text/javascript" charset="utf-8">
  $(document).ready(function() {

    $(".table-clickrow tbody")
      .on("click", "tr", function() {
        var n=$(this).attr('id').split("_");
        window.location = '/<?=$this->uri->segment(1)?>/part_order/'+ n[1] + '/'+ n[2];
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
<? } else { ?>
<p>This account has not been configured with any dispatch groups.</p>
<? } ?>
