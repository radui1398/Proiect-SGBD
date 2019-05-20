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
        $list = array("Ultimele 10 tranzactii"=>"last10tr", "Carduri Expirate"=>"oldCards",
            "Banca Clientului"=>"bank_cnp", "TOP 5 ATM-uri"=>"top_atm", "TOP 5 Banci"=>"top_bank",
            "Sterge banca cu cei mai putini clienti" => "delete_bank",
            "Sterge tranzactiile mai vechi de un an" => "delete_old_transaction",
            "Adaugare Tranzactie" => "add_transaction",
            "Adaugare banca" => "addBank");
        $listGroup = new ListGroup("Proceduri", $list);
        $listGroup->generateGroup();
        ?>
    </div>
</div>