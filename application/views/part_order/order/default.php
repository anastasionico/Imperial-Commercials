<ul class="breadcrumb">
  <li><a href="/<?=$this->uri->segment(1)?>/part_order/">Orders</a> <span class="divider">/</span></li>
  <li><a href="/<?=$this->uri->segment(1)?>/part_order/<?=$site['id']?>"><?=$site['company_name']?> <?=$site['fullname']?></a> <span class="divider">/</span></li>
  <li class="active">Order</li>
</ul>
<div class="page-header">
  <h1>Invoice Detail</h1>
</div>
<div class="invoice">
  <div class="row-fluid">
    <div class="span6">
      <div class="block">
        <div class="lbl">Billing Name &amp; Address</div>
        <div>
          <?=$order['invoiceaddress']['name']?><br>
          <?=$order['invoiceaddress']['address_1']?><br>
          <?=$order['invoiceaddress']['address_2']?><br>
          <?=$order['invoiceaddress']['citytown']?><br>
          <?=$order['invoiceaddress']['county']?><br>
          <?=$order['invoiceaddress']['postcode']?>
        </div>
      </div>
      <div class="clearfix"></div>
    </div> <!--// .span6 -->
    <div class="span6">
      <div class="block">
        <div class="lbl">Delivery Name &amp; Address</div>
        <div>
          <?=$order['deliveryaddress']['name']?><br>
          <?=$order['deliveryaddress']['address_1']?><br>
          <?=$order['deliveryaddress']['address_2']?><br>
          <?=$order['deliveryaddress']['citytown']?><br>
          <?=$order['deliveryaddress']['county']?><br>
          <?=$order['deliveryaddress']['postcode']?>
        </div>
      </div>
      <div class="clearfix"></div>
    </div> <!--// .span6 -->
  </div> <!--// .row-fluid -->
  <div class="row-fluid">
    <div class="span12">
      <? if($order['wipno']) { ?>
      <div class="block">
        <div class="lbl">WIP NO.</div>
        <div><?=$order['wipno']?></div>
      </div>
      <? } ?>
      <? if($order['order_no']) { ?>
      <div class="block">
        <div class="lbl">ORDER NO.</div>
        <div><?=$order['order_no']?></div>
      </div>
      <? } ?>
      <? if($order['chassis_number']) { ?>
      <div class="block">
        <div class="lbl">Chassis Number</div>
        <div><?=$order['chassis_number']?></div>
      </div>
      <? } ?>
      <? if($order['reg_no']) { ?>
      <div class="block">
        <div class="lbl">REG NO.</div>
        <div><?=$order['reg_no']?></div>
      </div>
      <? } ?>
      <div class="clearfix"></div>
    </div> <!--// .span6 -->
  </div> <!--// .row-fluid -->

  <hr>

  <? if($order['quote_image']) { ?>
  <div class="row-fluid">
    <div class="span12">
      <div class="block">
        <div class="lbl">Attachment</div>
        <div><a href="http://www.orwelldirect.co.uk/assets/doc/parts/<?=$order['quote_image']?>" target="_blank">VIEW ATTACHMENT</a></div>
      </div>
    </div> <!--// .span6 -->
  </div> <!--// .row-fluid -->
  <? } ?>

  <? 
  // quote
  if(($order['status'] == 1) || (($order['storder'] == 1) && ($order['status'] == 3))) { ?>
  <div class="row-fluid">
    <div class="span12">
      <div class="block">
        <div class="lbl">FOR VEHICLE: <?=$order['quote_vehicle']?></div>
        <div><?=nl2br($order['quote_text'])?></div>
      </div>
    </div> <!--// .span6 -->
  </div> <!--// .row-fluid -->

  <div class="row-fluid">
    <div class="span12">
      <form id="submit-quote" action="<?='/' . $this->uri->segment(1) . '/part_order/' . $this->uri->segment(3) . '/' . $this->uri->segment(4) . '/submit_quote' ?>" method="POST" accept-charset="utf-8">
        <? if(count($order['items']) > 0) { ?>
          <input type="hidden" name="line_number" id="line_number" value="<?=count($order['items'])?>">
        <? } else { ?>
          <input type="hidden" name="line_number" id="line_number" value="1">
        <? } ?>
        <div id="part_nos" class="iline">
          <b>PART NO.</b>
          <?
          if(count($order['items']) > 0)
          {
            $i = 1;
            foreach($order['items'] as $item)
            { ?>
            <div class="blck"><input type="text" name="partno_<?=$i?>" value="<?=$item['quote_pnumber']?>" class="pquote input-medium"></div>
            <?
            $i++;
            }
          }
          else { ?>
          <div class="blck"><input type="text" name="partno_1" class="pquote input-medium"></div>
          <? } ?>
        </div>
        <div id="part_descriptions" class="iline">
          <b>DESCRIPTION</b>
          <?
          if(count($order['items']) > 0) {
            $i = 1;
            foreach($order['items'] as $item)
            { ?>
            <div class="blck"><input type="text" name="description_<?=$i?>" value="<?=$item['quote_description']?>"></div>
            <?
            $i++;
            }
          }
          else { ?>
          <div class="blck"><input type="text" name="description_1" value=""></div>
          <? } ?>
        </div>
        <div id="part_prices" class="iline">
          <b>PRICE</b>
          <?
          if(count($order['items']) > 0)
          {
            $i = 1;
            foreach($order['items'] as $item)
            { ?>
            <div class="blck"><input type="text" name="price_<?=$i?>" value="<?=$item['price']?>" class="qprice input-mini"></div>
            <?
            $i++;
            }
          }
          else { ?>
            <div class="blck"><input type="text" name="price_1" class="qprice input-mini"></div>
          <? } ?>
        </div>
        <div id="part_quantitys" class="iline">
          <b>QUANTITY</b>
          <?
          if(count($order['items']) > 0)
          {
            $i = 1;
            foreach($order['items'] as $item)
            { ?>
            <div class="blck"><input type="text" name="quantity_<?=$i?>" value="<?=$item['quantity']?>" class="qqty input-mini"></div>
            <?
            $i++;
            }
          }
          else { ?>
            <div class="blck"><input type="text" name="quantity_1" class="qqty input-mini"></div>
          <? } ?>
        </div>
        <div id="part_stocks" class="iline">
          <b>STOCK</b>
          <?
          if(count($order['items']) > 0)
          {
            $i = 1;
            foreach($order['items'] as $item)
            { ?>
            <div class="blck"><input type="text" name="stock_<?=$i?>"></div>
            <?
            $i++;
            }
          }
          else { ?>
            <div class="blck"><input type="text" name="stock_1"></div>
          <? } ?>
        </div>
        <div class="iline">
          <br /><button type="button" onclick="add_input_line()" class="btn">ADD PART</button>
        </div>
        <div class="clearfix"></div>
        <div class="well">
          <? if($order['storder'] == 1 && $order['status'] == 3) { ?>
            <label for="wipno" class="inline">WIP NO.</label>
            <input type="text" name="wipno" value="" id="wipno" class="input-small inline">
            <input type="submit" name="submit" value="Dispatch" class="btn btn-primary inline">
          <? } else { ?>
            <input type="submit" name="submit" value="Send Quote" class="btn">
          <? } ?>
        </div>
      </form>
    </div> <!--// .span6 -->
  </div> <!--// .row-fluid -->
  <? }
     else { ?>
    <div class="row-fluid">
      <div class="span12">
        <table class="table table-striped table-hover table-bordered">
          <tr>
            <th colspan="2">DESCRIPTION OF GOODS.</th>
            <th>QTY.</th>
            <th>UNIT PRICE</th>
            <th class="price">NET TOTAL</th>
          </tr>
          <?
          $total = 0;
          foreach($order['items'] as $item) 
          {
            $linetotal = $item['price'] * $item['quantity'];
            $total += $linetotal;
            $linetotal = number_format($linetotal, 2, '.', '');
            $total = number_format($total, 2, '.', '');

            if($order['quote'] == 1)
            { ?>
            <tr>
              <td><?=$item['quote_pnumber']?></td>
              <td><?=$item['quote_description']?></td>
              <td><?=$item['quantity']?></td>
              <td><?=$item['price']?></td>
              <td class="price"><?=$linetotal?></td>
            </tr>
            <? } else { ?>
            <tr>
              <td>
                <? if(isset($item['title'])) { echo $item['title']; } ?>
                <? if(isset($item['pnumber'])) { echo $item['pnumber']; } ?>
              </td>
              <td><?=$item['description']?></td>
              <td><?=$item['quantity']?></td>
              <td><?=$item['price']?></td>
              <td class="price"><?=$linetotal?></td>
            </tr>
            <?
            }
          } ?>
        </table>
      </div> <!--// .span6 -->
    </div> <!--// .row-fluid -->

    <div class="row-fluid">
      <div class="span3 offset9">
        <table class="table">
          <tr>
            <td class="price">TOTAL:</td>
            <td>£</td>
            <td class="price"><?=$total?></td>
          </tr>
        </table>
      </div> <!--// .span6 -->
    </div> <!--// .row-fluid -->

    <? if($order['quote'] == 1) { ?>
      <div class="row-fluid">
        <div class="span12">
          <div class="block">
            <div class="lbl">FOR VEHICLE: <?=$order['quote_vehicle']?></div>
            <div><?=nl2br($order['quote_text'])?></div>
          </div>
        </div> <!--// .span6 -->
      </div> <!--// .row-fluid -->
    <? } ?>

  <? } ?>

  <? if($order['status'] == "3" && $order['storder'] == 0) { ?>
    <div class="well">
      <form action="<?='/' . $this->uri->segment(1) . '/part_order/' . $this->uri->segment(3) . '/' . $this->uri->segment(4) . '/dispatch' ?>" method="POST" accept-charset="utf-8">
        <label for="wipno">WIP NO.</label><input type="text" name="wipno" value="" id="wipno" class="input-small inline">
        <input type="submit" name="dispatch" value="Dispatch" class="btn btn-primary inline">
      </form>
    </div>
  <? } ?>

  <div class="page-header">
    <h1>Notes</h1>
  </div>
  <? if(empty($order['notes'])) { ?>
  <p><i>There are currently no notes.</i></p>
  <? } ?>
  <? if($order['notes']) { ?>
    <? foreach($order['notes'] as $note) { ?>
      <div class="row-fluid">
        <div class="span3">
          <?=$note['user_fullname']?><br />
          <?=date("d/m/y H:i", strtotime($note['created_at']))?>
        </div>
        <div class="span9">
          <?=nl2br($note['message'])?>
        </div>
      </div>
      <hr>
    <? } ?>
  <? } ?>

  <form action="<?='/' . $this->uri->segment(1) . '/part_order/' . $this->uri->segment(3) . '/' . $this->uri->segment(4) . '/add_note' ?>" method="POST" accept-charset="utf-8">
    <?=form_label('Respond:', 'note')?>
    <?=form_textarea(array(
      'name' => 'note',
      'class' => 'span5',
      'rows' => '5'
    ))?>
    <div class="form-actions">
      <input type="submit" name="submit" value="Add Note" class="btn">
    </div>
  </form>

</div>
<script type="text/javascript" charset="utf-8">
  function add_input_line()
  {
    var line_counter = parseInt($("#line_number").val());
        line_counter++;
    var start = "<div class='blck'>", end = "</div>";

    $('#part_nos').append(start + '<input type=\'text\' name=\'partno_'+line_counter+'\' class=\'pquote input-medium\' />' + end);
    $('#part_descriptions').append(start + '<input type=\'text\' name=\'description_'+line_counter+'\' />' + end);
    $('#part_prices').append(start + '<input type=\'text\' name=\'price_'+line_counter+'\' class=\'qprice input-mini\' />' + end);
    $('#part_quantitys').append(start + '<input type=\'text\' name=\'quantity_'+line_counter+'\' class=\'qqty input-mini\' />' + end);
    $('#part_stocks').append(start + '<input type=\'text\' name=\'stock_'+line_counter+'\' />' + end);
    $("#line_number").val(line_counter);
  }

  $(document).ready(function() {

    $('#submit-quote').on('keypress', 'input', function(e){
      if ( e.which == 13 ) // Enter key = keycode 13
      {
        return false;
      }
    });


  });

</script>
