<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="page-header">
                <h1>Edit User</h1>
            </div>  
        </div>
    </div>
    
    <?php 
    echo validation_errors();
    echo form_open("/admin/users/edit/$user[id]"); ?>
        <div class="row">        
            <div class="col-xs-12 col-md-6 form-group">
                <label for="fullname">Fullname</label>
                <?php 
                    echo form_input(array(
                        'name' => 'fullname',
                        'class' => 'form-control',
                        'value' => $user['fullname'],
                    ));
                ?>
            </div>
            <div class="col-xs-12 col-md-6 form-group">
                <label for="email">Email</label>
                <?php 
                    echo form_input(array(
                        'name' => 'email',
                        'class' => 'form-control',
                        'value' => $user['email'],
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
                        'value' => $user['username'],
                    ));
                ?>
            </div>
            <div class="col-xs-12 col-md-6 form-group">
                <label for="password">Password</label>
                <?php 
                    echo form_password(array(
                        'name' => 'password',
                        'class' => 'form-control',
                        'value' => $user['password'],
                    ));
                ?>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-primary">Edit</button>
            </div>
        </div>
    </form>
</div>




