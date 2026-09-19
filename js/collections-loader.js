/**
 * Collections Loader - Load and render collection data dynamically
 */

class CollectionsLoader {
  constructor() {
    this.collections = {};
    this.init();
  }

  async init() {
    try {
      const response = await fetch('data/collections.json');
      const data = await response.json();
      this.collections = data.collections;
      this.renderCollections();
    } catch (error) {
      console.error('Failed to load collections:', error);
    }
  }

  getLanguage() {
    const urlParams = new URLSearchParams(window.location.search);
    const lang = urlParams.get('lang') || localStorage.getItem('language') || 'en';
    return ['en', 'pt'].includes(lang) ? lang : 'en';
  }

  getCollectionName(collection) {
    const lang = this.getLanguage();
    return lang === 'pt' ? collection.namePt : collection.nameEn;
  }

  getImageDescription(image) {
    const lang = this.getLanguage();
    return lang === 'pt' ? (image.descriptionPt || image.descriptionEn || '') : (image.descriptionEn || '');
  }

  renderCarousel(collection) {
    const carouselContainer = document.getElementById('carousel-inner');
    if (!carouselContainer) return;

    // Don't overwrite if carousel already has static content
    if (carouselContainer.querySelector('.carousel-item')) return;

    carouselContainer.innerHTML = '';

    collection.images.forEach((image, index) => {
      const isActive = index === 0 ? ' active' : '';
      const desc = this.getImageDescription(image);
      const itemHTML = `
        <div class="carousel-item${isActive}">
          <img src="${image.file}" class="d-block w-100" alt="${this.getCollectionName(collection)} - ${desc}" loading="${index > 0 ? 'lazy' : 'eager'}">
          <div class="carousel-caption">
            <h3>${this.getCollectionName(collection)}</h3>
            <p>${desc}</p>
          </div>
        </div>
      `;
      carouselContainer.insertAdjacentHTML('beforeend', itemHTML);
    });

    // Update carousel indicators
    const indicatorsContainer = document.querySelector('.carousel-indicators');
    if (indicatorsContainer) {
      indicatorsContainer.innerHTML = '';
      collection.images.forEach((_, index) => {
        const isActive = index === 0 ? ' active' : '';
        const indicatorHTML = `<button type="button" data-bs-target="#myCarousel" data-bs-slide-to="${index}" class="${isActive}" aria-label="Slide ${index + 1}"></button>`;
        indicatorsContainer.insertAdjacentHTML('beforeend', indicatorHTML);
      });
    }
  }

  renderCollectionGrid(containerId = 'collection-grid') {
    const container = document.getElementById(containerId);
    if (!container) return;

    container.innerHTML = '';

    this.collections.forEach(collection => {
      const thumb = collection.thumbnail;
      const collectionHTML = `
        <div class="collection-card">
          <a href="collection-view.html?id=${collection.id}">
            <img src="img/${thumb}" alt="${this.getCollectionName(collection)}" loading="lazy">
            <h3>${this.getCollectionName(collection)}</h3>
          </a>
        </div>
      `;
      container.insertAdjacentHTML('beforeend', collectionHTML);
    });
  }

  renderCollections() {
    if (document.getElementById('carousel-inner')) {
      const tkosCollection = this.collections.find(c => c.id === 'tkos');
      if (tkosCollection) {
        this.renderCarousel(tkosCollection);
      }
    }

    if (document.getElementById('collection-grid')) {
      this.renderCollectionGrid();
    }
  }

  static instance = null;

  static get() {
    if (!CollectionsLoader.instance) {
      CollectionsLoader.instance = new CollectionsLoader();
    }
    return CollectionsLoader.instance;
  }
}

window.addEventListener('DOMContentLoaded', () => {
  CollectionsLoader.get();
});
