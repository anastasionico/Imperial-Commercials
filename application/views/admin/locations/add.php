<div class="container">
  <div class="row">
    <div class="col-xs-12">
      <div class="page-header">
        <h1>Add Location</h1>
      </div>
    </div>
    <div class="col-xs-12">

      <form action="/admin/locations/add" enctype="multipart/form-data" method="post" accept-charset="utf-8">

        <div class="form-group">
          <label for="name">Name</label>
          <input name="name" type="text" class="form-control" id="name" placeholder="Imperial Commercials Stevenage">
        </div>

        <div class="form-group">
          <label for="manufacturer">Manufacturer</label>
          <input name="manufacturer" type="text" class="form-control" id="manufacturer" placeholder="Mercedes-Benz">
        </div>

        <div class="form-group">
          <label for="address">Address</label>
          <input name="address" type="text" class="form-control" id="address" placeholder="Address 1, Line 2, Town, City, Postcode">
        </div>

        <div class="form-group">
          <label for="phone">Phone</label>
          <input name="phone" type="text" class="form-control" id="phone" placeholder="01707 261111">
        </div>

        <div class="form-group">
          <label for="lat">Latitude</label>
          <input name="lat" type="text" class="form-control" id="lat" placeholder="52.942226">
          <span id="helpBlock" class="help-block">Follow directions from "Get the coordinates of a place" <a href="https://support.google.com/maps/answer/18539?co=GENIE.Platform%3DDesktop&hl=en" target="_blank">here</a>.</span>
        </div>

        <div class="form-group">
          <label for="lng">Longitude</label>
          <input name="lng" type="text" class="form-control" id="lng" placeholder="-1.553888">
          <span id="helpBlock" class="help-block">Follow directions from "Get the coordinates of a place" <a href="https://support.google.com/maps/answer/18539?co=GENIE.Platform%3DDesktop&hl=en" target="_blank">here</a>.</span>
        </div>

        <div class="form-group">
          <label for="opening_content">Opening Hours</label>
          <textarea id="tinymce-2" name="opening_content"> </textarea>
        </div>

        <div class="form-group">
          <label for="content">Content</label>
          <textarea id="tinymce-1" name="content"> </textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>

      </form>

    </div><!-- /.col -->
  </div><!-- /.row -->
</div><!-- /.container -->

<script type="text/javascript">
    tinymce.init({ selector: "#tinymce-1" });
    tinymce.init({ selector: "#tinymce-2" });
</script>


