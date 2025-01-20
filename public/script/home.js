const carousel = new bootstrap.Carousel('#carouselExampleCaptions')

document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search-input');
    const suggestionsBox = document.getElementById('search-suggestions');

    searchInput.addEventListener('input', function () {

        const query = searchInput.value.trim();

        fetch('public/api/search_suggestions.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'q=' + encodeURIComponent(query), 
            credentials: 'include'
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            suggestionsBox.innerHTML = '';
            if (data.length > 0) {
                // Mostra suggerimenti
                suggestionsBox.style.display = data.length ? 'block' : 'none';

                data.forEach(item => {
                    const li = document.createElement('li');
                    li.className = 'list-group-item list-group-item-action ask-detail-btn';
                    li.textContent = item.nome;
                    li.setAttribute('data-id', item.id);
                    suggestionsBox.appendChild(li);
                });
                setupAskDetailButtons();
            } else {
                reviewsContainer.innerHTML = '<p>Nessuna risultato trovato.</p>';
            }
        })
        .catch(error => console.error('Errore nella ricerca:', error));
    });

    // Nascondi suggerimenti se clicchi altrove
    document.addEventListener('click', function (event) {
        if (!searchInput.contains(event.target)) {
            suggestionsBox.style.display = 'none';
        }
    });
});
