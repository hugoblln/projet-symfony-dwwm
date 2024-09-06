const input = document.getElementById('villeInput');
const suggestionsList = document.getElementById('suggestions');

input.addEventListener('input', function () {
    const searchTerm = input.value.trim();
    if (searchTerm.length === 0) {
        suggestionsList.innerHTML = '';
        return;
    }

    fetch(`https://geo.api.gouv.fr/communes?nom=${searchTerm}&limit=5`)
        .then(response => response.json())
        .then(data => {
            suggestionsList.innerHTML = '';
            data.forEach(ville => {
                const li = document.createElement('li');
                li.textContent = ville.nom;
                li.addEventListener('click', function () {
                    // Rediriger vers la page Symfony avec la ville sélectionnée
                    window.location.href = `/terrains?&query=&min=&max=&ville=${ville.nom}&order=ASC`;
                });
                suggestionsList.appendChild(li);
            });
        })
        .catch(error => {
            console.error('Une erreur s\'est produite lors de la recherche de villes:', error);
        });
});