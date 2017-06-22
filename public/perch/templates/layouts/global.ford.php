<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<title><?php perch_pages_title(); ?> - Imperial Commercials</title>
<?php perch_page_attributes(); ?>
<?php perch_get_css(); ?>

    <!-- Bootstrap -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
    <link href="/assets/css/ford.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="/favicon.png" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Begin Cookie Consent plugin by Silktide - http://silktide.com/cookieconsent -->
    <script type="text/javascript">
        window.cookieconsent_options = {"message":"This website uses cookies to ensure you get the best experience on our website","dismiss":"Got it!","learnMore":"More Info","link":"/pages/cookie-policy.php","theme":"dark-top"};
    </script>

    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/1.0.10/cookieconsent.min.js"></script>
    <!-- End Cookie Consent plugin -->

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-57QFH6');</script>
    <!-- End Google Tag Manager -->
  </head>
  <body class="ford">

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-57QFH6"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->


    <div class="ford-menu hidden-xs hidden-sm">
      <div class="button sidebar-tab service">
        <a href="#" data-toggle="modal" data-target="#modal-book_service" class="menubtn" title="Book a Service">
          <i class="icon"></i>
          <span>Book a Service</span>
        </a>
      </div>
      <div class="button sidebar-tab parts">
        <a href="#" data-toggle="modal" data-target="#modal-test_drive" class="menubtn" title="Book a Test Drive">
          <i class="icon"></i>
          <span>Test Drive</span>
        </a>
      </div>
      <div class="button sidebar-tab valuation">
        <a href="#" data-toggle="modal" data-target="#modal-enquiry" class="menubtn" title="Enquiry">
          <i class="icon"></i>
          <span>Make an Enquiry</span>
        </a>
      </div>
      <div class="button sidebar-tab locations">
        <a href="/locations/ford" title="View Locations" class="menubtn">
          <i class="icon"></i>
          <span>View Locations</span>
        </a>
      </div>
    </div>

    <div id="header-scrape" class="container">
      <div id="header">
        <div class="row">
          <div class="col-xs-6 col-md-4">
            <a href="/ford"><span id="logo">Imperial Commercials</span></a>
          </div>
          <div class="col-xs-6 col-md-8 text-right">
            <a href="/ford"><img id="logo-ford" src="/assets/img/ford-logo.png" alt="Imperial Commercials"></a>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /#header -->

      <nav class="navbar navbar-default">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
              <div class="bars">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </div>
              <div class="inline-block">
                <span class="caption">Menu</span>
              </div>
            </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <?php perch_content('Ford Main Menu'); ?>
        </div><!-- /.navbar-collapse -->
      </nav>

      <!-- mobile buttons -->
      <div class="row">
        <div class="col-xs-12 visible-xs mobile-submenu">
          <form class="form-inline" method="post" action="/locations/nearest">
            <label for="search">Find your nearest dealership: </label>
            <div class="input-group searchbar">
              <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
              <input id="search" name="search" type="text" class="form-control" placeholder="Type your postcode">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">Go!</button>
              </span>
            </div><!-- /input-group -->
          </form>
          <div class="nav-coa">
            <div class="col">
              <a href="#" data-toggle="modal" data-target="#modal-callme">
                <span class="icon icon-phone-light" aria-hidden="true"></span> Call Back
              </a>
            </div>
            <div class="col">
              <a href="#" data-toggle="modal" data-target="#modal-enquiry">
                <span class="icon icon-email-light" aria-hidden="true"></span> Enquiry
              </a>
            </div>
            <div class="col">
              <a href="#" data-toggle="modal" data-target="#modal-part_exchange">
                <span class="icon icon-truck-light" aria-hidden="true"></span> Part-ex
              </a>
            </div>
            <div class="col">
              <a href="#" data-toggle="modal" data-target="#modal-test_drive">
                <span class="icon icon-drive-light" aria-hidden="true"></span> Test Drive
              </a>
            </div>
            <div class="col fullwidth">
              <a href="/locations">
                <span class="icon icon-location-light" aria-hidden="true"></span> Locations
              </a>
            </div>
          </div><!-- /.nav-coa -->
        </div><!-- /.col -->
      </div><!-- /.row -->

    </div><!-- /.container -->


