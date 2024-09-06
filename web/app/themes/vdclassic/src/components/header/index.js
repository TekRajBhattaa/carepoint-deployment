import './header.css';
import './header-top.css';
import './header-main.css';
import './headroom.css';
import Headroom from "headroom.js";

const header = document.querySelector(".header");
let headroom = null;
if (header) {
    headroom = new Headroom(header, {
        offset: {
            down: -1 * header.scrollHeight,
            up: 0,
        },
        tolerance: 1,
    });
    headroom.init();

    const searchToggle = document.querySelector('.header__toggle--search');
    if (searchToggle) {
        searchToggle.addEventListener('click', ev => {
            const topNav = document.querySelector('.header__topnav');
            const searchContainer = ev.target.previousElementSibling;
            topNav.style.visibility = 'hidden';
            searchContainer.classList.toggle('searchcomplete--open');
            searchContainer.querySelector('input').focus();
        })
    }
}

export { headroom }
