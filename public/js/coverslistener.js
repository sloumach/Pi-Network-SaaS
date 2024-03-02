
console.log('test');

$(document).ready(function() {
    // Fonction pour vérifier l'état de l'enregistrement périodiquement
    var interval = setInterval(checkRecordStatus, 9000);
    function checkRecordStatus() {
        var divs = document.querySelectorAll('[id^="spinner-"]');
                var ids = [];
                var types = "cover";
                for (var i = 0; i < divs.length; i++) {
                var id = divs[i].id.replace('spinner-', '');
                ids.push(id);
                }
                if (ids.length !==0) {


                    $.ajax({
                        url: "/checkcover", // Route vers la méthode du contrôleur
                        type: "GET",
                        data: { recordId: ids }, // Remplacer ID_DU_RECORD_A_VERIFIER par l'identifiant de l'enregistrement à vérifier

                        success: function(response) {
                            for (var id in response) {
                                var status = response[id];

                                if (status === 'completed') {
                                var spinnerDiv = document.querySelector('#spinner-' + id);
                                if (spinnerDiv) {
                                    var html = '<a href="editor/' + id + '?type='+types+ '" class="btn btn-success border-0" style="background-color: purple">' +
                                            'Show' +
                                            '</a>';
                                    spinnerDiv.insertAdjacentHTML('beforebegin', html);
                                    spinnerDiv.remove();




                                }
                                }
                            }
                            // Traitement de la réponse
                            /* if (response === "failed") {
                                    // Faire quelque chose si le traitement de l'enregistrement a échoué
                                    clearInterval(interval); // Arrêter l'exécution périodique
                                } else if (response === "completed") {
                                    // Faire quelque chose si le traitement de l'enregistrement est terminé
                                    clearInterval(interval); // Arrêter l'exécution périodique
                                } else {
                                    // Gérer d'autres cas si nécessaire

                                } */
                        },
                        error: function(xhr, status, error) {
                            console.log(error); // Gérer les erreurs
                        }
                    });
                } else {
                    clearInterval(interval);
                }
    }

    // Appeler la fonction pour vérifier périodiquement l'état de l'enregistrement
     // Vérifier toutes les 5 secondes (ajustez selon vos besoins)
});

