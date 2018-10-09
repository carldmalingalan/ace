<?php
require_once "../../support/config.php";
if(!AllowUser("Admin")){
    redirect("../index.php");
    die;
}
$active_dir ="accounts";
$active_sub_dir = "account_active";
$dir = "../../";
$color = "blue";
require_once "../template-admin/header.php";
require_once "../template-admin/sidebar.php";
RunAlert(); 
?>
<section class="content">
    <div class="container-fluid">
    <?php  ?>
        <div class="block-header">
        <h2>ACTIVE ACCOUNTS</h2>
        </div>
        <!-- All Account -->
        <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                    <div class="header">
                    <label for="addUser" class="p-r-20">Add User</label>
                        <button id="addUser" data-toggle="modal" data-target="#addUserModal" class="btn bg-<?php echo $color; ?> btn-circle-lg waves-effect waves-circle waves-float" type="button">
                            <i class="material-icons">add</i>
                        </button>
                    </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover" id="dataTable" style="width: 100%">
                                    <thead class="bg-<?php echo $color; ?>">
                                        <tr>
                                            <th>User Id</th>
                                            <th>Username</th>
                                            <th>Full Name</th>                                    
                                            <th>Account Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- ## End of dataTable -->
        <div class="modal fade" id="userModal" tabindex="-1">
            <div class="modal-dialog body" role="document">
                <form class="modal-form" id="custom_validate" action="save_user.php" method="POST">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">User Info</h4>    
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="class" value="edit">
                    </div>
                    <div class="row modal-body">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <b>Username</b>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" class="form-control focused" name="username" id="username" disabled>
                            </div>
                            <label for="username" class="error"></label>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <b>First Name</b>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" class="form-control focused" name="f_name" id="f_name" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <b>Middle Name</b>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" class="form-control focused" name="m_name" id="m_name" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <b>Last Name</b>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" class="form-control focused"  name="l_name" id="l_name" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <b>Birthday</b>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" class="form-control datepicker focused" name="b_day" id="b_day" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <b>Email</b>
                        <div class="form-group form-float">
                            <div class="form-line ">
                                <input type="text" class="form-control focused" name="email" id="email" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group form-float">
                        <b>Mobile #</b>
                            <div class="form-line">
                                <input type="text" class="form-control mob focused" name="mobile_no" id="mobile_no" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="body">
                                <b>Sex</b>
                                <div class="form-group Usex">
                                <input  name="Usex" value="male" type="radio" class="with-gap radio-col-<?php echo $color;?> male" id="male" >
                                <label for="male">Male</label>
                                <input name="Usex" type="radio" value="female" class="with-gap radio-col-<?php echo $color;?> female" id="female">
                                <label for="female">Female</label>
                                </div> 
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group form-float">
                        <b>Date Created</b>
                            <div class="form-line">
                                <input type="text" class="form-control" name="date_created" id="date_created" placeholder="Date Created" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group form-float uRole">
                        <b>Role</b>
                        <select class="form-control show-tick" name="role_name" title="Please select a role" id="role_name" required>
                                    <option value="1" name="admin" id="admin">Admin</option>
                                    <option value="2" name="member" id="member">Member</option>
                                </select>                                     
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
                    </div>    
                    <div class="modal-footer">
                    <button type="submit" class="btn bg-<?php echo $color; ?> waves-effect" id="change">Save Changes</button>
                    <button type="button" id="closeModal" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                    </div>
                </form>
                </div>
            </div>
        </div>


        <div class="modal fade" id="addUserModal">
            <div class="modal-dialog" role="document">
                <form class="form_validate" method="POST" action="save_user.php" class="modal-form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">User Info</h4>
                        <input type="hidden" name="type" value="create">
                    </div>
                    <div class="row modal-body">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <b>Username</b>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" class="form-control focused" name="username" id="addUsername" minlength="6" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <b>First Name</b>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" class="form-control focused" name="f_name" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <b>Middle Name</b>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" class="form-control focused" name="m_name" >
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <b>Last Name</b>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" class="form-control"  name="l_name" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <b>Password</b>
                    <div class="form-float form-group">
                        <div class="input-group">
                            <div class="form-line">
                                <input type="password" class="form-control" minlength="6" name="pass" id="pass" required>
                            </div>
                            <span class="input-group-addon" id="lockPass" style="cursor: pointer;"><i class="material-icons">lock_outline</i></span>
                        </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <b>Re-type Password</b>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="password" class="form-control" name="re_pass" id="re_pass" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button type="button" class="btn btn-block bg-<?php echo $color; ?> waves-effect m-b-20" id="generate_pass" >GENERATE PASSWORD</button>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <b>Birthday</b>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" class="form-control datepicker focused" name="b_day" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <b>Email</b>
                        <div class="form-group form-float">
                            <div class="form-line ">
                                <input type="email" class="form-control focused" name="email" id="addEmail" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group form-float">
                        <b>Mobile #</b>
                            <div class="form-line">
                                <input type="text" class="form-control mob focused" name="mobile_no" id="addMobileNo" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="body">
                                <b>Sex</b>
                                <div class="form-group">
                                <input  name="sex" type="radio" value="male" class="with-gap radio-col-<?php echo $color;?>" id="sexMale">
                                <label for="sexMale">Male</label>
                                <input name="sex" type="radio" value="female" class="with-gap radio-col-<?php echo $color;?>" id="sexFemale">
                                <label for="sexFemale">Female</label>
                                </div> 
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group form-float">
                        <b>Role</b>
                        <select class="form-control show-tick" name="role_name">
                                    <option value="1" name="member">Member</option>
                                    <option value="2" name="admin" >Admin</option>
                                </select>                                     
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b-20"></div>
                    </div>
                    <div class="modal-footer">
                    <button type="submit" class="btn bg-<?php echo $color; ?> waves-effect" id="createUser">Create User</button>
                    <button type="button" id="closeAddUserModal" class="btn btn-default waves-effect" data-dismiss="modal"> Close </button>
                    </div>
                </div>
                </form>
            </div>
        </div>
</section>
<script type="text/javascript" src="active_js.js"> </script>
<?php
require_once "../template-admin/footer.php";
?>