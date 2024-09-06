function toogleButton(ev) {
    const component = ev.target.closest('.toggle-block');
    component.classList.toggle('toggle-block--open');
}

/** ========== I N I T ========== */
const components = document.querySelectorAll('.toggle-block__toggle');
components.forEach(elem => elem.addEventListener('click', toogleButton));
