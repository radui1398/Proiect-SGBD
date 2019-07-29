<div class="row">
    <div class="col">
        <?php
        require_once("template/ListGroup.php");
        $list = array("Ultimele tranzactii ATM"=>"atm_last_transaction", "Cel mai responsabil manager"=>"responsible_manager", "Tranzactiile clientului"=>"get_no_transactions", "Tranzactii invalide"=>"exp_transactions", "SQL Injection"=>"injection");
        $listGroup = new ListGroup("Functii", $list);
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