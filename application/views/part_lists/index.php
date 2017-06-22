<div class="page-header">
  <h1>Part Lists</h1>
  <a href="/<?=$this->uri->segment(1)?>/part_lists/add" class="btn btn-small">Add</a>
</div>

<div class="row fluid">
  <? foreach($manufacturers as $manufacturer) { ?>
  <div class="span4">
    <h2><?=$manufacturer['name']?></h2>
    <table class="table table-striped table-hover table-clickrow table-bordered">
      <? foreach($manufacturer['part_list'] as $part_list) { ?>
      <tr id="row_<?=$part_list['id']?>">
        <td>
          <?=$part_list['name']?>
          <? if($part_list['imprest'] == 1) { ?><i>Imprest</i><? } ?>
        </td>
      </tr>
      <? } ?>
    </table>
  </div><!--/.span4-->
  <? } ?>
</div><!--/.row-->

<script type="text/javascript" charset="utf-8">

  $(document).ready(function() {

    $(".table-clickrow tbody")
      .on("click", "tr", function() {
        var n=$(this).attr('id').split("_");
        window.location = '/<?=$this->uri->segment(1)?>/part_lists/'+ n[1];
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
