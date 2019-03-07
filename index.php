<!doctype html>

<html lang="ro">
<?php
require_once ("template/Header.php");
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
                    $menu->generateMenu(1);
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
        <div class="row">
            <div class="col">
                <?php
                    require_once("template/ListGroup.php");
                    $list = array("Adaugare client","Stergere Client","Modificare Client","Afisarea tuturor clientilor");
                    $listGroup = new ListGroup("Administrare clienti",$list);
                    $listGroup->generateGroup();
                ?>
            </div>
            <div class="col">
                <?php
                    $list = array("Adaugare Imprumut","Plata Imprumut","Modificare Dobanda","Adaugare venit");
                    $listGroup = new ListGroup("Administrare buget",$list);
                    $listGroup->generateGroup();
                ?>
            </div>
        </div>
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