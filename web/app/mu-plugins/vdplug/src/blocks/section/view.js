function calcParallax(elem) {
    const sectionHeight = Math.ceil(elem.scrollHeight);
    const bg = elem.querySelector('img');
    const elemRect = elem.getBoundingClientRect();
    const speed = parseFloat(elem.style.getPropertyValue('--parallaxSpeed'));
    const posY = Math.floor(window.scrollY);
    const offY = elemRect.top
    bg.style.top = (speed * Math.ceil(posY - offY) - sectionHeight) + 'px';
}

function animateParallax() {
    document.querySelectorAll('.section--parallax').forEach(calcParallax);
}

// === INIT ===

document.addEventListener('DOMContentLoaded', () => {
    if (document.querySelector('.section--parallax') !== null) {
        window.addEventListener('scroll', animateParallax, false);
    }
});
