<?php
require_once "../support/config.php";
$active_dir = "client";
$active_sub_dir = "home";
$dir = "../";
$color = "red";
// print_ar($_SESSION[WEB]);
// die;
if(!AllowUser("Member") || !isset($_SESSION[WEB])){
    redirect("../index.php");
    die;
}
require_once "template-client/header.php";
require_once "template-client/sidebar.php";
RunAlert();
?>
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>DASHBOARD</h2>    
            </div>
        
        <div class="row clearfix">
        <!-- room start -->
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="align-center"><h2>Rooms</h2></div>
                <div id="room_carousel" class="carousel slide" data-ride="carousel" data-interval="3500">
                    <ol class="carousel-indicators">
                        <li data-target="room_carousel" data-slide="0" class="active"></li>
                        <li data-target="room_carousel" data-slide="1"></li>
                        <li data-target="room_carousel" data-slide="2"></li>
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        <div class="item active">
                            <img src="image_carousel/budget.jpeg" width="100%" height="400px;"/>
                            <div class="carousel-caption">
                                <h3>Budget Room</h3>
                                <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur.</p>
                            </div>
                        </div>
                        <div class="item">
                            <img src="image_carousel/deluxe.jpeg"  width="100%" style="height: 319px"/>
                            <div class="carousel-caption">
                                <h3>Deluxe Room</h3>
                                <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur.</p>
                            </div>
                        </div>
                        <div class="item">
                            <img src="image_carousel/premium.jpeg"  width="100%" height="400px;"/>
                            <div class="carousel-caption">
                                <h3>Premium Room</h3>
                                <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur.</p>
                            </div>
                        </div>
                    </div>
                    <a class="left carousel-control" href="#room_carousel" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#room_carousel" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <!-- End of  room -->
            <!-- Start of food -->
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="align-center"><h2>Foods</h2></div>
                <div id="room_carousel2" class="carousel slide" data-ride="carousel" data-interval="3500">
                    <ol class="carousel-indicators">
                        <li data-target="room_carousel2" data-slide="0" class="active"></li>
                        <li data-target="room_carousel2" data-slide="1"></li>
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        <div class="item active">
                            <img src="image_carousel/donut.jpeg" width="100%" height="400px;"/>
                            <div class="carousel-caption">
                                <h3>Dessert Stand</h3>
                                <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur.</p>
                            </div>
                        </div>
                        <div class="item">
                            <img src="image_carousel/buffet.jpeg"  width="100%" height="400px;"/>
                            <div class="carousel-caption">
                                <h3>Buffet</h3>
                                <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur.</p>
                            </div>
                        </div>
                    </div>
                    <a class="left carousel-control" href="#room_carousel2" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#room_carousel2" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <!-- End of food -->
            <!-- Start about us -->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h2 class="display-1">About Us</h2>
            <div class="card">
                <div class="body bg-red">
                Quis pharetra a pharetra fames blandit. Risus faucibus velit Risus imperdiet mattis neque volutpat, etiam lacinia netus dictum magnis per facilisi sociosqu. Volutpat. Ridiculus nostra.
                </div>
            </div>
            </div>
            <!-- End about us -->
            </div>
        </div>
    </section>

<?php
require_once "template-client/footer.php";
?>