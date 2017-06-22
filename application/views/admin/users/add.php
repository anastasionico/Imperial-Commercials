<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="page-header">
                <h1>Add New User</h1>
            </div>  
        </div>
    </div>
    
    <?php 
    echo validation_errors();
    echo form_open("/admin/users/add"); ?>
        <div class="row">        
            <div class="col-xs-12 col-md-6 form-group">
                <label for="fullname">Fullname</label>
                <?php 
                    echo form_input(array(
                        'name' => 'fullname',
                        'class' => 'form-control',
                        'placeholder' => 'Name Surname',
                    ));
                ?>
            </div>
            <div class="col-xs-12 col-md-6 form-group">
                <label for="email">Email</label>
                <?php 
                    echo form_input(array(
                        'name' => 'email',
                        'class' => 'form-control',
                        'placeholder' => 'name@email.co.uk',
                    ));
                ?>
            </div>
        </div>
        <div class="row">        
            <div class="col-xs-12 col-md-6 form-group">
                <label for="username">Username</label>
                <?php 
                    echo form_input(array(
                        'name' => 'username',
                        'class' => 'form-control',
                        'placeholder' => 'Username',
                    ));
                ?>
            </div>
            <div class="col-xs-12 col-md-6 form-group">
                <label for="password">Password</label>
                <?php 
                    echo form_password(array(
                        'name' => 'password',
                        'class' => 'form-control',
                        'placeholder' => 'Password (min 6 characters)',
                    ));
                ?>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
        </div>
    </form>
</div>




