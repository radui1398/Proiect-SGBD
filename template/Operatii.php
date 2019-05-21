<div class="row">
    <div class="col">
        <?php
        require_once("template/ListGroup.php");
        $list = array(
            "Banci"=>"view&table=BANK&pageNr=1",
            "ATM"=>"view&table=ATM&pageNr=1",
            "Conturi"=>"view&table=ACCOUNTS&pageNr=1",
            "Carduri"=>"view&table=CARD&pageNr=1",
            "Clienti"=>"view&table=CLIENTS&pageNr=1",
            "Angajati"=>"view&table=EMPLOYEES&pageNr=1",
            "Manageri"=>"view&table=MANAGERS&pageNr=1",
            "Salarizare"=>"view&table=STANDARDIZATION&pageNr=1",
            "Sucursale"=>"view&table=SUBSIDIARY&pageNr=1",
            "Tranzactii"=>"view&table=TRANSACTION&pageNr=1",
        );
        $listGroup = new ListGroup("Vizualizare", $list);
        $listGroup->generateGroup();
        ?>
    </div>
    <div class="col">
        <?php
        require_once("template/ListGroup.php");

        $list = array(
            "Banci"=>"add&table=BANK&ident=ID",
            "ATM"=>"add&table=ATM&ident=ATM_NO",
            "Conturi"=>"add&table=ACCOUNTS&ident=ID",
            "Carduri"=>"add&table=CARD&ident=ID",
            "Clienti"=>"add&table=CLIENTS&ident=ID",
            "Angajati"=>"add&table=EMPLOYEES&ident=ID",
            "Manageri"=>"add&table=MANAGERS&ident=ID",
            "Salarizare"=>"add&table=STANDARDIZATION&ident=TYPE",
            "Sucursale"=>"add&table=SUBSIDIARY&ident=ID",
            "Tranzactii"=>"add&table=TRANSACTION&ident=ID",
        );
        $listGroup = new ListGroup("Inserare", $list);
        $listGroup->generateGroup();
        ?>
    </div>
</div>