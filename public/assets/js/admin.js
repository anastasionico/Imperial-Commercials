function VRMLookup() {
  var reg = $('#reg_no').val().replace(/\s+/g, '');
  
  $.ajax({
    url: "/admin/vehicle_lookup/" + reg,
  })
  .done(function( data ) {

    $('#manufacturer').val(data.MANUFACTURER_CODE);
    $('#model').val(data.MODEL);
    $('#derivative').val(data.DERIVATIVE);
    $('#model_year').val(data.PLATE_YEAR);
    $('#engine_size').val(data.engine);
    $('#number_of_seats').val(data.seats);
    $('#fuel_type').val(data.FUELTYPE);
    $('#colour').val(data.colour);
    $('#transmission').val(data.TRANSMISSION);
    $('#registered').val(data.PLATE_YEAR);

  });
}
function cap_load_model(selected_manufacturer) {

  $.getJSON('/admin/ajax/models/' + selected_manufacturer, function (data) {

    if (data.length > 0) {

      $('#model')
        .find('option')
        .remove()
        .end()
        .append('<option value="">Select</option>')
      ;

      $.each(data, function (index, value) {
        $('#model').append('<option value="' + value.code + '">' + value.name + '</option>');
      });

      $('#model').val('');

    }

  }).fail(function (jqxhr, textStatus, error){   });
}

function cap_load_derivative(selected_model) {

  $.getJSON('/admin/ajax/derivatives/' + selected_model, function (data) {

    if (data.length > 0) {

      $('#derivative')
        .find('option')
        .remove()
        .end()
        .append('<option value="">Select</option>')
      ;

      $.each(data, function (index, value) {
        $('#derivative').append('<option value="' + value.id + '">' + value.name + '</option>');
      });

      $('#derivative').val('');

    }

  }).fail(function (jqxhr, textStatus, error){   });
}

function cap_load_details(selected_derivative) {

  $.getJSON('/admin/ajax/technical_data/' + selected_derivative, function (data) {

    if (data.length > 0) {
      $.each(data, function (index, value) {
        switch (value.code) {
          case '60':
            $('#fuel_type').val(value.value);
            break;
          case '77':
            $('#transmission').val(value.value);
            break;
          case '47':
            $('#number_of_seats').val(value.value);
            break;
          case '20':
            $('#engine_size').val(value.value);
            break;
          case '37':
            $('#load_width').val(value.value);
            break;
          case '38':
            $('#load_height').val(value.value);
            break;
          case '36':
            $('#load_length').val(value.value);
            break;
          case '36':
            $('#load_length').val(value.value);
            break;
        }
        $('#derivative').append('<option value="' + value.id + '">' + value.name + '</option>');
      });
    }

  }).fail(function (jqxhr, textStatus, error){   });
}

$(document).ready(function () {

  if($(".table-clickrow").length > 0) {
    $(".table-clickrow tbody")
      .on("click", "tr", function() {
        var n=$(this).attr('id').split("_");
        window.location = '/admin/vehicles/edit/'+ n[1];
      })
    .on("mouseover", "tr", function() {
      $(this)
      .addClass("over")
      .css('cursor', 'pointer');
    })
    .on("mouseout", "tr", function() {
      $(this)
      .removeClass("over")
      .css('cursor', 'auto');
    });
  }

  if($(".cap_manufacturer").length > 0) {

    // if manufacturer is changed, load the models
    $('.cap_manufacturer').change(function () {
        cap_load_model($(this).val());
    })
    // if the model is changed, load the derivatives
    $('.cap_model').change(function () {
        cap_load_derivative($(this).val());
    })
    // if the derivative is changed, load the other details
    $('.cap_derivative').change(function () {
        cap_load_details($(this).val());
    })

  }



});



$(document).ready(function () {

  if($("#vrmlookup").length > 0) {
    $('#vrmButton').on('click', VRMLookup);
    $('.noEnterSubmit').bind('keypress', function(e) {
      if(e.which == 13) {
        $('#vrmButton').click();
        e.preventDefault();
      }
    });
  }

});
