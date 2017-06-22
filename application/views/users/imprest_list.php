<ul class="breadcrumb">
  <li><a href="/<?=$this->uri->segment(1)?>/companies/<?=$section?>/"><?php echo ucfirst($section); ?></a> <span class="divider">/</span></li>
  <li><a href="/<?=$this->uri->segment(1)?>/companies/<?=$section?>/<?=$user_account['company']['id']?>"><?php echo $user_account['company']['name']; ?></a> <span class="divider">/</span></li>
  <li class="active">Edit User</li>
</ul>
<div class="page-header">
    <h1><?=$user_account['fullname']?></h1>
</div>

<ul class="nav nav-tabs">
  <li>
    <a href="/<?=$this->uri->segment(1)?>/users/<?=$section?>/<?=$user_account['id']?>">User Details</a>
  </li>
  <li>
    <a href="/<?=$this->uri->segment(1)?>/users/<?=$section?>/<?=$user_account['id']?>/permissions">Permissions</a>
  </li>
  <li>
    <a href="/<?=$this->uri->segment(1)?>/users/<?=$section?>/<?=$user_account['id']?>/passwordreset">Reset Password</a>
  </li>
  <? if($user_account['staff'] == 0) { ?>
  <li>
    <a href="/<?=$this->uri->segment(1)?>/users/<?=$section?>/<?=$user_account['id']?>/part_lists">Part Lists</a>
  </li>
  <? } ?>
  <? if($user_account['staff'] == 1) { ?>
  <li>
    <a href="/<?=$this->uri->segment(1)?>/users/<?=$section?>/<?=$user_account['id']?>/dispatch_groups">Dispatch Groups</a>
  </li>
  <? } ?>
  <li class="active">
    <a href="/<?=$this->uri->segment(1)?>/users/<?=$section?>/<?=$user_account['id']?>/imprest_list">Imprest Stock List</a>
  </li>
</ul>

<form action="/<?=$this->uri->segment(1)?>/users/<?=$section?>/<?=$user_account['id']?>/imprest_list" class="form-horizontal" method="post" accept-charset="utf-8" enctype="multipart/form-data">
  <div class="row fluid">
    <div class="span12">
      <div class="control-group">
        <label class="control-label" for="account_number">Account Number</label>
        <div class="controls">
          <select id="account_number" name="account_number">
            <option value="0">Select</option>
            <?
            foreach($accounts as $account)
            {
              echo "<option value=\"" . $account['account_number'] . "\"";
              if($imprest_list['account_number'] == $account['account_number']) echo " selected";
              echo ">" . $account['account_number'] . "</option>";
            }
            ?>
          </select>
        </div>
      </div>

      <? foreach($accounts as $account) { ?>
      <div id="account-<?=$account['account_number']?>" class="control-group site_code<? if($imprest_list['account_number'] != $account['account_number']) { ?> hidden<? } ?>">
        <label class="control-label" for="site_code_<?=$account['account_number']?>">Site Code</label>
        <div class="controls">
          <select name="site_code_<?=$account['account_number']?>">
            <option value="0">Select</option>
            <?
            foreach($account['site_codes'] as $site_code)
            {
              echo "<option value=\"" . $site_code['site_code'] . "\"";
              if($imprest_list['account_number'] == $account['account_number'] && $imprest_list['site_code'] == $site_code['site_code']) echo " selected";
              echo ">" . $site_code['site_code'] . "</option>";
            }
            ?>
          </select>
        </div>
      </div>
      <? } ?>


    <script type="text/javascript">
    $(function() {
        $('#account_number').change(function(){
            $('.site_code').hide();
            $('.site_code').removeClass('hidden');
            $('#account-' + $(this).val()).show();
        });
    });
    </script>

      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </div>
    </div><!--/.span12-->
  </div><!--/.row-->
</form>

