<!doctype html>

<html lang="ro">
<?php
require_once ("template/Header.php");
require_once ("template/functions.php");
require_once ("template/Form.php");
require_once ('template/Database.php');
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
                    require_once ("template/Menu.php");
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
            switch(getVarFromPage("page")) {
                case "join":
                    include ("template/Join.php");
                    break;
                case "addBank":
                    include ("template/addBank.php");
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
</body>
</html>