<div class="container">
  <div class="row">
    <div class="col-xs-12">
      <div class="page-header">
        <h1>Quote Generator</h1>
      </div>
      <p>Select and upload your quote below to generate a branded quote PDF.</p>
    </div>
    <div class="col-xs-12">
      <form action="/admin/quotegen" enctype="multipart/form-data" method="post" accept-charset="utf-8">

        <div class="form-group">
          <label for="userfile">Upload a file</label>
          <input type="file" id="userfile" name="userfile">
        </div>

        <button type="submit" class="btn btn-primary">Upload</button>
      </form>

    </div><!-- /.col -->
  </div><!-- /.row -->
</div><!-- /.container -->
