document.addEventListener('DOMContentLoaded', function() {

    // ==========================================
    // PART 1: HAMBURGER & PROFILE SIDE-NAV
    // ==========================================
    const hamburgerBtn = document.getElementById('hamburger-btn');
    const closeBtn = document.getElementById('close-btn');
    const sideNav = document.getElementById('side-nav');
    const overlay = document.getElementById('overlay');

    const toggleMenu = (isOpen) => {
        sideNav.classList.toggle('active', isOpen);
        overlay.classList.toggle('active', isOpen);
        document.body.style.overflow = isOpen ? 'hidden' : 'auto';
    };

    hamburgerBtn?.addEventListener('click', () => toggleMenu(true));
    closeBtn?.addEventListener('click', () => toggleMenu(false));
    overlay?.addEventListener('click', () => toggleMenu(false));

    // ==========================================
    // PART 2: CATEGORY FILTERING LOGIC
    // ==========================================
    const categories = [
        { id: 'all', name: 'All', icon: '<i class="bx bxs-grid-alt"></i>', count: '28 items' },
        { id: 'lugaw', name: 'Lugaw', icon: '<i class="bx bx-bowl-hot"></i>', count: '3 items' },
        { id: 'goto', name: 'Goto', icon: '<i class="bx bx-bowl-rice"></i>', count: '2 items' },
        { id: 'silog', name: 'Silog', icon: '<i class="bx bx-restaurant"></i>', count: '7 items' },
        { id: 'sizzling', name: 'Sizzling', icon: '<i class="bx bxs-hot"></i>', count: '4 items' },
        { id: 'chow', name: 'Chowfan', icon: '<i class="bx bx-food-tag"></i>', count: '5 items' },
        { id: 'carte', name: 'A la Carte', icon: '<i class="bx bx-dish"></i>', count: '3 items' },
        { id: 'drinks', name: 'Drinks', icon: '<i class="bx bx-drink"></i>', count: '3 items' },
        { id: 'addons', name: 'Add Ons', icon: '<i class="bx bx-plus-medical"></i>', count: '7 items' },
    ];

    const categoryContainer = document.getElementById('categoryContainer');
    const menuGrid = document.getElementById('menuGrid');
    const menuCards = document.querySelectorAll('.menu-card');

    function renderCategories() {
        if (!categoryContainer) return;
        categoryContainer.innerHTML = '';
        categories.forEach(cat => {
            const btn = document.createElement('div');
            btn.className = `category-card ${cat.id === 'all' ? 'active' : ''}`;
            btn.innerHTML = `
                <div class="cat-icon">${cat.icon}</div>
                <span class="cat-name">${cat.name}</span>
                <span class="cat-count">${cat.count}</span>
            `;
            btn.addEventListener('click', () => {
                document.querySelectorAll('.category-card').forEach(c => c.classList.remove('active'));
                btn.classList.add('active');
                filterMenuCards(cat.id);
            });
            categoryContainer.appendChild(btn);
        });
    }

    function filterMenuCards(category) {
        menuCards.forEach(card => {
            const cardCategory = card.getAttribute('data-category');
            card.style.display = (category === 'all' || cardCategory === category) ? 'flex' : 'none';
        });
        reorderMenuCards(); // Panatilihin ang priority sorting kahit nag-filter
    }

    // ==========================================
    // PART 3: SEARCH FUNCTIONALITY
    // ==========================================
    const searchInput = document.getElementById('searchInput');
    searchInput?.addEventListener('input', function(e) {
        const searchText = e.target.value.toLowerCase();
        menuCards.forEach(card => {
            const title = card.querySelector('h3').innerText.toLowerCase();
            card.style.display = title.includes(searchText) ? 'flex' : 'none';
        });
    });

    // ==========================================
    // PART 4: FAVORITE (HEART) & PRIORITY SORTING
    // ==========================================
    menuCards.forEach((card, index) => {
        card.setAttribute('data-original-index', index);
    });

    function reorderMenuCards() {
        const cardsArray = Array.from(menuCards);
        cardsArray.sort((a, b) => {
            const isFavA = a.querySelector('.btn-fav').classList.contains('active');
            const isFavB = b.querySelector('.btn-fav').classList.contains('active');
            const indexA = parseInt(a.getAttribute('data-original-index'));
            const indexB = parseInt(b.getAttribute('data-original-index'));

            if (isFavA === isFavB) return indexA - indexB;
            return isFavA ? -1 : 1;
        });
        cardsArray.forEach(card => menuGrid.appendChild(card));
    }

    document.addEventListener('click', function(e) {
        const favBtn = e.target.closest('.btn-fav');
        if (favBtn) {
            e.preventDefault();
            favBtn.classList.toggle('active');
            const icon = favBtn.querySelector('i');
            if (favBtn.classList.contains('active')) {
                icon.classList.replace('fa-regular', 'fa-solid');
            } else {
                icon.classList.replace('fa-solid', 'fa-regular');
            }
            reorderMenuCards();
        }
    });

    // Initial Load
    renderCategories();
    updateBadgeCount();
});

// ==========================================
// PART 5: GLOBAL CART FUNCTIONS
// ==========================================
function addToCart(itemName, itemPrice, itemImage) {
    let cart = JSON.parse(localStorage.getItem('myCart')) || [];
    const existingItem = cart.find(item => item.name === itemName);
    if (existingItem) {
        existingItem.qty += 1;
    } else {
        cart.push({ name: itemName, price: itemPrice, qty: 1, img: itemImage });
    }
    localStorage.setItem('myCart', JSON.stringify(cart));
    updateBadgeCount();
    showToast(`Added ${itemName} to cart!`);
}

function updateBadgeCount() {
    let cart = JSON.parse(localStorage.getItem('myCart')) || [];
    let totalQty = cart.reduce((sum, item) => sum + item.qty, 0);
    const badge = document.getElementById('cart-badge');
    if (badge) badge.innerText = totalQty;
}

function showToast(message) {
    const toast = document.getElementById('toast');
    if (toast) {
        toast.innerText = message;
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 3000);
    }
}