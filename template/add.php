<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <?php
                $form = new Form();
                $form->setLabels(
                    array("CARD_ID" => "ID Card",
                        "ATM_ID" => "ID ATM",
                        "SUM" => "Suma",
                        "TRANSACTION_DATE"=>"sysdate",
                        "EXP" => "sysdate",
                        "TRANSACTION_TYPE"=>"Tipul tranzactiei",
                        "NAME"=>"Nume",
                        "ADDRESS"=>"Adresa",
                        "CASH_LIMIT"=>"Limita ATM",
                        "PLACE"=>"Locatie",
                        "ACCOUNT_TYPE"=>"Tipul Contului",
                        "BUGET"=>"Buget",
                        "CARD_NUMBER"=>"Numarul Cardului",
                        "FK_ID"=>"ID Legatura",
                        "FNAME" => "Prenume",
                        "LNAME" => "Nume",
                        "VENIT"=>"Venit",
                        "DATE_OF_BIRTH"=>"Data nasterii",
                        "MID_WAGE"=>"Salariu Mediu",
                        "PHONE" => "Numar de telefon"
                    )
                );
                $form->create($_GET['table'],$_GET['ident']);
                $form->waitForPost();
                $form->generate(); ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div id="map"></div>
            </div>
        </div>

    </div>

</div>