const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");
const productCarousel = document.querySelector(".product-carousel");

prevBtn.addEventListener("click", () => {
    productCarousel.scrollBy({ left: -300, behavior: 'smooth' });
});

nextBtn.addEventListener("click", () => {
    productCarousel.scrollBy({ left: 300, behavior: 'smooth' });
});

productCarousel.addEventListener('touchstart', handleTouchStart, false);
productCarousel.addEventListener('touchend', handleTouchEnd, false);
let x1 = null;
    
function handleTouchStart(e) {
    const firstTouch = e.touches[0];
    x1 = firstTouch.clientX;
}

function handleTouchEnd(e) {
    if (!x1) return;
    let x2 = e.changedTouches[0].clientX;
    let xDiff = x2 - x1;
    if (xDiff > 0) {
        prevBtn.click();
    } else {
        nextBtn.click();
    }
    x1 = null;
}


function submitForm(productId) {
    document.getElementById("product-form-" + productId).submit();
}

const formRecensioni = document.querySelector('.add-review-form');

document.addEventListener('DOMContentLoaded', function () {
    const reviewsContainer = document.getElementById('reviews-container');

    const hiddenInput = document.querySelector('input[name="idMainProduct"]');

    // Leggi il valore
    if(hiddenInput){
        const productId = hiddenInput.value;
        
        // Funzione per caricare le recensioni
        function loadReviews() {
            fetch('public/api/reviews.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'idProduct=' + encodeURIComponent(productId), 
                credentials: 'include'
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                reviewsContainer.innerHTML = ''; // Svuota il contenitore
                if (data.length > 0) {
                    data.forEach(review => {
                        const reviewHTML = `
                            <div class="review-card mb-3">
                                <div class="review-header">
                                    <img src="public/assets/images/profilepictures/${(review.nomeUtente+'.'+review.fotoProfilo) || 'default-avatar.png'}" alt="Foto profilo di ${review.nomeUtente}" class="profile-pic">
                                    <div class="review-user-info">
                                        <p class="user-name">${review.nomeUtente}</p>
                                        <p class="review-date">${new Date(review.data).toLocaleDateString()}</p>
                                    </div>
                                </div>
                                <div class="review-content">
                                    <p><strong>Valutazione:</strong> ${review.valutazione} / 5</p>
                                    <p>${review.descrizione}</p>
                                </div>
                            </div>
                        `;
                        reviewsContainer.insertAdjacentHTML('beforeend', reviewHTML);
                    });
                } else {
                    reviewsContainer.innerHTML = '<p>Nessuna recensione disponibile.</p>';
                }
            })
            .catch(error => console.error('Errore nel caricamento delle recensioni:', error));
        }
        

        // Funzione per aggiungere una nuova recensione
        document.querySelector('.send-review').addEventListener('click', () => {
            const formData = new FormData(formRecensioni);
            
            // Leggi i valori dai campi usando il loro nome
            const rating = formData.get('rating');
            const description = formData.get('description');

            fetch('public/api/add_review.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'idProduct=' + encodeURIComponent(productId) + '&rating=' + encodeURIComponent(rating) + '&description=' + encodeURIComponent(description), 
                credentials: 'include'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadReviews();
                    //console.log('Sessione sì');
                } else{
                    if(data.error == 'No sessione'){
                        alert('Devi effettuare il login per poter lasciare una recensione.');
                        location.href = '?action=login';
                    }
                    //console.error('Errore: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Errore nella richiesta:', error);
                //alert('Si è verificato un errore durante la richiesta.');
            });
        });

        loadReviews();
    }
});
