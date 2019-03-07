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
                <div class="list-group">
                    <button type="button" class="list-group-item list-group-item-action active" disabled>
                        Administrare clienti
                    </button>
                    <button type="button" class="list-group-item list-group-item-action">Adaugare Client</button>
                    <button type="button" class="list-group-item list-group-item-action">Stergere Client</button>
                    <button type="button" class="list-group-item list-group-item-action">Modificare Client</button>
                    <button type="button" class="list-group-item list-group-item-action">Afisarea tuturor clientilor
                    </button>
                </div>
            </div>
            <div class="col">
                <div class="list-group">
                    <button type="button" class="list-group-item list-group-item-action active" disabled>
                        Administrare buget
                    </button>
                    <button type="button" class="list-group-item list-group-item-action">Adaugare Imprumut</button>
                    <button type="button" class="list-group-item list-group-item-action">Plata Imprumut</button>
                    <button type="button" class="list-group-item list-group-item-action">Modificare Dobanda</button>
                    <button type="button" class="list-group-item list-group-item-action">Adaugare Venit</button>
                </div>
            </div>
        </div>
    </div>
</div>
<footer class="section footer-classic footer-height">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="credits">
                    Website realizat de: Radu Ionut si Andrei Mardare.
                </div>
            </div>
        </div>
    </div>
</footer>
</body>
</html>