<section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="../images/user.png" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo cleanHTML($_SESSION[WEB]['name']); ?></div>
                    <div class="email"><?php echo ucfirst(strtolower($_SESSION[WEB]['role_type'])); ?></div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <!-- <li><a href="javascript:void(0);"><i class="material-icons">person</i>Profile</a></li> -->
                            <li><a href="javascript:void(0);" id="logout"><i class="material-icons">input</i>Sign Out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                <?php $side_dir = $active_dir !== "client" ? "../" : ""; ?>
                    <li class="header">MAIN NAVIGATION</li>
                    <li class="<?php echo $active_dir == "client" ? "active" : ""; ?>">
                        <a href="javascript:void(0)" class="menu-toggle">
                            <i class="material-icons">account_circle</i>
                            <span>My Account</span>
                        </a>
                        <ul class="ml-menu">
                        <li class="<?php echo $active_sub_dir == "reservations" ? "active" : "" ;?>">
                                <a href="<?php echo  $side_dir; ?>client/reservations.php">Reservations</a>
                            </li>
                            <li class="<?php echo $active_sub_dir == "transactions" ? "active" : "" ;?>">
                                <a href="<?php echo  $side_dir; ?>client/transactions.php">Transactions</a>
                            </li>
                            <li class="<?php echo $active_sub_dir == "settings" ? "active" : "" ;?>">
                                <a href="<?php echo  $side_dir; ?>client/settings.php">Settings</a>
                            </li>
                        </ul>                    
                    </li>
        </aside>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
        <!-- #END# Right Sidebar -->
    </section>