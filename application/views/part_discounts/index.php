<div class="page-header">
    <h1>Discount Management</h1>
</div>

<div class="row fluid">
  <? foreach($manufacturers as $manufacturer) { ?>
  <div class="span4">
    <h2><?=$manufacturer['name']?></h2>
    <table class="table table-striped table-hover table-clickrow table-bordered">
      <? foreach($manufacturer['discounts'] as $discount) { ?>
      <tr id="row_<?=$manufacturer['id']?>_<?=$discount['id']?>">
        <td>
          <?=$discount['name']?>
        </td>
      </tr>
      <? } ?>
    </table>
    <a href="/<?=$this->uri->segment(1)?>/part_discounts/<?=$manufacturer['id']?>/add" class="btn btn-small">Add a <?=$manufacturer['name']?> Discount List</a>
  </div><!--/.span4-->
  <? } ?>
</div><!--/.row-->

<script type="text/javascript" charset="utf-8">

  $(document).ready(function() {

    $(".table-clickrow tbody")
      .on("click", "tr", function() {
        var n=$(this).attr('id').split("_");
        window.location = '/<?=$this->uri->segment(1)?>/part_discounts/edit/'+ n[1] + '/' + n[2];
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
