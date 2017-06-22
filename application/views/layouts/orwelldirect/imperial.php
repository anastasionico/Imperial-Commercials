<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="x-ua-compatible" content="IE=edge" />

    <link rel="shortcut icon" href="../../assets/ico/favicon.png">

    <title>Orwell Truck &amp; Van Mercedes-Benz</title>

    <link href="/assets/css/bootstrap3.css" rel="stylesheet">
    <link href="/assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="/assets/js/html5shiv.js"></script>
    <script src="/assets/js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div id="nav-fixed">
      <div class="checkout_header">
        <div class="pull-left">
          <img src="/assets/img/orwell-logo.png" class="logo">
        </div>
        <div class="basket pull-right text-right">
          <a href="#" class="basket-link">
            <div class="basket-count">0</div>
          </a>
        </div>
        <div class="clearfix"> </div>
      </div>
    </div>

    <div class="snap-drawers">
      <div class="snap-drawer snap-drawer-left">

      </div>
    </div>

    <div id="content" class="snap-content"  data-spy="scroll" data-target=".subnav .nav">
    
      <div class="container">
        <div class="row">
          <div class="col-xs-6">
            <img src="/assets/img/orwell-logo.png" id="logo-sb">
          </div>
          <div class="col-xs-6 text-right">
            <img src="/assets/img/mercedes-benz-logo.png" id="logo-mercedes">
          </div>
        </div>
      </div>

      <div class="navbar navbar-inverse">
        <div class="container">
          <div class="navbar-left">
          </div>
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse navbar-right" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
              <li<? if(! $this->uri->segment(3) && $this->uri->segment(2) == 'parts') echo ' class="highlight active"'; ?>>
                <a href="/<?=$this->uri->segment(1)?>/parts/">
                  Order
                  <span class="childs"></span>
                </a>
              </li>
              <li<? if($this->uri->segment(3) == 'quote') echo ' class="highlight active"'; ?>>
                <a href="/<?=$this->uri->segment(1)?>/parts/quote/1">
                  Quote
                  <span class="childs"></span>
                </a>
              </li>
              <li<? if($this->uri->segment(3) == 'imprest') echo ' class="highlight active"'; ?>>
                <a href="/<?=$this->uri->segment(1)?>/parts/imprest">
                  Imprest
                  <span class="childs"></span>
                </a>
              </li>
<?/*
              <li<? if($this->uri->segment(3) == 'consumables') echo ' class="highlight active"'; ?>>
                <a href="/<?=$this->uri->segment(1)?>/parts/consumables">
                  Consumables
                  <span class="childs"></span>
                </a>
              </li>
 */?>
              <li<? if($this->uri->segment(3) == 'orders') echo ' class="highlight active"'; ?>>
                <a href="/<?=$this->uri->segment(1)?>/parts/orders">
                  View Orders
                  <span class="childs"></span>
                </a>
              </li>
<?/*
              <li<? if($this->uri->segment(3) == 'epc') echo ' class="highlight active"'; ?>>
                <a href="/<?=$this->uri->segment(1)?>/parts/epc">
                  EPC
                  <span class="childs"></span>
                </a>
              </li>
 */?>
              <li<? if($this->uri->segment(2) == 'account') echo ' class="highlight active"'; ?>>
                <a href="/<?=$this->uri->segment(1)?>/account">
                  Settings
                  <span class="childs"></span>
                </a>
              </li>
              <li>
                <a href="/<?=$this->uri->segment(1)?>/logout">
                  Logout
                  <span class="childs"></span>
                </a>
              </li>
            </ul>

          </div><!--/.nav-collapse -->
        </div>
      </div>

      <?
      $alert = $this->session->flashdata('alert');
      if($alert) {
      ?>
      <div class="container">
        <div class="row">
          <div class="col-xs-12">
            <div class="alert alert-<?=$alert['type']?>">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <?=$alert['message']?>
            </div>
          </div>
        </div>
      </div>
      <? } ?>

<?php echo $yield; ?>

      <div class="container">
        <div id="footer" class="links-white">
          <div class="row">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
              <div class="right">
                <span class="copyright">&#169; Orwell Truck &amp; Van Mercedes-Benz <?=date('Y');?></span>
              </div>
            </div><!--/.col-->
          </div><!--/.row-->
        </div><!--/#footer-->
      </div><!--/.container-->

    </div><!--/.snap-content-->

    <link href="/assets/css/chosen.min.css" rel="stylesheet">

    <script src="/assets/js/jquery-1.9.1.min.js"></script>
    <script src="/assets/js/bootstrap3.min.js"></script>
    <script src="/assets/js/jquery.mixitup.min.js"></script>
    <script src="/assets/js/jquery.scrollTo.min.js"></script>
    <script src="/assets/js/jquery.localscroll-1.2.7-min.js"></script>
    <script src="/assets/js/chosen.jquery.min.js"></script>

    <script src="/assets/js/app.js"></script>
  </body>
</html>
