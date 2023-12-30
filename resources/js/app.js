import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Champion mastery

document.addEventListener('DOMContentLoaded', function () {
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