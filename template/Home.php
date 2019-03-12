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