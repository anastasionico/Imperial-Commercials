<ul class="breadcrumb">
  <li><a href="/<?=$this->uri->segment(1)?>/part_lists/">Part Lists</a> <span class="divider">/</span></li>
  <li class="active">Edit Part List</li>
</ul>
<div class="page-header">
  <h1><?=$part_list['name']?></h1>
</div>
<form action="/<?=$this->uri->segment(1)?>/part_lists/<?=$part_list['id']?>" class="form-horizontal" method="post" accept-charset="utf-8" enctype="multipart/form-data">
  <div class="row fluid">
    <div class="span12">
      <div class="control-group">
        <label class="control-label" for="manufacturer_id">Manufacturer</label>
        <div class="controls">
          <select name="manufacturer_id">
            <? foreach($manufacturers as $manufacturer) { ?>
            <option value="<?=$manufacturer['id']?>"<? if($manufacturer['id'] == $part_list['manufacturer_id']) { ?> selected<? } ?>><?=$manufacturer['name']?></option>
            <? } ?>
          </select>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="name">Name</label>
        <div class="controls">
          <input type="text" id="name" name="name" placeholder="Name" value="<?=$part_list['name']?>">
        </div>
      </div>
      <div class="control-group">
        <div class="controls">
          <label class="checkbox">
            <input type="checkbox" name="imprest" value="1"<? if($part_list['imprest'] == 1) { ?> checked<? } ?>>
            Imprest Stock List
          </label>
        </div>
      </div>


          <table id="quote_table" class="table table-condensed margin-small">
            <thead>
              <tr>
                <th></th>
                <th>Part Number</th>
                <th>Description</th>
                <th>RRP</th>
                <th>Discount Code</th>
                <? if($part_list['imprest'] == 1) { ?><th>Imprest Qty</th><? } ?>
                <? if($part_list['imprest'] == 1) { ?><th>Bin Location</th><? } ?>
                <th> </th>
              </tr>
            </thead>
            <tbody>
              <? if(count($part_list['part_list_part']) > 0) {
                 $count = 1;
                 foreach($part_list['part_list_part'] as $part) { ?>
              <tr>
                <input type="hidden" name="id_<?=$count?>" value="<?=$part['id']?>">
                <td><img src="<?=$part['image']?>"><a href="/<?=$this->uri->segment(1)?>/part_lists/image/<?=$part_list['id']?>/<?=$part['id']?>" class="btn btn-mini">Add Picture</a></td>
                <td><input type="text" name="part_<?=$count?>" value="<?=$part['pnumber']?>" id="part_<?=$count?>" class="part input-medium"></td>
                <td><input type="text" name="description_<?=$count?>" value="<?=$part['description']?>" id="description_<?=$count?>"></td>
                <td><input type="text" name="price_<?=$count?>" value="<?=$part['price']?>" id="price_<?=$count?>" class="input-mini"></td>
                <td><input type="text" name="discount_code_<?=$count?>" value="<?=$part['discount_code']?>" id="discount_code_<?=$count?>" class="input-mini"></td>
                <? if($part_list['imprest'] == 1) { ?><td><input type="text" name="imprest_quantity_<?=$count?>" value="<?=$part['imprest_quantity']?>" id="quantity_<?=$count?>" onkeyup="isNumeric(this)" class="quantity input-mini"></td><? } ?>
                <? if($part_list['imprest'] == 1) { ?><td><input type="text" name="imprest_bin_location_<?=$count?>" value="<?=$part['imprest_bin_location']?>" id="imprest_bin_location_<?=$count?>" class="input-mini"></td><? } ?>
                <td><a href="#" class="btn btn-danger btn-small del"><i class="icon-remove icon-white"></i> Remove</a></td>
              </tr>
              <? $count++;
                 } ?>
              <? } else { ?>
              <tr>
                <td></td>
                <td><input type="text" name="part_1" value="" id="part_1" class="part input-medium"></td>
                <td><input type="text" name="description_1" value="" id="description_1"></td>
                <td><input type="text" name="price_1" value="" id="price_1" class="input-mini"></td>
                <td><input type="text" name="discount_code_1" value="" id="discount_code_1" class="input-mini"></td>
                <? if($part_list['imprest'] == 1) { ?><td><input type="text" name="imprest_quantity_1" value="1" id="quantity_1" onkeyup="isNumeric(this)" class="quantity input-mini"></td><? } ?>
                <? if($part_list['imprest'] == 1) { ?><td><input type="text" name="imprest_bin_location_1" id="imprest_bin_location_1" class="input-mini"></td><? } ?>
                <td><a href="#" class="btn btn-danger btn-small del"><i class="icon-remove icon-white"></i> Remove</a></td>
              </tr>
              <? } ?>
            </tbody>
          </table>

      <div class="control-group">
        <div class="controls">

          <button type="button" id="add_line" class="btn btn-small margin-small"><i class="icon-plus"></i> Add Another Part</button>
          <small>To add a picture to new parts, you need to fill in all the fields for the part and then press update.</small>

        </div>
      </div>
      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </div>
    </div>
  </div>
</form>



