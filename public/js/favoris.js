/////////////////////////////
// Pour la page de détails //
/////////////////////////////

// Ajout d'un favoris
var lienAjout = document.getElementById('js-lienFavoris');
if (lienAjout != null){
lienAjout.addEventListener('click', function (event) {
    //on empeche la redirection directe
    event.preventDefault();

    //recup la balise <a>
    let baliseA = event.target;
    
    let type = baliseA.getAttribute("data-type");

    //est ce que c'est un boutton d'ajout du favori ou de suppression
    if (type == 'ajout')
    {
        //instanciation d'un objet xmlhttprequest
        let xhr = new XMLHttpRequest();
        //si c'est l'ajout, on ajoute puis on transforme le boutton en suppression
        //on se rend sur la branche de l'API d'ajout
        let url = baliseA.getAttribute("href");
        xhr.open("GET", url);
        xhr.responseType = "json";
        xhr.send();
        xhr.onload = function () {
            if (xhr.status != 200) {
                alert("Erreur" + xhr.status + ":" + xhr.statusText);
            }
            else {
                //transformation du boutton 'ajout' en boutton 'suppression'

                //1) On récupere l'élément balise
                balise = document.getElementById('js-lienFavoris');
                //2) On change le texte affiché
                balise.textContent = '★ Supprimer des favoris';
                //3) On change le lien pour qu'il redirige sur la branche API de suppression avec l'id du Hackathon
                balise.setAttribute("href",'/supprFavoriHackathon/'+balise.getAttribute("data-id"));
                //4) On change le type pour que le boutton soit reconnu comme le boutton de suppression
                balise.setAttribute("data-type",'suppr');
            };
            //Si la requête n'a pas pu aboutir...
            xhr.onerror = function () {
                alert("La requête a échoué");
            }
        }
    }
    else if (type == 'suppr')
    {
        //instanciation d'un objet xmlhttprequest
        let xhr = new XMLHttpRequest();

        let url = baliseA.getAttribute("href");
        //console.log(url);

        xhr.open("GET", url);
        xhr.responseType = "json";
        xhr.send();
        xhr.onload = function () {
        if (xhr.status != 200) {
            alert("Erreur" + xhr.status + ":" + xhr.statusText);
        }
        else {
                //transformation du boutton 'supression' en boutton 'ajout'

                //1) On récupere l'élément balise
                balise = document.getElementById('js-lienFavoris');
                //2) On change le texte affiché
                balise.textContent = '☆ Ajouter aux favoris';
                //3) On change le lien pour qu'il redirige sur la branche API de suppression avec l'id du Hackathon
                balise.setAttribute("href",'/favoriHackathon/'+balise.getAttribute("data-id"));
                //4) On change le type pour que le boutton soit reconnu comme le boutton de suppression
                balise.setAttribute("data-type",'ajout');
        };
        //Si la requête n'a pas pu aboutir...
        xhr.onerror = function () {
            alert("La requête a échoué");
        }
    }
    }
    else
    {
        console.log('erreur de type');
    }

}) 
}

///////////////////////////
// Pour la page de liste //
///////////////////////////

var lesLiens = document.getElementsByClassName("btn btn-primary js-lienFavoris");
for (i = 0; i < lesLiens.length; i++)
{
// Ajout d'un favoris

lesLiens[i].addEventListener('click', function (event) {
    //on empeche la redirection directe
    event.preventDefault();

    //recup la balise <a>
    let baliseA = event.target;
    
    let type = baliseA.getAttribute("data-type");

    //est ce que c'est un boutton d'ajout du favori ou de suppression
    if (type == 'ajout')
    {
        //instanciation d'un objet xmlhttprequest
        let xhr = new XMLHttpRequest();
        //si c'est l'ajout, on ajoute puis on transforme le boutton en suppression
        //on se rend sur la branche de l'API d'ajout
        let url = baliseA.getAttribute("href");
        xhr.open("GET", url);
        xhr.responseType = "json";
        xhr.send();
        xhr.onload = function () {
            if (xhr.status != 200) {
                alert("Erreur" + xhr.status + ":" + xhr.statusText);
            }
            else {
                //transformation du boutton 'ajout' en boutton 'suppression'

                //1) On récupere l'élément balise
                // baliseA = document.getElementById('js-lienFavoris');
                //2) On change le texte affiché
                baliseA.textContent = '★ Supprimer des favoris';
                //3) On change le lien pour qu'il redirige sur la branche API de suppression avec l'id du Hackathon
                baliseA.setAttribute("href",'/supprFavoriHackathon/'+baliseA.getAttribute("data-id"));
                //4) On change le type pour que le boutton soit reconnu comme le boutton de suppression
                baliseA.setAttribute("data-type",'suppr');
            };
            //Si la requête n'a pas pu aboutir...
            xhr.onerror = function () {
                alert("La requête a échoué");
            }
        }
    }
    else if (type == 'suppr')
    {
        //instanciation d'un objet xmlhttprequest
        let xhr = new XMLHttpRequest();

        let url = baliseA.getAttribute("href");
        //console.log(url);

        xhr.open("GET", url);
        xhr.responseType = "json";
        xhr.send();
        xhr.onload = function () {
        if (xhr.status != 200) {
            alert("Erreur" + xhr.status + ":" + xhr.statusText);
        }
        else {
                //transformation du boutton 'supression' en boutton 'ajout'

                //1) On récupere l'élément balise
                //balise = document.getElementById('js-lienFavoris');
                //2) On change le texte affiché
                baliseA.textContent = '☆ Ajouter aux favoris';
                //3) On change le lien pour qu'il redirige sur la branche API de suppression avec l'id du Hackathon
                baliseA.setAttribute("href",'/favoriHackathon/'+baliseA.getAttribute("data-id"));
                //4) On change le type pour que le boutton soit reconnu comme le boutton de suppression
                baliseA.setAttribute("data-type",'ajout');
        };
        //Si la requête n'a pas pu aboutir...
        xhr.onerror = function () {
            alert("La requête a échoué");
        }
    }
    }
    else
    {
        console.log('erreur de type');
    }

}) 
}
