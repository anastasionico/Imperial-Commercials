<ul class="breadcrumb">
  <li><a href="/<?=$this->uri->segment(1)?>/companies/<?=$section?>/"><?php echo ucfirst($section); ?></a> <span class="divider">/</span></li>
  <li><a href="/<?=$this->uri->segment(1)?>/companies/<?=$section?>/<?=$user_account['company']['id']?>"><?php echo $user_account['company']['name']; ?></a> <span class="divider">/</span></li>
  <li class="active">Edit User</li>
</ul>
<div class="page-header">
    <h1><?=$user_account['fullname']?></h1>
</div>

<ul class="nav nav-tabs">
  <li class="active">
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
  <li>
    <a href="/<?=$this->uri->segment(1)?>/users/<?=$section?>/<?=$user_account['id']?>/imprest_list">Imprest Stock List</a>
  </li>
</ul>

<form action="/<?=$this->uri->segment(1)?>/users/<?=$section?>/<?=$user_account['id']?>" class="form-horizontal" method="post" accept-charset="utf-8" enctype="multipart/form-data">
  <div class="row fluid">
    <div class="span12">
      <div class="control-group">
        <label class="control-label" for="username">Username</label>
        <div class="controls">
          <input type="text" id="username" name="username" value="<?=$user_account['username']?>" readonly>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="fullname">Full Name</label>
        <div class="controls">
          <input type="text" id="fullname" name="fullname" value="<?=$user_account['fullname']?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="email">Email</label>
        <div class="controls">
          <input type="text" id="email" name="email" value="<?=$user_account['email']?>">
        </div>
      </div>
      <? if($user_account['staff'] == 0) { ?>
      <div class="control-group">
        <label class="control-label" for="group_id">Dispatch From</label>
        <div class="controls">
          <select name="group_id">
            <?
            foreach($dispatch_groups as $group)
            {
              echo "<option value=\"" . $group['id'] . "\"";
              if($dispatch_from == $group['id']) echo " selected";
              echo ">" . $group['name'] . "</option>";
            }
            ?>
          </select>
        </div>
      </div>
      <? } ?>
      <div class="control-group">
        <div class="controls">
          <label class="checkbox">
            <input name="part_option_m1" type="checkbox" value="1"<?if($user_account['part_option_m1'] == 1) { ?> checked<? } ?>>
            Part Order MB Option
          </label>
          <label class="checkbox">
            <input name="part_option_m2" type="checkbox" value="1"<?if($user_account['part_option_m2'] == 1) { ?> checked<? } ?>>
            Part Order DAF Option
          </label>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="discount_account_number">Discount Account Number</label>
        <div class="controls">
          <select name="discount_account_number">
            <option value="">Select</option>
            <?
            foreach($discount_account_numbers as $account)
            {
              echo "<option value=\"" . $account['account_number'] . "\"";
              if($user_account['discount_account_number'] == $account['account_number']) echo " selected";
              echo ">" . $account['account_number'] . "</option>";
            }
            ?>
          </select>
          <span class="help-block">Orders will be dispatched from the group selected.</span>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="address_name">Address Name</label>
        <div class="controls">
          <input type="text" id="address_name" name="address_name" placeholder="Address Name" value="<? if(! empty($address['name']) ) { echo $address['name']; } ?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="address_1">Address Line 1</label>
        <div class="controls">
          <input type="text" id="address_1" name="address_1" placeholder="Address Line 1" value="<? if(! empty($address['address_1']) ) { echo $address['address_1']; } ?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="address_2">Address Line 2</label>
        <div class="controls">
          <input type="text" id="address_2" name="address_2" placeholder="Address Line 2" value="<? if(! empty($address['address_2']) ) { echo $address['address_2']; } ?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="address_citytown">City/Town</label>
        <div class="controls">
          <input type="text" id="address_citytown" name="address_citytown" placeholder="City or Town" value="<? if(! empty($address['citytown']) ) { echo $address['citytown']; } ?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="address_county">County</label>
        <div class="controls">
          <input type="text" id="email" name="address_county" placeholder="County" value="<? if(! empty($address['county']) ) { echo $address['county']; } ?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="address_postcode">Postcode</label>
        <div class="controls">
          <input type="text" id="address_postcode" name="address_postcode" placeholder="Postcode" value="<? if(! empty($address['postcode']) ) { echo $address['postcode']; } ?>">
        </div>
      </div>
      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </div>
    </div><!--/.span12-->
  </div><!--/.row-->
</form>


