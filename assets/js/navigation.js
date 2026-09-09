/**
 * Script Navigazione e Accessibilità Menu
 *
 * Gestione menu mobile responsive, interazioni da tastiera e supporto accessibilità ARIA.
 *
 * Tema: Cinephile - Editorial Cinema Magazine
 * Ideatore: Diego Costanzo (Firenze, Italia)
 * Autore & Sviluppo: Antigravity & Gemini (Google DeepMind)
 * Realizzato con l'ausilio di Intelligenza Artificiale (AI)
 * Versione: 1.0.0 - Settembre 2026
 * Licenza: GNU General Public License v2 or later (Open Source)
 *
 * @package Cinephile
 */

document.addEventListener('DOMContentLoaded', function () {
    const mainNav = document.querySelector('.main-navigation');
    if (!mainNav) return;

    // 1. Gestione Focus per Navigazione da Tastiera
    const navLinks = mainNav.querySelectorAll('a');
    navLinks.forEach(function (link) {
        link.addEventListener('focus', function () {
            this.classList.add('is-focused');
        });
        link.addEventListener('blur', function () {
            this.classList.remove('is-focused');
        });
    });

    // 2. Centramento Automatico della Voce Attiva su Mobile/Tablet
    const activeItem = mainNav.querySelector('.current-menu-item > a, .pill-item.active');
    if (activeItem && window.innerWidth <= 1024) {
        activeItem.scrollIntoView({
            behavior: 'smooth',
            block: 'nearest',
            inline: 'center'
        });
    }
});
