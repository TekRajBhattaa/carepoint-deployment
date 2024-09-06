/**
 * Add a css class when the element appears in viewport
 *
 * @param {IntersectionObserverEntry[]} entries
 */
function func2(entries) {
    entries.forEach(entry => {
        const elem = entry.target;
        if (entry.isIntersecting) {
            elem.classList.add('in-viewport');
        }
    })
}

const config = {
    root: null,
    rootMargin: '0px',
    threshold: .5
};

const observer = new IntersectionObserver(func2, config);

/**
 * Set or remove a css class when the element is in viewport
 *
 * @param {string} selector
 */
export function inViewport(selector = '.box') {
    document.querySelectorAll(selector).forEach(elem => {
        observer.observe(elem);
    });
}


export function initDelay(selector = '.box') {
    document.querySelectorAll(selector).forEach(elem => {
        // Returns a random integer from 0 to 300
        const delay = Math.floor(Math.random() * 501);
        elem.style.transitionDelay = `${delay}ms`;
    });
}
