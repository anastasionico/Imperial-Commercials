<div class="container">
  <div class="row">
    <div class="col-xs-12">
      <div class="page-header">
        <h1><?=$blog['name']?></h1>
      </div>
    </div>
    <div class="col-xs-12">

      <form action="/admin/blog/edit/<?=$blog['id']?>" enctype="multipart/form-data" method="post" accept-charset="utf-8">

        <textarea id="tinymce-1" name="content"><?=$blog['content']?></textarea>

        <button type="submit" class="btn btn-primary">Update</button>
      </form>

    </div><!-- /.col -->
  </div><!-- /.row -->
</div><!-- /.container -->

<script type="text/javascript">
    tinymce.init({ selector: "#tinymce-1" });
</script>
