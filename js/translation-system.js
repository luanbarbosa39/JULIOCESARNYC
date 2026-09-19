/**
 * Translation System - Centralized multi-language support
 * Usage: T('path.to.key') or T('path.to.key', { fallback: 'default' })
 */

class TranslationSystem {
  constructor() {
    this.translations = {};
    this.currentLanguage = this.detectLanguage();
    this.init();
  }

  async init() {
    try {
      const response = await fetch('data/translations.json');
      this.translations = await response.json();
      this.applyTranslations();
    } catch (error) {
      console.error('Failed to load translations:', error);
    }
  }

  detectLanguage() {
    // Check URL parameter
    const urlParams = new URLSearchParams(window.location.search);
    const langParam = urlParams.get('lang');
    if (langParam && ['en', 'pt'].includes(langParam)) {
      return langParam;
    }

    // Check localStorage
    const savedLang = localStorage.getItem('language');
    if (savedLang) {
      return savedLang;
    }

    // Check browser language
    const browserLang = navigator.language.split('-')[0];
    return ['en', 'pt'].includes(browserLang) ? browserLang : 'en';
  }

  setLanguage(lang) {
    if (!['en', 'pt'].includes(lang)) return;
    this.currentLanguage = lang;
    localStorage.setItem('language', lang);
    window.location.search = `?lang=${lang}`;
  }

  translate(key, options = {}) {
    const keys = key.split('.');
    let value = this.translations[this.currentLanguage];

    for (const k of keys) {
      if (value && typeof value === 'object') {
        value = value[k];
      } else {
        return options.fallback || key;
      }
    }

    return value || options.fallback || key;
  }

  applyTranslations() {
    // Find all elements with data-translate attribute
    document.querySelectorAll('[data-translate]').forEach(el => {
      const key = el.getAttribute('data-translate');
      el.textContent = this.translate(key);
    });

    // Find all elements with data-translate-placeholder
    document.querySelectorAll('[data-translate-placeholder]').forEach(el => {
      const key = el.getAttribute('data-translate-placeholder');
      el.placeholder = this.translate(key);
    });

    // Find all elements with data-translate-title
    document.querySelectorAll('[data-translate-title]').forEach(el => {
      const key = el.getAttribute('data-translate-title');
      el.title = this.translate(key);
    });

    // Update language buttons
    document.querySelectorAll('[data-lang-switch]').forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        this.setLanguage(btn.getAttribute('data-lang-switch'));
      });
    });
  }

  static instance = null;

  static get() {
    if (!TranslationSystem.instance) {
      TranslationSystem.instance = new TranslationSystem();
    }
    return TranslationSystem.instance;
  }
}

// Global function for easy access
window.T = (key, options) => TranslationSystem.get().translate(key, options);

// Initialize on page load
window.addEventListener('DOMContentLoaded', () => {
  TranslationSystem.get();
});
