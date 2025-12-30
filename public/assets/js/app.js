/* app.js — interactions légères pour FootJersey */

/* Debounce helper */
function debounce(fn, wait) {
  let t;
  return function(...args) {
    clearTimeout(t);
    t = setTimeout(() => fn.apply(this, args), wait);
  };
}

/* Search in header: redirect to products list with query param */
(function initSearch() {
  const search = document.querySelector('.search-input');
  const searchBtn = document.querySelector('.search-btn');

  if (!search) return;

  const submitSearch = () => {
    const q = search.value.trim();
    const url = q ? `/?page=product&action=list&q=${encodeURIComponent(q)}` : '/?page=product&action=list';
    window.location.href = url;
  };

  // Search on Enter key
  search.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') submitSearch();
  });

  // Search on button click
  if (searchBtn) {
    searchBtn.addEventListener('click', submitSearch);
  }

  // Optional: search while typing (debounced)
  search.addEventListener('input', debounce(() => {
    // Show suggestions? For now, just placeholder for future
    // console.log('searching', search.value);
  }, 350));
})();

/* Confirmation before removing item from cart */
(function confirmRemove() {
  document.addEventListener('click', function(e) {
    const target = e.target.closest('a');
    if (!target) return;
    const href = target.getAttribute('href') || '';
    if (href.includes('page=cart') && href.includes('action=remove')) {
      const ok = confirm('Tu veux vraiment supprimer cet article du panier ?');
      if (!ok) e.preventDefault();
    }
    if (href.includes('page=auth') && href.includes('action=logout')) {
      // optional confirmation
      // if (!confirm('Se déconnecter ?')) e.preventDefault();
    }
  });
})();

/* Numeric input friendly: prevent negative qtys */
(function qtyInputs() {
  document.addEventListener('input', function(e) {
    const el = e.target;
    if (el.tagName === 'INPUT' && el.type === 'number') {
      if (el.min && +el.value < +el.min) el.value = el.min;
      if (el.value === '') el.value = 0;
    }
  });
})();

/* Tiny animation when adding to cart: we look for links with ?page=cart&action=add */
(function addToCartAnim() {
  document.addEventListener('click', function(e) {
    const btn = e.target.closest('a,button');
    if (!btn) return;
    const href = btn.getAttribute('href') || '';
    // détecte le pattern add to cart (utilisé dans product detail)
    if (href.includes('page=cart') && href.includes('action=add')) {
      // simple visual feedback
      btn.classList.add('round');
      setTimeout(() => btn.classList.remove('round'), 700);
      // allow default navigation to happen
    }
  });
})();

/* Catalog search and filters */
(function initCatalogFilters() {
  const searchInput = document.querySelector('#search-input');
  const categoryFilter = document.querySelector('#category-filter');
  const sortFilter = document.querySelector('#sort-filter');

  if (!searchInput && !categoryFilter && !sortFilter) return;

  const applyFilters = () => {
    const q = searchInput ? searchInput.value.trim() : '';
    const category = categoryFilter ? categoryFilter.value : '';
    const sort = sortFilter ? sortFilter.value : '';

    const params = new URLSearchParams(window.location.search);
    params.delete('q');
    params.delete('category');
    params.delete('sort');
    params.delete('page_num'); // Reset to page 1 on filter change

    if (q) params.set('q', q);
    if (category) params.set('category', category);
    if (sort && sort !== 'name') params.set('sort', sort);

    const url = `/?page=product&action=list&${params.toString()}`;
    window.location.href = url;
  };

  // Search on Enter or button click
  if (searchInput) {
    searchInput.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') applyFilters();
    });
  }

  // Search button click
  const searchBtn = document.querySelector('#search-btn');
  if (searchBtn) {
    searchBtn.addEventListener('click', applyFilters);
  }

  // Filters on change
  if (categoryFilter) {
    categoryFilter.addEventListener('change', applyFilters);
  }
  if (sortFilter) {
    sortFilter.addEventListener('change', applyFilters);
  }
})();

/* Mobile menu toggle */
(function mobileMenuToggle() {
  const toggle = document.querySelector('#mobile-menu-toggle');
  const menu = document.querySelector('#mobile-menu');

  if (!toggle || !menu) return;

  // Toggle mobile menu
  toggle.addEventListener('click', () => {
    const isActive = menu.classList.contains('active');
    menu.classList.toggle('active');

    // Update toggle icon
    const icon = toggle.querySelector('i');
    if (icon) {
      icon.className = isActive ? 'fas fa-bars' : 'fas fa-times';
    }
  });

  // Close menu when clicking outside
  document.addEventListener('click', (e) => {
    if (!toggle.contains(e.target) && !menu.contains(e.target)) {
      menu.classList.remove('active');
      const icon = toggle.querySelector('i');
      if (icon) {
        icon.className = 'fas fa-bars';
      }
    }
  });

  // Close menu on navigation
  const navLinks = menu.querySelectorAll('a');
  navLinks.forEach(link => {
    link.addEventListener('click', () => {
      menu.classList.remove('active');
      const icon = toggle.querySelector('i');
      if (icon) {
        icon.className = 'fas fa-bars';
      }
    });
  });
})();
