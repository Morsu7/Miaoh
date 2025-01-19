const carousel = new bootstrap.Carousel('#carouselExampleCaptions')

function submitForm(productId) {
    document.getElementById("product-form-" + productId).submit();
}