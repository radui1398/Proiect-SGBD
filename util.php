<?php
function executeOci($stmt,$result){
    // execute the statement
    ini_set('display_errors', '0');
    oci_execute($stmt);
    if (oci_error($stmt))
        echo '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>Eroare:</strong> ' . oci_error($stmt)['message'] . '
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                ';
    else if($result)
        echo '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  '.$result.'
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                ';
    ini_set('display_errors', '1');
}
function sanitize_post($item)
{
    htmlspecialchars_decode(trim($item));
}