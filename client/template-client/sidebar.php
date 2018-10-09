<section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
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