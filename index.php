<!doctype html>

<html lang="ro">
<?php
require_once ("template/Header.php");
require_once ("template/functions.php");
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
    <?php
        //generate jumbotron
    ?>
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4">Despre BMS</h1>
            <p class="lead">BMS este un sistem de administrare a bancilor realizat pentru proiectul de la SGBD.</p>
        </div>
    </div>
    <div class="container">
        <?php
            require_once ('template/Database.php');
            $db = Database::getInstance();
            if(getVarFromPage("page") === "join") {
                include("template/Join.php");
            }
            else{
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

</body>
</html>