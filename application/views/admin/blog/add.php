<div class="container">
  <div class="row">
    <div class="col-xs-12">
      <div class="page-header">
        <h1>Add new blog post</h1>
      </div>
    </div>
    <div class="col-xs-12">
      <form action="/admin/blog/add" enctype="multipart/form-data" method="post" accept-charset="utf-8">

        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" class="form-control" id="name" name="name" placeholder="Post Name">
        </div>

        <div class="form-group">
          <label for="url">URL</label>
          <input type="text" class="form-control" id="url" name="url" placeholder="/why-buy-a-van">
          <span class="help-block">Should be everything after "domain.com/blog"</span>
        </div>

        <textarea id="tinymce-1" name="content"></textarea>

        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">
  <? /*
  <? foreach($contents as $content) { if($content['type'] == 'tinymce') { ?>
    tinymce.init({ selector: "#tinymce-<?=$content['id']?>" });
  <? } } ?>
  */ ?>

  tinymce.init({
    selector: "#tinymce-1",
    height: 500,
    plugins: [
      'advlist autolink lists link image charmap print preview anchor',
      'searchreplace visualblocks code fullscreen',
      'insertdatetime media table contextmenu paste code'
    ],
    toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
  });
</script>
