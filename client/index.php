<?php
require_once "../support/config.php";
$active_dir = "client";
$active_sub_dir = "home";
$dir = "../";
$color = "brown";
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
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="body">
                    <blockquote>
                    <p class="align-center"><b>Recommended Rooms</b></p>
                    <footer class="align-center">Enjoy our variety of room suites.</footer>
                    </blockquote>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
                            <img src="image_carousel/deluxe.jpeg" width="100%" height="400px;"/>
                            <div class="carousel-caption">
                                <h3>Deluxe Room</h3>
                                <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur.</p>
                            </div>
                        </div>
                        <div class="item">
                            <img src="image_carousel/premium.jpeg" width="100%" height="400px;"/>
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
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card m-t-20">
                <div class="body">
                    <blockquote>
                    <p class="align-center"><b>Recommended Foods</b></p>
                    <footer class="align-center">Come and enjoy some exquisite delicacy.</footer>
                    </blockquote>
                </div>
            </div>
        </div>
            <!-- Start of food -->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">            
                <div id="room_carousel2" class="carousel slide" data-ride="carousel" data-interval="3500">
                    <ol class="carousel-indicators">
                        <li data-target="room_carousel2" data-slide="0" class="active"></li>
                        <li data-target="room_carousel2" data-slide="1"></li>
                        <li data-target="room_carousel2" data-slide="2"></li>
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
                        <div class="item">
                            <img src="image_carousel/foods.jpeg"  width="100%" height="400px;"/>
                            <div class="carousel-caption">
                                <h3>Lunch</h3>
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
                <div class="card m-t-20">
                    <div class="body">
                        <blockquote>
                        <p class="align-center"><b>Relax</b>, <b>Refresh</b>, <b>Recharge</b></p>
                        <footer class="align-center">Stay fit, Pump up or wind down at our fitness and spa facilities during your stay at our hotel.</footer>
                        </blockquote>
                    </div>
                </div>
            </div>
            <!-- End about us -->
            <!-- Start spa -->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">            
                <div id="room_carousel3" class="carousel slide" data-ride="carousel" data-interval="3500">
                    <ol class="carousel-indicators">
                        <li data-target="room_carousel2" data-slide="0" class="active"></li>
                        <li data-target="room_carousel2" data-slide="1"></li>
                        <li data-target="room_carousel2" data-slide="2"></li>
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        <div class="item active">
                            <img src="image_carousel/spa1.jpg" width="100%" height="400px;"/>
                            <div class="carousel-caption">
                                <h3>Water Massage</h3>
                                <p>Running water state of the art exercise equipment, dedicated training zones and internationally certified fitness trainers to keep you in shape.</p>
                            </div>
                        </div>
                        <div class="item">
                            <img src="image_carousel/spa2.jpg"  width="100%" height="400px;"/>
                            <div class="carousel-caption">
                                <h3>Chi Spa</h3>
                                <p>Surrounded by tropical garden, CHI, The Spa comprises outdoor bathing facilities, relaxation lounges and specialty spa suites where you can enjoy a variety of holistic therapies and treatments.</p>
                            </div>
                        </div>
                        <div class="item">
                            <img src="image_carousel/gym1.jpg"  width="100%" height="400px;"/>
                            <div class="carousel-caption">
                                <h3>Athletic Club</h3>
                                <p>Train like a beast look like a beauty, experience our athletic club here in our hotel.</p>
                            </div>
                        </div>
                    </div>
                    <a class="left carousel-control" href="#room_carousel3" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#room_carousel3" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
            </div>
            
            </div>
            <!-- End Spa -->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card m-t-20">
                    <div class="body">
                        <blockquote>
                        <p class="align-center"><b>Unforgetable Events</b></p>
                        <footer class="align-center">Design and enhance your event experiences in our hotel.</footer>
                        </blockquote>
                    </div>
                </div>
            <!-- Start Offers     -->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">            
                <div id="room_carousel4" class="carousel slide" data-ride="carousel" data-interval="3500">
                    <ol class="carousel-indicators">
                        <li data-target="room_carousel2" data-slide="0" class="active"></li>
                        <li data-target="room_carousel2" data-slide="1"></li>
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        <div class="item active">
                            <img src="image_carousel/events.jpg" width="100%" height="400px;"/>
                            <div class="carousel-caption">
                                <h3>Weddings & Other Occations</h3>
                                <p>Your special event is a highly personalised experience from planning to execution. Stylish decor, myriad dining options and uncompromised, professional service.</p>
                            </div>
                        </div>
                        <div class="item">
                            <img src="image_carousel/scene.jpg"  width="100%" height="400px;"/>
                            <div class="carousel-caption">
                                <h3>Scenery</h3>
                                <p>Find beauty everywhere.</p>
                            </div>
                        </div>
                    </div>
                    <a class="left carousel-control" href="#room_carousel4" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#room_carousel4" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
            </div>
            </div>
            </div>
            <!-- End Offers -->
            </div>
         </div>
    </section>

<?php
require_once "template-client/footer.php";
?>