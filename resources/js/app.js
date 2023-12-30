import './bootstrap';
import { playChampionSound } from './playChampionSound'; 

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

/* This adds an hover effect to the cards */
document.addEventListener('DOMContentLoaded', () => {
    const cards = document.querySelectorAll('[id^="card-"]');
    cards.forEach(card => {
        card.addEventListener('mouseover', function () {
            cards.forEach(otherCard => {
                if (otherCard === card) {
                    otherCard.querySelector('.backdrop-filter').style.opacity = '0';
                } else {
                    otherCard.querySelector('.backdrop-filter').style.opacity = '1';
                }
            });
        });

        card.addEventListener('mouseout', function () {
            cards.forEach(otherCard => {
                otherCard.querySelector('.backdrop-filter').style.opacity = '0';
            });
        });
    });
});

/* This code is adding an event listener to the `DOMContentLoaded` event, which is fired when the
initial HTML document has been completely loaded and parsed. */
/* Sfx for champion cards */
document.addEventListener('DOMContentLoaded', () => {
    const championElements = document.querySelectorAll('[data-champion-id]');
    championElements.forEach(championElement => {
        championElement.addEventListener('mouseover', () => {
            playChampionSound(championElement);
        });
    });
});