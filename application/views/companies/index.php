<div class="page-header">
  <h1><?php echo ucfirst($section); ?></h1>
  <a href="/<?=$this->uri->segment(1)?>/companies/add" class="btn btn-small">Add</a>
</div>

<ul class="nav nav-tabs">
  <li<? if($section == 'customers') { ?> class="active"<? } ?>>
    <a href="/<?=$this->uri->segment(1)?>/companies/customers">Customers</a>
  </li>
  <li>
  <li<? if($section == 'suppliers') { ?> class="active"<? } ?>>
    <a href="/<?=$this->uri->segment(1)?>/companies/suppliers">Suppliers</a>
  </li>
  <? if(! empty($awaiting) ) { ?>
  <li<? if($section == 'awaiting') { ?> class="active"<? } ?>>
    <a href="/<?=$this->uri->segment(1)?>/companies/awaiting">Awaiting</a>
  </li>
  <? } ?>
</ul>


<table id="companies" class="table table-striped table-hover table-clickrow table-bordered">
  <thead>
    <tr>
      <th>Name</th>
      <th>Url</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
  <? foreach($$section as $company) { ?>
    <tr id="row_<?=$company['id']?>">
      <td><?=$company['name']?></td>
      <td><a href="/<?=$company['url']?>">/<?=$company['url']?></a></td>
      <td><? if($section != 'suppliers') { ?><a href="/<?=$this->uri->segment(1)?>/companies/delete/<?=$company['id']?>" class="btn btn-danger btn-small delete_button">Delete</a><? } ?></td>
    </tr>
  <? } ?>
  </tbody>
</table>

<script src="/assets/js/jquery.dataTables.min.js"></script>
<script src="/assets/js/jquery.dataTables.bootstrap.js"></script>
<script type="text/javascript" charset="utf-8">

  $.extend( $.fn.dataTableExt.oStdClasses, {
      "sWrapper": "dataTables_wrapper form-inline"
  });
  jQuery.extend( jQuery.fn.dataTableExt.oSort, {
      "date-uk-pre": function ( a ) {
          var ukDatea = a.split('/');
          return (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
      },
      "date-uk-asc": function ( a, b ) {
          return ((a < b) ? -1 : ((a > b) ? 1 : 0));
      },
      "date-uk-desc": function ( a, b ) {
          return ((a < b) ? 1 : ((a > b) ? -1 : 0));
      }
  });

  $(document).ready(function() {

    $(".table-clickrow tbody")
      .on("click", "tr", function() {
        var n=$(this).attr('id').split("_");
        window.location = '/<?=$this->uri->segment(1)?>/companies/<?=$section?>/'+ n[1];
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

    $(".delete_button").click(function( event ) {
      var confirm1 = confirm('Are you sure you wish to delete this customer?');
      if (confirm1) {
        // the link will continue to the delete page
      } else {
        event.stopPropagation();
        event.preventDefault();
      }
    });

  });
</script>
