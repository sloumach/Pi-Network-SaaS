
console.log('test');

$(document).ready(function() {
    // Fonction pour vérifier l'état de l'enregistrement périodiquement
    function checkRecordStatus() {
        $.ajax({
            url: "{{ route('checkRecordStatus') }}", // Route vers la méthode du contrôleur
            type: "GET",
            data: { recordId: "ID_DU_RECORD_A_VERIFIER" }, // Remplacer ID_DU_RECORD_A_VERIFIER par l'identifiant de l'enregistrement à vérifier
            success: function(response) {
                // Traitement de la réponse
                if (response === "in progress") {
                    // Faire quelque chose si l'enregistrement est en cours de traitement
                } else if (response === "failed") {
                    // Faire quelque chose si le traitement de l'enregistrement a échoué
                    clearInterval(interval); // Arrêter l'exécution périodique
                } else if (response === "done") {
                    // Faire quelque chose si le traitement de l'enregistrement est terminé
                    clearInterval(interval); // Arrêter l'exécution périodique
                } else {
                    // Gérer d'autres cas si nécessaire
                }
            },
            error: function(xhr, status, error) {
                console.error(error); // Gérer les erreurs
            }
        });
    }

    // Appeler la fonction pour vérifier périodiquement l'état de l'enregistrement
    var interval = setInterval(checkRecordStatus, 80000); // Vérifier toutes les 5 secondes (ajustez selon vos besoins)
});

