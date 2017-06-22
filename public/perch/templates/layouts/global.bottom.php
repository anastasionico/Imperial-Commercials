    <div id="footer-scrape">

      <div class="container hidden-xs">
        <div class="nav-coa nav-coa-blue">
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
          <div class="col">
            <a href="/locations">
              <span class="icon icon-location-light" aria-hidden="true"></span> Locations
            </a>
          </div>
        </div>
      </div>

      <div id="footer">
        <div class="container margin-bottom">
          <div class="row">
            <div class="col-sm-6 col-md-9">
              <div class="menu-container hidden-xs">
                <?php perch_content('Footer Menu'); ?>
              </div>
              <div class="clearfix"></div>
              <div class="legal-wording">
                <?php perch_content('Legal Wording'); ?>
              </div>
            </div><!-- /.col -->
            <div class="col-xs-12 col-sm-6 col-md-3">
              <div class="copyright">
                <img src="/assets/img/footer.png" class="img-responsive">
                <div class="spiel">
                  <p>&copy; Copyright 1996-2016 Imperial Commercials Ltd - Registered Office: Imperial House,
                  14/15 High Street, High Wycombe, HP11 2BE, UK.</p>
                  <p>Registered Number: 00653665  Authorised and regulated by the Financial Conduct Authority</p>
                </div>
              </div>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container -->
      </div><!-- /#footer -->

    </div><!--/.footer-scrape-->

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

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/assets/js/bootstrap.min.js"></script>
    <script>
      $(function () {
        $('[data-toggle="tooltip"]').tooltip()
      })
    </script>
  </body>
</html>
