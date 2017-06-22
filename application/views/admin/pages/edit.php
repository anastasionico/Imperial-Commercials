<div class="container">
  <div class="row">
    <div class="col-xs-12">
      <div class="page-header">
        <h1><?=$page['name']?></h1>
      </div>
    </div>
    <div class="col-xs-12">

      <? foreach($contents as $content) { ?>
      <h2><?=$content['friendly_name']?></h2>
      <form action="/admin/page_content/<?=$content['id']?>" enctype="multipart/form-data" method="post" accept-charset="utf-8">

        <textarea id="tinymce-<?=$content['id']?>" name="content"><?=$content['content']?></textarea>

        <button type="submit" class="btn btn-primary">Update</button>
      </form>
      <? } ?>

    </div><!-- /.col -->
  </div><!-- /.row -->
</div><!-- /.container -->

<script type="text/javascript">
  <? foreach($contents as $content) { if($content['type'] == 'tinymce') { ?>
    tinymce.init({ selector: "#tinymce-<?=$content['id']?>" });
  <? } } ?>
</script>
