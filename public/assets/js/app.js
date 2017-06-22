$( document ).ready(function() {

  function updateCount() {
    var fields = $( "#used-search" ).serializeArray();
    var url = '/used/search_count/' + encodeURIComponent($('input[name="type_url"]').val());
    jQuery.each( fields, function( i, field ) {
      if($.trim(field.value).length > 0) {
        switch(field.name) {
          case 'postcode':
            url += '/postcode/' + encodeURIComponent(field.value);
            break;
          case 'manufacturer':
            url += '/manufacturer/' + encodeURIComponent(field.value);
            break;
          case 'model':
            url += '/model/' + encodeURIComponent(field.value);
            break;
          case 'transmission':
            url += '/transmission/' + encodeURIComponent(field.value);
            break;
          case 'price-from':
            url += '/from/' + encodeURIComponent(field.value);
            break;
          case 'price-to':
            url += '/to/' + encodeURIComponent(field.value);
            break;
          case 'location':
            url += '/location/' + encodeURIComponent(field.value);
            break;
        }
      }
      
    });
    $.getJSON( url, function( data ) {
      $('#used-sidebar-count').html(data.count);
    });
  }
 
  $( "#used-search select" ).change( updateCount );

});
