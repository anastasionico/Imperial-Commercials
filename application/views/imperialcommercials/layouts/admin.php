<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Imperial Commercials</title>
    
    <!--<link href="/assets/css/style.css" rel="stylesheet"> --!>

    <style>
    #logo { margin: 15px 10px; }
    </style>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <script type="text/javascript" src="/assets/js/tinymce/tinymce.min.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Bootstrap -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/jquery.fileupload.css" rel="stylesheet">
    <style type="text/css">
      #mainData_paginate{
        margin:2em;
      }
      .paginate_button {
        padding:0.5em  1em;
        border:1px solid #337ab7;
        margin-left: 1px;
      }
      .paginate_button.current {
        background-color: #337ab7;
        color: #fff;
      }

    </style>
  </head>
  <body>
    <div class="wrapper-white">
      <div class="container">
        <div>
          <a href="/">
            <img id="logo" src="/assets/img/logo.png" alt="Imperial Commercials">
          </a>
        </div>

        <nav class="navbar navbar-default">
          <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
                <li><a href="/" target="_blank">Homepage</a></li>
                <li><a href="/admin">Vehicles</a></li>
                <li><a href="/admin/pages">Pages</a></li>
                <li><a href="/admin/locations">Locations</a></li>
                <li><a href="/admin/users">Users</a></li>
                <?/*
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="#">One more separated link</a></li>
                  </ul>
               </li>
               */?>
              </ul>
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
        </nav>
      </div><!-- /.container -->
    </div><!-- /.wrapper-white -->

    <div class="container">
      <?
      if(empty($alert)) {
          $alert = $this->session->flashdata('alert');
      }
      if($alert) {
      ?>
      <div class="alert alert-<?=$alert['type']?>">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?=$alert['message']?>
      </div>
      <? } ?>
    </div>

    <?php echo $yield; ?>

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/assets/js/admin.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="assets/DataTables/media/js/dataTables.bootstrap.min.js"></script>
    <script src="/assets/DataTables/media/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
      $("#mainData").dataTable();
    </script>
  </body>
</html>
