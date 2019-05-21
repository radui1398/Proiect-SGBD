<!doctype html>

<html lang="ro">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta charset="UTF-8">
<?php
require_once("template/Header.php");
require_once("template/functions.php");
require_once("template/Form.php");
require_once('template/Database.php');
require_once('util.php');
$header = new Header("BMS");
$header->generateHeader();
?>
<body>
<div class="content">
    <div class="custom-header">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="custom-title">BMS</div>
                </div>
                <div class="col">
                    <?php
                    require_once("template/Menu.php");
                    $menu = new Menu(1);
                    $active = getActive();
                    $menu->generateMenu($active);
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4">Despre BMS</h1>
            <p class="lead">BMS este un sistem de administrare a bancilor realizat pentru proiectul de la SGBD.</p>
        </div>
    </div>
    <div class="container">
        <?php
        switch (getVarFromPage("page")) {
            case "join":
                include("template/Join.php");
                break;
            case "add":
                include("template/add.php");
                break;
            case "last10tr":
                include("template/last10tr.php");
                break;
            case "oldCards":
                include("template/oldCards.php");
                break;
            case "bank_cnp":
                include("template/bank_cnp.php");
                break;
            case "top_atm":
                include("template/top_atm.php");
                break;
            case "top_bank":
                include("template/top_bank.php");
                break;
            case "delete_bank":
                include("template/delete_bank.php");
                include("template/Home.php");
                break;
            case "delete_old_transaction":
                include("template/delete_old_transaction.php");
                include("template/Home.php");
                break;
            case "atm_last_transaction":
                include("template/atm_last_transaction.php");
                break;
            case "responsible_manager":
                include("template/responsible_manager.php");
                include("template/Home.php");
                break;
            case "get_no_transactions":
                include("template/get_no_transactions.php");
                break;
            case "exp_transactions":
                include("template/exp_transactions.php");
                break;
            case "operatii":
                include("template/Operatii.php");
                break;
            case "view":
                include("template/view_page.php");
                break;
            case "update":
                include("template/update.php");
                break;
            case "injection":
                include("template/injection.php");
                break;
            default:
                include("template/Home.php");
        }
        ?>
    </div>
</div>

<footer class="section footer-classic footer-height">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="credits">
                    Website realizat de: Radu Ionut-Alexandru si Andrei Mardare.
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="js/jquery-3.3.1.slim.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
    // Note: This example requires that you consent to location sharing when
    // prompted by your browser. If you see the error "The Geolocation service
    // failed.", it means you probably did not give permission for the browser to
    // locate you.
    var map, infoWindow;
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: -34.397, lng: 150.644},
            zoom: 6
        });
        infoWindow = new google.maps.InfoWindow;

        // Try HTML5 geolocation.
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

                infoWindow.setPosition(pos);
                infoWindow.setContent('Location found.');
                infoWindow.open(map);
                map.setCenter(pos);
            }, function() {
                handleLocationError(true, infoWindow, map.getCenter());
            });
        } else {
            // Browser doesn't support Geolocation
            handleLocationError(false, infoWindow, map.getCenter());
        }
    }

    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
            'Error: The Geolocation service failed.' :
            'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
    }
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCmYHI58zognm2RtSDZ55V4UzIMYxRtygs&callback=initMap">
</script>
<script src="js/main.js"></script>
</body>
</html>