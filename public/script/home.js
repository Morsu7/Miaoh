const carousel = new bootstrap.Carousel('#carouselExampleCaptions')

const searchInput = document.getElementById('search-input');
const suggestionsBox = document.getElementById('search-suggestions');
const productList = document.getElementById('product-list');
let currentCategory = ''; // Categoria attualmente selezionata
let isLoading = false; // Flag per evitare richieste multiple
let isSearching = false;
let currentPage = 0; // Reset della paginazione
let maxPage // Reset della paginazione
let currentSort = ''; // Ordinamento corrente

document.addEventListener('DOMContentLoaded', function () {

    setMaxPage(); 

    // Ascolta i cambiamenti nella selezione della categoria
    document.getElementById('categoryFilter').addEventListener('change', function () {
        currentCategory = this.value; // Aggiorna la categoria corrente
        currentPage = 0; // Reset della paginazione
        productList.innerHTML = ''; // Svuota la lista dei prodotti
        loadMoreProducts(); // Carica i prodotti della nuova categoria
    });

    document.getElementById('sortFilter').addEventListener('change', function () {
        currentSort = this.value; // Aggiorna l'ordinamento corrente
        currentPage = 0; // Reset della paginazione
        productList.innerHTML = ''; // Svuota la lista dei prodotti
        loadMoreProducts(); // Carica i prodotti ordinati
    });

    // Aggiungi l'evento di scroll
    window.addEventListener('scroll', handleScroll);

    // Carica la prima pagina all'avvio
    loadMoreProducts();

    searchInput.addEventListener('input', function () {
        isSearching=true;
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
            fillSuggestionsBox(data) 
            fillProductList(data,false)          
        })
        .catch(error => console.error('Errore nella ricerca:', error));
    });
    
    // Nascondi suggerimenti se clicchi altrove
    document.addEventListener('click', function (event) {
        if (!searchInput.contains(event.target) && isSearching==true) {
            isSearching=false;
            suggestionsBox.style.display = 'none';
            currentPage = 0; // Reset della paginazione
            productList.innerHTML = ''; // Svuota la lista dei prodotti
            loadMoreProducts(); // Carica i prodotti della nuova categoria
            productList.innerHTML = ''; // Svuota le card esistenti
        }
    });
});

// Modifica la funzione AJAX per includere la categoria
function loadMoreProducts() {
    if (isLoading || currentPage>=maxPage) return;
    isLoading = true;

    const url = `public/api/get_products.php?page=${currentPage}&category=${encodeURIComponent(currentCategory)}`;

    fetch('public/api/get_products.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'page=' + encodeURIComponent(currentPage) + '&category=' + encodeURIComponent(currentCategory) + '&sort='+ encodeURIComponent(currentSort),
        credentials: 'include'
    })
    .then(response => response.json())
    .then(data => {
        isLoading = false;
        currentPage++;
        fillProductList(data,true)
        //window.removeEventListener('scroll', handleScroll);
    })
    .catch(error => {
        isLoading = false;
        console.error('Errore nel caricamento dei prodotti:', error);
    });
}

// Funzione per rilevare lo scroll in fondo alla pagina
function handleScroll() {
    const scrollPosition = window.scrollY + window.innerHeight; // Posizione attuale dello scroll
    const bottomPosition = document.documentElement.scrollHeight; // Altezza totale della pagina

    if (scrollPosition >= bottomPosition - 50 && isSearching==false) { // Quando siamo vicini al fondo
        loadMoreProducts();
    }
}

function fillSuggestionsBox(data){
    // Svuota il contenitore dei suggerimenti
    suggestionsBox.innerHTML = '';
    
    if (data.length > 0) {
        // Mostra suggerimenti nella lista
        suggestionsBox.style.display = 'block';

        data.forEach(item => {
            const li = document.createElement('li');
            li.className = 'list-group-item list-group-item-action ask-detail-btn';
            li.textContent = item.nome;
            li.setAttribute('data-id', item.id);
            suggestionsBox.appendChild(li);
        });
    } else {
        const li = document.createElement('li');
        li.className = 'list-group-item list-group-item-action ask-detail-btn';
        li.textContent = 'Nessun elemento trovato';
        suggestionsBox.appendChild(li);
    }
}


function fillProductList(data,append){
    // Genera le card dinamiche con i dati JSON
    if(!append) productList.innerHTML = ''; // Svuota le card esistenti
    if (data.length > 0) {
        let countIndex = 0; // Inizializza il contatore
        let row = document.createElement('div'); // Crea una nuova riga
        row.className = 'row';
        productList.appendChild(row); // Aggiungi la riga al contenitore principale
    
        data.forEach(product => {
            countIndex++;
            // Calcolo del prezzo e dello sconto direttamente dai dati JSON
            const fineSconto = new Date(product.fine_sconto);
            const oggi = new Date();
            let price = product.prezzo;
            let sconto = false;
    
            if (fineSconto > oggi) {
                sconto = true;
                price = (product.prezzo * (100 - product.sconto)) / 100;
            }
    
            if (!isNaN(price)) {
                price = Number(price).toFixed(2);
            } else {
                console.error(`Il prezzo del prodotto con ID ${product.id} non è valido:`, price);
                price = "N/A"; // Fallback se il prezzo non è valido
            }
    
            // Creazione della struttura HTML della card
            const card = `
                <article class="col-12 col-sm-6 col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 ask-detail-btn" data-id="${product.id}">
                        <img src="public/assets/images/productimages/${product.id}.${product.img1}" 
                             class="card-img-top product-image img-fluid" 
                             alt="${product.nome}" 
                             style="cursor: pointer;">
                        <div class="card-body">
                            <h3 class="card-title text-dark">${product.nome}</h3>
                            <p class="card-text">${product.descrizione}</p>
                            <p class="card-text">Prezzo: 
                                ${sconto ? `<span class="text-decoration-line-through text-muted">€${product.prezzo}</span>` : ''}
                                €<span id="price-${product.id}">${price}</span>
                            </p>
                            <a class="btn btn-primary interaction cart add-to-cart-btn" data-id="${product.id}">
                                Aggiungi al carrello
                            </a>
                        </div>
                    </div>
                </article>
            `;
    
            // Aggiungi la card alla riga corrente
            row.insertAdjacentHTML('beforeend', card);
    
            // Se il contatore arriva a 3, crea una nuova riga
            if (countIndex === 3) {
                countIndex = 0; // Resetta il contatore
                row = document.createElement('div'); // Crea una nuova riga
                row.className = 'row';
                productList.appendChild(row); // Aggiungi la nuova riga al contenitore principale
            }
        });
    } else {
        //productList.innerHTML = '<p class="text-center">Nessun risultato trovato.</p>';
    } 
}

function setMaxPage() {
    fetch('public/api/maxPage.php')
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                //console.log(`Numero massimo di pagine: ${data.maxPage}`);
                maxPage= data.maxPage;
            } else {
                console.error("Errore:", data.message);
            }
        })
        .catch(error => console.error("Errore AJAX:", error));
}
