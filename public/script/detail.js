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