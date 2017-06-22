<style type="text/css">
  .offer-group{
    border: 1px solid #ccc;
    height: 150px;
    margin-bottom:1em; 
    box-sizing: border-box;

  }
  .offer-image{
    display: inline-block;
    float: left;
    width: 150px;
    height: 100%;
    background-repeat: no-repeat;
    background-size: 120%;
    background-position: center; 
  }
  .offer-description{
    padding: 1em;
    display: inline-block;
    width: 66%; 
  }
  .fa-times{
    color: red;
  }
</style>
<div class="container">
  <div class="row">
    <div class="col-xs-12">
      <div class="page-header">
        <h1><?=$location['name']?></h1>
      </div>
    </div>
    <div class="col-xs-12">

      <form action="/admin/locations/edit/<?=$location['id']?>" enctype="multipart/form-data" method="post" accept-charset="utf-8">

        <div class="form-group">
          <label for="name">Name</label>
          <input name="name" type="text" class="form-control" id="name" value="<?=$location['name']?>">
        </div>

        <div class="form-group">
          <label for="manufacturer">Manufacturer</label>
          <input name="manufacturer" type="text" class="form-control" id="manufacturer" value="<?=$location['manufacturer']?>">
        </div>

        <div class="form-group">
          <label for="address">Address</label>
          <input name="address" type="text" class="form-control" id="address" value="<?=$location['address']?>">
        </div>

        <div class="form-group">
          <label for="phone">Phone</label>
          <input name="phone" type="text" class="form-control" id="phone" value="<?=$location['phone']?>">
        </div>

        <div class="form-group">
          <label for="lat">Latitude</label>
          <input name="lat" type="text" class="form-control" id="lat" value="<?=$location['lat']?>">
        </div>

        <div class="form-group">
          <label for="lng">Longitude</label>
          <input name="lng" type="text" class="form-control" id="lng" value="<?=$location['lng']?>">
        </div>

        <div class="form-group">
          <label for="autotrader_did">Autotrader DID number</label>
          <input name="autotrader_did" type="text" class="form-control" id="autotrader_did" value="<?=$location['autotrader_did']?>">
        </div>

        <div class="form-group">
          <label for="opening_content">Opening Hours</label>
          <textarea id="tinymce-2" name="opening_content"><?=$location['opening_content']?></textarea>
        </div>

        <div class="form-group">
          <label for="content">Content</label>
          <textarea id="tinymce-1" name="content"><?=$location['content']?></textarea>
        </div>
      </form>

    </div><!-- /.col -->
  </div><!-- /.row -->
  <br><br><br><br><br>
  <div class="row">
    <h1>Offers</h1>
    <div class="col-xs-12">
      <?php foreach ($offers as $offer):?>
        <div class="offer-group">
          <a href="<?= $offer['url'] ?>">   
            <div class="offer-image" style="background-image: url(<?= base_url() ?>/perch/resources/<?= $offer['img']?>)">
            </div>
          </a>
          <span class="offer-description">
            <a href="<?= $offer['url'] ?>">      
              <b><?= ucfirst($offer['title']) ?></b>
            </a>
            <br>
            <p><?= $offer['offer_detail']?></p>  
            <a href="<?php echo site_url("admin/destroyOffer/$offer[id]") ?>" class="btn btn-danger">Delete</a>
          </span>
        </div>    
      <?php endforeach; ?>
    </div>


    <div class="col-xs-12">
      <?= validation_errors(); ?>

      <?= form_open_multipart('admin/addOffer')?>
      <?= form_hidden('location_id', $location['id']); ?>
        <div class="form-group">
          <label for="userfile">Image*</label>
          <input type="file" name="userfile" class="form-control"/>
        </div>
        <div class="form-group">
          <label for="url">Url*</label>
          <input name="url" type="text" class="form-control" id="url" placeholder="www.imperialcommercials.co.uk/trucks/offer">
        </div>
        <div class="form-group">
          <label for="title">Title*</label>
          <input name="title" type="text" class="form-control" id="title" >
        </div>
        <div class="form-group">
          <label for="offer_detail">Description*</label>
          <input name="offer_detail" type="text" class="form-control" id="offer_detail" placeholder="Min 15 characters">
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-primary">Add Offer</button>
        </div>

      <?= form_close()?>
    </div>
  </div>
</div><!-- /.container -->

<script type="text/javascript">
    tinymce.init({ selector: "#tinymce-1" });
    tinymce.init({ selector: "#tinymce-2" });
</script>

