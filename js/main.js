var curSlice = 100;
$( document ).ready(function() {
    $("table > tbody > tr").hide().slice(0, curSlice).show();
    $("#showMore").on("click", function() {
        $("tbody > tr", $(this).prev()).slice(curSlice, 100+curSlice).show();
        curSlice += 100;
    });
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