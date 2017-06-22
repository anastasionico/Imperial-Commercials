<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>OrwellDirect</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <link href="/assets/css/bootstrap.css" rel="stylesheet">
    <style>
      body {
        padding-top: 80px;
        padding-bottom: 40px;
      }

      .iline { float: left; padding: 0 5px 0 0; }
      .inline { 
        display: inline-block;
        margin-bottom: 0;
        vertical-align: middle;
      }
      input.inline { margin-bottom: 0; }
    </style>
    <link href="/assets/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="/assets/css/bootstrap-custom.css?version=2" rel="stylesheet">
    <script src="/assets/js/jquery-1.9.1.min.js"></script>
    <script src="/assets/js/jquery.validate.min.js"></script>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="/assets/js/html5shiv.js"></script>
    <![endif]-->
<?/*
    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="../assets/ico/favicon.png">
*/?>
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="#"><img src="/assets/img/mercedes-benz-logo-black.png" alt="Mercedes-Benz" title="Mercedes-Benz"></a>
          <div class="nav-collapse collapse">
            <p class="navbar-text pull-right visible-desktop">Orwell<i>direct</i><br>01473 618000</p>

            <ul class="nav">
<?
// build the menu
foreach($menu_items as $item)
{ 
    if($item['name'] != 'part_escalation' && $item['name'] != 'users') {
      echo '              <li';
      if($item['name'] == $this->uri->segment(2))
      {
        echo ' class="active"';
      }
      echo '>' . anchor($this->uri->segment(1) . '/' . $item['name'], $item['title']) . '</li>' . "\n";
    }
}
?>
              <li><?=anchor($this->uri->segment(1) . '/logout', 'Logout')?></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div id="main" class="container">
      <?
      $alert = $this->session->flashdata('alert');
      if($alert) {
      ?>
      <div class="alert alert-<?=$alert['type']?>">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?=$alert['message']?>
      </div>
      <? } ?>

      <?=$yield?>

    </div> <!-- /container -->

    <script src="/assets/js/bootstrap.min.js"></script>

  </body>
</html>
