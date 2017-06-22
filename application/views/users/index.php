<div class="page-header">
  <h1>Users</h1>
  <a href="/<?=$this->uri->segment(1)?>/users/add" class="btn btn-small">New User</a>
</div>

<table id="users" class="table table-striped table-hover table-clickrow table-bordered">
  <thead>
    <tr>
      <th>Username</th>
      <th>Full Name</th>
      <th>Company</th>
      <th>Email</th>
    </tr>
  </thead>
  <tbody>
  <? foreach($user_accounts as $user) { ?>
    <tr id="row_<?=$user['id']?>">
      <td><?=$user['username']?></td>
      <td><?=$user['fullname']?></td>
      <td><?=$user['company']['name']?></td>
      <td><?=$user['email']?></td>
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

    /*
    // datatables
    $('#parts-unlisted').dataTable( {
        "aoColumns": [
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null
        ],
        "sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
        "aLengthMenu": [
            [25, 50, 100, 200, -1],
            [25, 50, 100, 200, "All"]
        ], 
        "iDisplayLength" : -1,
        "sPaginationType": "bootstrap"
    });
    */

  $(".table-clickrow tbody")
    .on("click", "tr", function() {
      var n=$(this).attr('id').split("_");
      window.location = '/<?=$this->uri->segment(1)?>/users/'+ n[1];
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

  });
</script>