<script type="text/javascript" charset="utf-8">

	function validateForm(theForm) {
		var notvalid = 0;
		
		// check quote/order type is checked
		if(!$('input:radio[name=storder]:checked').val()) {
			alert('Please select either "QUOTE PRICES" or "ORDER"');
			return false;
		}
		
		// LIST FIELDS HERE theForm.[field name]
		if($('input:radio[name=storder]:checked').val() == "yes") {
			notvalid += validateEmpty(theForm.order_number);
		}
		if (notvalid) {
			alert('Please fill in the required fields.');
			return false;
		}
		else {
			return true;
		}
	}
	
	function isNumeric(elem, helperMsg){
		var numericExpression = /^[0-9]+$/;
	  if(elem.value.match(numericExpression)){
			return true;
	  }
	  else if(!elem.value){
			return true;
	  }
	  else {
			elem.value='';
			alert('Only numbers please!');
			elem.focus();
			return false;
	  }
	}
	function test(elem){
	    alert(elem.value);
	}

  var table_rows = <? if(count($part_list['part_list_part']) > 0) { echo count($part_list['part_list_part']); } else { echo 1; } ?>;
	$(document).ready(function() {

      function calc_total()
      {
        var total = 0;
        var warning = 0;
        $('td.line_price').each(function() {
          var line_total = $(this).html();
          if(line_total == "TBA")
          {
            warning = 1;
          }
          else
          {
            total += Number($(this).html());
          }
        });
        $("#total").html(total.toFixed(2));
        if(warning > 0)
        {
          $("#total-warning").html("Total does not include all items");
        }
        else
        {
          $("#total-warning").html(" ");
        }
      }

      function price_lookup_row(row, part_number, quantity)
      {
        /*
        $.post("../part_escalation/lookup", { p: part_number, q: quantity },
          function(data)
          {
            if(data == null)
            {
              data = { line_price: "TBA", price: "TBA", rrp: "TBA", title: "AWAIT QUOTE" }
            }
            // update the html
            $("#part_" + row).parents("tr").children("td.title").html(data.title);
            $("#part_" + row).parents("tr").children("td.rrp").html(data.rrp);
            $("#part_" + row).parents("tr").children("td.price").html(data.price);
            $("#part_" + row).parents("tr").children("td.line_price").html(data.line_price);
            calc_total();
          });
          */
      }

      function price_lookup()
      {
        $('input.part').each(function() {
          if($(this).val().length > 5)
          {
            var row_number = $(this).attr("id").split("_"),
              row_number = row_number[1]; // clear up row number (from element id)
            var quantity = parseInt($("#quantity_" + row_number).val());
            if(quantity >= 1)
            { 
              price_lookup_row(row_number, $(this).val(), quantity);
            }
          }
        });
      }

      // add a line button
			$("#add_line").click(function(event) {
				event.preventDefault();
				table_rows++; // add to table rows
<? if($part_list['imprest'] == 0) { ?>$("#quote_table").append("<tr><input type=\"hidden\" name=\"id_" + table_rows + "\" value=\"0\"><td></td><td><input type=\"text\" name=\"part_" + table_rows + "\" value=\"\" id=\"part_" + table_rows + "\" class=\"part input-medium\"></td><td><input type=\"text\" name=\"description_" + table_rows + "\" value=\"\" id=\"description_" + table_rows + "\"></td><td><input type=\"text\" name=\"price_" + table_rows + "\" value=\"\" id=\"price_" + table_rows + "\" class=\"input-mini\"></td><td><input type=\"text\" name=\"discount_code_" + table_rows + "\" value=\"\" id=\"discount_code_" + table_rows + "\" class=\"input-mini\"></td><td><a href=\"#\" class=\"btn btn-danger btn-small del\"><i class=\"icon-remove icon-white\"></i> Remove</a></td></tr>");<? } ?>
<? if($part_list['imprest'] == 1) { ?>$("#quote_table").append("<tr><input type=\"hidden\" name=\"id_" + table_rows + "\" value=\"0\"><td></td><td><input type=\"text\" name=\"part_" + table_rows + "\" value=\"\" id=\"part_" + table_rows + "\" class=\"part input-medium\"></td><td><input type=\"text\" name=\"description_" + table_rows + "\" value=\"\" id=\"description_" + table_rows + "\"></td><td><input type=\"text\" name=\"price_" + table_rows + "\" value=\"\" id=\"price_" + table_rows + "\" class=\"input-mini\"></td><td><input type=\"text\" name=\"discount_code_" + table_rows + "\" value=\"\" id=\"discount_code_" + table_rows + "\" class=\"input-mini\"></td><td><input type=\"text\" name=\"imprest_quantity_" + table_rows + "\" value=\"1\" id=\"imprest_quantity_" + table_rows + "\" onkeyup=\"isNumeric(this)\" class=\"quantity input-mini\"></td><td><input type=\"text\" name=\"imprest_bin_location_" + table_rows + "\" id=\"imprest_bin_location_" + table_rows + "\" class=\"input-mini\"></td><td><a href=\"#\" class=\"btn btn-danger btn-small del\"><i class=\"icon-remove icon-white\"></i> Remove</a></td></tr>");<? } ?>
      });
      // price lookup button
			$("#lookup").click(function(event) {
        event.preventDefault();
        price_lookup()
      });
      // delete button
      $(document).on("click", "a.del", function(){ 
				event.preventDefault();
        $(this).parents("tr").remove();
        calc_total();
      });
      // part number change, lookup pricing
      $(document).on("blur", ".part", function(){ 
        if($(this).val().length > 5)
        {
          var row_number = $(this).attr("id").split("_"),
              row_number = row_number[1]; // clear up row number (from element id)
          var quantity = parseInt($("#quantity_" + row_number).val());
          if(quantity >= 1)
          { 
            price_lookup_row(row_number, $(this).val(), quantity);
          }
        }
      });
      // qty change, lookup pricing
      $(document).on("blur", ".quantity", function(){ 
        var qty = parseInt($(this).val());
        if(qty > 0)
        {
          var row_number = $(this).attr("id").split("_"),
              row_number = row_number[1]; // clear up row number (from element id)
          var part_no = $(this).parents("tr").find("td input.part").val();
          if(part_no.length > 5)
          {
            price_lookup_row(row_number, part_no, qty);
          }
        }
      });
	  });

</script>


