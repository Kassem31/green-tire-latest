import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

var scrollCat = function() {
    let targetElement = document.querySelector('.some-selector'); // Or getElementById, etc.

    if (targetElement) {
        let offset = targetElement.offsetTop;
        console.log('Scrolling to offset:', offset); // Example usage
    } else {
        console.warn('scrollCat: Target element not found.');
    }
};
