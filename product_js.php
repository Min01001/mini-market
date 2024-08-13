<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[name="search_query"]');
    searchInput.addEventListener('keyup', function() {
        fetchProducts();
    });

    // Initial load
    fetchProducts();
});

function fetchProducts() {
    const searchQuery = document.querySelector('input[name="search_query"]').value;
    fetch('product_show_json.php?search_query=' + encodeURIComponent(searchQuery))
        .then(response => response.json())
        .then(data => displayProducts(data))
        .catch(error => console.error('Error:', error));
}

function displayProducts(products) {
    const container = document.querySelector('.row');
    container.innerHTML = ''; // Clear the container

    if (products.length > 0) {
        products.forEach(product => {
            const productHtml = `
                <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                    <div class="card cards">
                        <img src="${product.image}" class="card-img-top image-size" alt="${product.product}">
                        <div class="card-body">
                            <p class="card-title text-center text-dark">${product.product}</p>
                            <p class="card-text text-center text-dark">$${product.current_price}</p>
                            <a href="view.php?id=${product.id}" class="btn btn-outline-info d-flex justify-content-center">View</a>
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', productHtml);
        });
    } else {
        container.innerHTML = '<p class="text-white">No products found.</p>';
    }
}
</script>
