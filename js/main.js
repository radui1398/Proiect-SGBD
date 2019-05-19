var curSlice = 100;
$( document ).ready(function() {

});

function searchCardByName() {

    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchByName");
    filter = input.value.toUpperCase();
    table = document.getElementById("cardTable");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}