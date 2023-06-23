'use strict';
    
    let input = document.querySelector("#search");

    input.addEventListener('keyup', () => { // Ecoute d'évènement au keyup

        // Récupérer le text tapé dans l'input par l'utilisateur
        let textFind = document.querySelector('#search').value;

        // Faire un objet de type request
        let myRequest = new Request('index.php?road=searchVoiture', {
            method  : 'POST',
            body    : JSON.stringify({ textToFind : textFind })
        })
           
        fetch(myRequest)
            // Récupère les données
            .then(res => res.text())

            // Exploite les données
            .then(res => {
                document.getElementById("targetViews").innerHTML = res; // On met articles.phtml dans la div -> id=target
                // ou
                location.reload(); // Pour une réactualisation de la page
            })
    })
   
	