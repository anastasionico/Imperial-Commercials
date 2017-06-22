<?php

/*    echo "<pre>";
    print_r($modelOfVehicle);
    echo "</pre>";
*/    
    $modelOfVehicleArray[0] = "Choose a model";
    foreach ($modelOfVehicle as $key => $value) {
        $modelOfVehicleArray[$value['id']] = $value['model_text'];
        /*
        echo "<pre>"; 
        print_r($value['manufacturer']); 
        print_r($value['model_text']); 
        echo "</pre>";
        */
    }
    
?>
<div class="container">
    <div class="row">
        <form action="/admin/vehicles/add_manual" enctype="multipart/form-data" method="post" accept-charset="utf-8">
            <div class="col-xs-12">
                <div class="page-header">
                    <h1>Add New Vehicle</h1>
                </div>  
            </div>
    </div>
    <div class="row">        
      <div class="col-xs-12">

        <?php echo partial('bscheckbox', array(
            'name' => 'new',
            'label' => 'This is a New Vehicle',
        )); ?>

        <?php echo partial('bscheckbox', array(
        'label' => 'Active Status',
        'checked' => TRUE,
        )); ?>

        <?php echo partial('bscheckbox', array(
        'label' => 'List on autotrader',
        'checked' => TRUE,
        )); ?>

        <div class="form-group">
            <label for="autotrader_attention_grabbers">Autotrader Attention Grabbers description</label>
            <input type="text" name="autotrader_attention_grabbers" maxlength="30" class="form-control" placeholder="max:30 characters">
        </div>
        
        <?php echo partial('bscheckbox', array(
        'label' => 'No VAT',
        )); ?>

        <?php echo partial('bscheckbox', array(
        'label' => 'Sold',
        )); ?>

        <div class="row">
          <div class="col-xs-2">
            <?php echo partial('bsinput', array(
            'label' => 'Priority',
            'value' => 1,
            )); ?>
          </div>
        </div>

        <?php
        echo partial('bsdropdown', array(
            'label' => 'Location *',
            'options' => $locations,
        )); ?>

        <?php
        echo partial('bsdropdown', array(
            'label' => 'Type *',
            'options' => $types,
        )); ?>

      </div>
      <div class="col-xs-12 col-md-6">

        <div id="vrmlookup" class="well">
          <div class="form-group">
            <label for="reg_no" class="control-label">Reg No</label>
            <input type="text" name="reg_no" id="reg_no" class="form-control noEnterSubmit">
          </div>
          <a href="#" id="vrmButton" class="btn btn-primary">Lookup</a>
        </div>

        <?php
        echo partial('bsdropdown', array(
            'label' => 'Manufacturer *',
            'options' => $manufacturers,
            'class' => 'cap_manufacturer',
        )); ?>

        <?php

        ?>

        <label>Model *</label>
        <?php
            if($userManager == 1){
        ?>
                <div class="input-group">
                    <?php
                    echo form_dropdown('model_uid', $modelOfVehicleArray, 0,'class="form-control oldModelDiv " id="oldModelDiv"' );
                    ?>
                    <div class="input-group-btn">
                        <button class="btn btn-info" type="button" onclick="newModel()">
                            <i class="glyphicon glyphicon-plus"></i>
                        </button>
                    </div>
                </div>
        <?php        
            }else{
        ?>
                <?php
                    echo form_dropdown('model_uid', $modelOfVehicleArray, 0,'class="form-control oldModelDiv " id="oldModelDiv"' );
                ?>
        <?php        
            }
        ?>
        <br>



        
        <div id='newModelDiv' style='display: none'>
            
            <label>New Model</label>
            <input type="text" name='newModelName' placeholder="Add a new model" class="form-control" >
            <br>
        </div>
        
        

        <?php echo partial('bsinput', array(
        'label' => 'Derivative',
        )); ?>

        <?php echo partial('bsinput', array(
        'label' => 'Model Year',
        )); ?>

        <?php echo partial('bsinput', array(
        'label' => 'Engine Size *',
        'placeholder' => '4 digits format, no letters',
        )); ?>
        <?php echo partial('bsinput', array(
        'label' => 'Load Width',
        )); ?>
        <?php echo partial('bsinput', array(
        'label' => 'Load Height',
        )); ?>
        <?php echo partial('bsinput', array(
        'label' => 'Load Length',
        )); ?>
        <?php echo partial('bsinput', array(
        'label' => 'Load Seats',
        )); ?>
        <?php echo partial('bsinput', array(
        'label' => 'Load Weight',
        )); ?>

    </div>
    <div class="col-xs-12 col-md-6">

        <?php echo partial('bsinput', array(
        'label' => 'Fuel Type',
        )); ?>

        <?php echo partial('bsinput', array(
        'label' => 'Transmission',
        )); ?>

        <?php echo partial('bsinput', array(
        'label' => 'Number of Seats',
        )); ?>

        <?php
        echo partial('bsdropdown', array(
            'label' => 'Body Type',
            'options' => $body_types,
        )); ?>

        <?php echo partial('bsinput', array(
        'label' => 'Colour',
        )); ?>

        <?php echo partial('bsinput', array(
        'label' => 'Registered',
        )); ?>

        <?php echo partial('bsinput', array(
        'label' => 'Mileage',
        )); ?>

        <?php echo partial('bsinput', array(
        'label' => 'Previous Owners',
        )); ?>

        <?php echo partial('bsinput', array(
        'label' => 'Bullet Point 1',
        )); ?>
        <?php echo partial('bsinput', array(
        'label' => 'Bullet Point 2',
        )); ?>
        <?php echo partial('bsinput', array(
        'label' => 'Bullet Point 3',
        )); ?>
        <?php echo partial('bsinput', array(
        'label' => 'Bullet Point 4',
        )); ?>
    </div>
    </div>
    <div class="row">
        <div>
            <div class="col-xs-12 col-md-6">
                <h2>Finance</h2>
                <?php echo partial('bsinput', array(
                'label' => 'Price',
                )); ?>
                <p class="help-block">Must be a number. For 'POA', set the price to 0.</p>


                <?php echo partial('bsinput', array(
                'label' => 'Price Month',
                )); ?>
            </div>
            <div class="col-xs-12 col-md-6">
                <br><br><br>
                <?php echo partial('bsinput', array(
                'label' => 'Price Month Term',
                )); ?>

                <?php
                echo partial('bsdropdown', array(
                    'label' => 'Finance Type',
                    'options' => $finance_types,
                )); ?>

                <?php echo partial('bsinput', array(
                'label' => 'Upfront Months',
                )); ?>    
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <h2>Lead Image *</h2>
            <input type="file" id="userfile" name="userfile">
        </div>
        <div class="col-xs-12 col-md-6">
            <h2>Video</h2>
            <?php echo partial('bsinput', array(
                'label' => 'Youtube url',
                'name' => 'video',
            )); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <button type="submit" class="btn btn-primary">Add</button>
        </div>
    </div>
    
    </form>
  </div><!-- /.row -->
</div><!-- /.container -->
<script type="text/javascript">
    function newModel(){
        document.getElementById('newModelDiv').style.display = "block";
        document.getElementById('oldModelDiv').style.opacity = "0.2";
    }
    
</script>