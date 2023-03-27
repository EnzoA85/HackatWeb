document.getElementById("searchbar").addEventListener("keyup", function (e){
    var value = document.getElementById('searchbar').value.toLowerCase();
    const card = document.getElementsByClassName('card');
    nbhackathon = card.length
    for (var i = 0; i < card.length; i++) {
        var ville = card[i].getAttribute('data-ville').toLowerCase()
        if (!ville.includes(value)) {
            nbhackathon = nbhackathon - 1
            card[i].style.display = "none";
            document.getElementById('titrepage').innerHTML="Liste des "+ nbhackathon +" Hackathons";
        } else {
            card[i].style.display = "";
            document.getElementById('titrepage').innerHTML="Liste des "+ nbhackathon +" Hackathons";
        }
    }
})