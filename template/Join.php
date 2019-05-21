<div class="row">
    <div class="col-md-9">
        <div class="card">
            <div class="card-body">
                <form>
                        <?php
                        $nrOfFormGroup=7;
                        $labelText = Array("First Name","Last Name","Address","City","State","Phone","CNP");
                        $type = Array("text","text","text","text","text","tel","text");
                        $class = "form-control form-control-sm";
                        $id = Array("inputFirstName","inputLastName","inputAddress","inputCity","inputState","inputPhone","inputCNP");
                        $placeHolder = Array("Enter First Name","Enter Last Name","Enter Address","Enter City","Enter State","Enter Phone", "Enter CNP");
                        ?>
                        <?for($i = 0;$i<$nrOfFormGroup;$i++):?>
                            <?=($i%2==0) ? '<div class="form-row">' : ''?>
                                <div class="form-group col-md-6">
                                    <label for="<?=$id[$i]?>"><?=$labelText[$i]?></label>
                                    <input type="<?=$type[$i]?>" class="<?=$class?>" id="<?=$id[$i]?>" placeholder="<?=$placeHolder[$i]?>" <?=($labelText[$i]==="CNP") ? 'maxlength="13"' : ''?> >
                                </div>
                            <?=($i%2==1) ? '</div>' : ''?>
                        <? endfor;?>
                        <?=($nrOfFormGroup%2 == 1) ? '</div>' : ''?>
                    <button type="submit" class="btn btn-primary custom-button">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div id="map"></div>
            </div>
        </div>

    </div>
</div>