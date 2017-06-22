<?/*
<ul class="breadcrumb">
  <li><a href="/<?=$this->uri->segment(1)?>/users/">User Management</a> <span class="divider">/</span></li>
  <li class="active">Add User</li>
</ul>
 */?>
<div class="page-header">
  <h1>Add User</h1>
</div>
<form action="/<?=$this->uri->segment(1)?>/users/add/<?=$default_company_id?>/<?=$section?>" class="form-horizontal" method="post" accept-charset="utf-8" enctype="multipart/form-data">
  <div class="row fluid">
    <div class="span12">
      <div class="control-group">
        <label class="control-label" for="account_type">Account type</label>
        <div class="controls">
          <select name="account_type">
              <option value="customer">Customer</option>
              <option value="staff"<? if($section == 'suppliers'){ ?> selected<? } ?>>Supplier</option>
          </select>
          <span class="help-block">Customer accounts are for ordering parts. Supplier accounts are for dispatching part orders.</span>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="group_id">Dispatch From</label>
        <div class="controls">
          <select name="group_id">
            <?
            foreach($dispatch_groups as $group)
            {
              echo "<option value=\"" . $group['id'] . "\"";
              echo ">" . $group['name'] . "</option>";
            }
            ?>
          </select>
          <span class="help-block">Required for customer accounts only. Orders will be dispatched from the group selected.</span>
        </div>
      </div>
      <div class="control-group">
        <div class="controls">
          <label class="checkbox">
            <input name="part_option_m1" type="checkbox" value="1">
            Part Order MB Option
          </label>
          <label class="checkbox">
            <input name="part_option_m2" type="checkbox" value="1">
            Part Order DAF Option
          </label>
          <span class="help-block">Required for customer accounts only.</span>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="company_id">Company</label>
        <div class="controls">
          <select name="company_id">
            <?
            foreach($companys as $company)
            {
              echo "<option value=\"" . $company['id'] . "\"";
              if($company['id'] == $default_company_id) echo " selected";
              echo ">" . $company['name'] . "</option>";
            }
            ?>
          </select>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="username">Username</label>
        <div class="controls">
          <input type="text" id="username" name="username" placeholder="Username" value="">
          <span class="help-block">Must be unique, usually first name and last name with no spaces.</span>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="password">Password</label>
        <div class="controls">
          <input name="password" type="password" placeholder="Password">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="fullname">Full Name</label>
        <div class="controls">
          <input type="text" id="fullname" name="fullname" placeholder="Full Name" value="">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="email">Email</label>
        <div class="controls">
          <input type="text" id="email" name="email" placeholder="Email Address" value="">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="address_name">Address Name</label>
        <div class="controls">
          <input type="text" id="address_name" name="address_name" placeholder="Address Name" value="">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="address_1">Address Line 1</label>
        <div class="controls">
          <input type="text" id="address_1" name="address_1" placeholder="Address Line 1" value="">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="address_2">Address Line 2</label>
        <div class="controls">
          <input type="text" id="address_2" name="address_2" placeholder="Address Line 2" value="">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="address_citytown">City/Town</label>
        <div class="controls">
          <input type="text" id="address_citytown" name="address_citytown" placeholder="City or Town" value="">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="address_county">County</label>
        <div class="controls">
          <input type="text" id="email" name="address_county" placeholder="County" value="">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="address_postcode">Postcode</label>
        <div class="controls">
          <input type="text" id="address_postcode" name="address_postcode" placeholder="Postcode" value="">
        </div>
      </div>

      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-primary">Add</button>
          <button type="submit" class="btn">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</form>

