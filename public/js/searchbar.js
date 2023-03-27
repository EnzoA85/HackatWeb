// document.getElementById('searchbar').addEventListener('keyup', function(e){
//     var ville = document.getElementsByClassName('villeHackathon');
//     var value = document.getElementById('searchbar').value.toLowerCase();
//     document.querySelectorAll("#result tr").forEach(function(row){
//         row.style.display = row.textContent.toLowerCase().indexOf(value) > -1 ? "" : "none";
//     })
// })

document.getElementById("searchbar").addEventListener("keyup", function (e){
    var value = document.getElementById('searchbar').value.toLowerCase();
    const card = document.getElementsByClassName('card');
    for (var i = 0; i < card.length; i++) {
        var ville = card[i].getAttribute('data-ville').toLowerCase()
        if (!ville.includes(value)) {
            card[i].style.display = "none";
        } else {
            card[i].style.display = "";
        }
    }
})