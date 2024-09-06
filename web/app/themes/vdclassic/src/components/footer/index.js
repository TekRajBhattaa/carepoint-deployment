import './footer.css';


const mediaQueryList = window.matchMedia('(max-width: 767px)');

/**
 * Collapse Footer column on mobile
 *
 * @param {HTMLElement} elem
 */
const collapseColumn = (elem) => {
    const column = elem.closest('.footer__column');
    column.classList.remove('footer__column--open');
}

/**
 * Open Footer column on mobile
 *
 * @param {HTMLElement} elem
 */
const expandColumn = (elem) => {
    const column = elem.closest('.footer__column');
    column.classList.add('footer__column--open');
}

/**
 * Toogle Footer column on mobile
 *
 * @param {MouseEvent} ev
 */
const toggleColumn = (ev) => {
    const column = ev.target.closest('.footer__column');
    column.classList.toggle('footer__column--open');
}


/**
 * Handler for viewport change
 *
 * @param {Event} evt
 */
function handleViewportChange(evt) {
    if (evt.matches) {
        // mobile
        document.querySelectorAll('.footer__title').forEach(elem => {
            collapseColumn(elem);
            elem.addEventListener('click', toggleColumn)
        });
    } else {
        // desktop
        document.querySelectorAll('.footer__title').forEach(elem => {
            expandColumn(elem);
            elem.removeEventListener('click', toggleColumn)
        });
    }
}

mediaQueryList.addEventListener('change', handleViewportChange);
handleViewportChange(mediaQueryList);
