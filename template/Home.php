<div class="row">
    <div class="col">
        <?php
        require_once("template/ListGroup.php");
        $list = array("Adaugare banca"=>"addBank", "Stergere Client"=>"", "Modificare Client"=>"", "Afisarea tuturor clientilor"=>"");
        $listGroup = new ListGroup("Administrare clienti", $list);
        $listGroup->generateGroup();
        ?>
    </div>
    <div class="col">
        <?php
        $list = array("Ultimele 10 tranzactii"=>"last10tr", "Carduri Expirate"=>"oldCards", "Banca Clientului"=>"bank_cnp", "Adaugare venit"=>"");
        $listGroup = new ListGroup("Proceduri", $list);
        $listGroup->generateGroup();
        ?>
    </div>
</div>