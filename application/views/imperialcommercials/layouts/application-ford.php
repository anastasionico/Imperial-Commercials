<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><? if(! empty($seo['title']) ) { echo $seo['title']; } else { echo 'Imperial Commercials'; } ?></title>

    <? if(! empty($seo['canonical']) ) { ?><link rel="canonical" href="<?=$seo['canonical']?>"><? } ?>

    <!-- Bootstrap -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="/favicon.png" />

    <link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
    <link rel="stylesheet" href="/assets/css/bootstrap-image-gallery.min.css">


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

    <?php $this->load->view($domain['name'] . '/layouts/header-ford'); ?>

    <?
    if(empty($alert)) {
        $alert = $this->session->flashdata('alert');
    }
    if($alert) {
    ?>
    <div class="container">
      <div class="alert alert-<?=$alert['type']?>">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?=$alert['message']?>
      </div>
    </div>
    <? } ?>

    <?php echo $yield; ?>

    <?php $this->load->view($domain['name'] . '/layouts/footer-ford'); ?>

    <!-- Modal -->
    <div class="modal fade" id="modal-callme" tabindex="-1" role="dialog" aria-labelledby="modal-callme-label">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form method="POST" action="/form/callme" class="form-horizontal">
            <input type="hidden" name="request_page" value="<?=$_SERVER['REQUEST_URI']?>" />
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="modal-callme-label">Call Me Request</h4>
            </div>
            <div class="modal-body">

              <div class="row">
                <div class="col-xs-12">
                  <p>Leave your name, phone number and a convenient time, and somebody from our sales team will call you!</p>

                  <div class="form-group">
                    <label for="name_first" class="col-sm-2 control-label">First Name</label>
                    <div class="col-sm-10">
                      <input id="name_first" name="name_first" maxlength="255" size="14" placeholder="First Name" class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="name_last" class="col-sm-2 control-label">Last Name</label>
                    <div class="col-sm-10">
                      <input id="name_last" name="name_last" maxlength="255" size="14" placeholder="Last Name" class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="number" class="col-sm-2 control-label">Phone Number</label>
                    <div class="col-sm-10">
                      <input id="number" name="number" type="text" maxlength="255" size="11" class="form-control" placeholder="Phone Number">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="day" class="col-sm-2 control-label">Day</label>
                    <div class="col-sm-10">
                      <select class="form-control" id="day" name="day">
                        <option value="" selected="selected"></option>
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="time" class="col-sm-2 control-label">Time</label>
                    <div class="col-sm-10">
                      <select class="form-control" id="time" name="time">
                        <option value="" selected="selected"></option>
                        <option value="09:00 - 10:00">09:00 - 10:00</option>
                        <option value="10:00 - 11:00">10:00 - 11:00</option>
                        <option value="11:00 - 12:00">11:00 - 12:00</option>
                        <option value="12:00 - 13:00">12:00 - 13:00</option>
                        <option value="13:00 - 14:00">13:00 - 14:00</option>
                        <option value="14:00 - 15:00">14:00 - 15:00</option>
                        <option value="15:00 - 16:00">15:00 - 16:00</option>
                        <option value="16:00 - 17:00">16:00 - 17:00</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="message" class="col-sm-2 control-label">Message</label>
                    <div class="col-sm-10">
                      <textarea id="message" name="message" class="form-control" placeholder="Message"></textarea>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <label>
                        <input type="checkbox" name="informed" id="informed" checked="">
                        Keep me informed with updates.
                      </label>
                    </div>
                  </div>

                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-red">Call Me</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal Part Exchange-->
    <div class="modal fade" id="modal-part_exchange" tabindex="-1" role="dialog" aria-labelledby="modal-part_exchange-label">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form method="POST" action="/form/part_exchange" class="form-horizontal">
            <input type="hidden" name="request_page" value="<?=$_SERVER['REQUEST_URI']?>" />
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="modal-part_exchange-label">Part Exchange Enquiry</h4>
            </div>
            <div class="modal-body">

              <div class="row">
                <div class="col-xs-12">
                  <p>Leave your name, phone number and a convenient time, and somebody from our sales team will call you!</p>

                  <div class="form-group">
                    <label for="name_first" class="col-sm-2 control-label">First Name</label>
                    <div class="col-sm-10">
                      <input id="name_first" name="name_first" maxlength="255" size="14" placeholder="First Name" class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="name_last" class="col-sm-2 control-label">Last Name</label>
                    <div class="col-sm-10">
                      <input id="name_last" name="name_last" maxlength="255" size="14" placeholder="Last Name" class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="number" class="col-sm-2 control-label">Phone Number</label>
                    <div class="col-sm-10">
                      <input id="number" name="number" type="text" maxlength="255" size="11" class="form-control" placeholder="Phone Number">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="emailbox" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                      <input id="emailbox" name="email" type="text" class="form-control" placeholder="Email Address">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="reg" class="col-sm-2 control-label">Vehicle Registration</label>
                    <div class="col-sm-10">
                      <input id="reg" name="reg" type="text" maxlength="10" size="10" class="form-control" placeholder="REG NO">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="message" class="col-sm-2 control-label">Message</label>
                    <div class="col-sm-10">
                      <textarea id="message" name="message" class="form-control" placeholder="Message"></textarea>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <label>
                        <input type="checkbox" name="informed" id="informed" checked="">
                        Keep me informed with updates.
                      </label>
                    </div>
                  </div>

                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-red">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal-enquiry" tabindex="-1" role="dialog" aria-labelledby="modal-enquiry-label">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form method="POST" action="/form/enquiry" class="form-horizontal">
            <input type="hidden" name="request_page" value="<?=$_SERVER['REQUEST_URI']?>" />
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="modal-enquiry-label">Send an Enquiry</h4>
            </div>
            <div class="modal-body">

              <div class="row">
                <div class="col-xs-12">
                  <p>Leave your name, phone number and a convenient time, and somebody from our sales team will call you!</p>

                  <div class="form-group">
                    <label for="name_first" class="col-sm-2 control-label">First Name</label>
                    <div class="col-sm-10">
                      <input id="name_first" name="name_first" maxlength="255" size="14" placeholder="First Name" class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="name_last" class="col-sm-2 control-label">Last Name</label>
                    <div class="col-sm-10">
                      <input id="name_last" name="name_last" maxlength="255" size="14" placeholder="Last Name" class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="number" class="col-sm-2 control-label">Phone Number</label>
                    <div class="col-sm-10">
                      <input id="number" name="number" type="text" maxlength="255" size="11" class="form-control" placeholder="Phone Number">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="emailbox" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                      <input id="emailbox" name="email" type="text" class="form-control" placeholder="Email Address">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="message" class="col-sm-2 control-label">Message</label>
                    <div class="col-sm-10">
                      <textarea id="message" name="message" class="form-control" placeholder="Message"></textarea>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <label>
                        <input type="checkbox" name="informed" id="informed" checked="">
                        Keep me informed with updates.
                      </label>
                    </div>
                  </div>

                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-red">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal Test Drive -->
    <div class="modal fade" id="modal-test_drive" tabindex="-1" role="dialog" aria-labelledby="modal-test_drive-label">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form method="POST" action="/form/test_drive" class="form-horizontal">
            <input type="hidden" name="request_page" value="<?=$_SERVER['REQUEST_URI']?>" />
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="modal-test_drive-label">Test Drive Enquiry</h4>
            </div>
            <div class="modal-body">

              <div class="row">
                <div class="col-xs-12">
                  <p>Leave your name, phone number and a convenient time, and somebody from our sales team will call you!</p>

                  <div class="form-group">
                    <label for="name_first" class="col-sm-2 control-label">First Name</label>
                    <div class="col-sm-10">
                      <input id="name_first" name="name_first" maxlength="255" size="14" placeholder="First Name" class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="name_last" class="col-sm-2 control-label">Last Name</label>
                    <div class="col-sm-10">
                      <input id="name_last" name="name_last" maxlength="255" size="14" placeholder="Last Name" class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="number" class="col-sm-2 control-label">Phone Number</label>
                    <div class="col-sm-10">
                      <input id="number" name="number" type="text" maxlength="255" size="11" class="form-control" placeholder="Phone Number">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="emailbox" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                      <input id="emailbox" name="email" type="text" class="form-control" placeholder="Email Address">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="message" class="col-sm-2 control-label">Message</label>
                    <div class="col-sm-10">
                      <textarea id="message" name="message" class="form-control" placeholder="Message"></textarea>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <label>
                        <input type="checkbox" name="informed" id="informed" checked="">
                        Keep me informed with updates.
                      </label>
                    </div>
                  </div>

                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-red">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- The Bootstrap Image Gallery lightbox, should be a child element of the document body -->
    <div id="blueimp-gallery" class="blueimp-gallery" data-use-bootstrap-modal="false">
        <!-- The container for the modal slides -->
        <div class="slides"></div>
        <!-- Controls for the borderless lightbox -->
        <h3 class="title"></h3>
        <a class="prev">‹</a>
        <a class="next">›</a>
        <a class="close">×</a>
        <a class="play-pause"></a>
        <ol class="indicator"></ol>
        <!-- The modal dialog, which will be used to wrap the lightbox content -->
        <div class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body next"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left prev">
                            <i class="glyphicon glyphicon-chevron-left"></i>
                            Previous
                        </button>
                        <button type="button" class="btn btn-primary next">
                            Next
                            <i class="glyphicon glyphicon-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
    <script src="/assets/js/bootstrap-image-gallery.min.js"></script>
    <script src="/assets/js/jquery.lazyload.min.js"></script>
    <script src="/assets/js/app.js"></script>
    <script>
      $(function () {
        if($('[data-toggle="tooltip"]').length > 0) {
            $('[data-toggle="tooltip"]').tooltip()
        }
        $("img.lazy").lazyload({
           effect : "fadeIn"
        });
      })
    </script>
  </body>
</html>
