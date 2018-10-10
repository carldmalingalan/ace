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
                <?php $side_dir = $active_dir !== "admin" ? "../" : ""; ?>
                    <li class="header">MAIN NAVIGATION</li>
                    <li class="<?php echo $active_dir == "admin" ? "active": ""; ?>">
                        <a href="<?php echo $side_dir; ?>index.php">
                            <i class="material-icons">dashboard</i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="<?php echo $active_dir == "reservation" ? "active": ""; ?>">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">event</i>
                            <span>Reservation</span>
                        </a>
                        <ul class="ml-menu">
                            <li class="<?php echo $active_sub_dir == "reservation_index" ? "active" : "" ;?>">
                                <a href="<?php echo  $side_dir; ?>reservation/index.php">All Reservation</a>
                            </li>
                            <li class="<?php echo $active_sub_dir == "reservation_archive" ? "active" : "" ;?>">
                                <a href="<?php echo  $side_dir; ?>reservation/archived_reservation.php">Archive</a>
                            </li>
                        </ul>
                    <li class="<?php echo $active_dir == "transactions" ? "active": ""; ?>">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">payment</i>
                            <span>Transactions</span>
                        </a>
                        <ul class="ml-menu">
                            <li class="<?php echo $active_sub_dir == "transaction_index" ? "active" : "" ;?>">
                                <a href="<?php echo  $side_dir; ?>transaction/index.php">All Transactions</a>
                            </li>
                            <li class="<?php echo $active_sub_dir == "transaction_PR" ? "active" : "" ;?>">
                                <a href="<?php echo  $side_dir; ?>transaction/payment_records.php">Payment Records</a>
                            </li>
                            <li class="<?php echo $active_sub_dir == "transaction_archive" ? "active" : "" ;?>">
                                <a href="<?php echo  $side_dir; ?>transaction/transaction_archive.php">Archives</a>
                            </li>
                        </ul>
                    <li class="<?php echo $active_dir == "accounts" ? "active": ""; ?>">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">supervisor_account</i>
                            <span>Accounts</span>
                        </a>
                        <ul class="ml-menu">
                            <li class="<?php echo $active_sub_dir == "account_index" ? "active" : "" ;?>">
                                <a href="<?php echo $side_dir ?>accounts/index.php">All Accounts</a>
                            </li>
                        </ul>            
                    <li class="<?php echo $active_dir == "metadata" ? "active": ""; ?>">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">folder</i>
                            <span>Metadata</span>
                        </a>              
                    <ul class="ml-menu">
                        <li class="<?php echo $active_sub_dir == "metadata_room" ? "active" : "" ;?>">
                            <a href="<?php echo $side_dir ?>metadata/room_meta.php">Rooms</a>
                        </li>
                        <li class="<?php echo $active_sub_dir == "metadata_roomtype" ? "active" : "" ;?>">
                            <a href="<?php echo $side_dir ?>metadata/roomtype_meta.php">Room Type</a>
                        </li>
                        <li class="<?php echo $active_sub_dir == "metadata_mop" ? "active" : "" ;?>">
                            <a href="<?php echo $side_dir ?>metadata/mop_meta.php">Mode of Payment</a>
                        </li>
                        <li class="<?php echo $active_sub_dir == "metadata_food" ? "active" : "" ;?>">
                            <a href="<?php echo $side_dir ?>metadata/food_meta.php">Food</a>
                        </li>
                        <li class="<?php echo $active_sub_dir == "metadata_promo" ? "active" : "" ;?>">
                            <a href="<?php echo $side_dir ?>metadata/promo_meta.php">Promos</a>
                        </li>
                    </ul>            
        </aside>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
        <!-- #END# Right Sidebar -->
    </section>