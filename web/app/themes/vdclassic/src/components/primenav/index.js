import { navBigHandler } from "./navBigHandler";
import { navSmallHandler } from "./navSmallHandler";
import "./primenav.css";
import './menu-tile.css';

/**
 * Add a event for hozizontal sliding menu (mobile) or mega menu (tablet + desktop)
 *
 * @param {MouseEvent} ev - Event
 */
function viewportCheckHandler(ev) {
    const headerNavigation = document.querySelector(".header__primenav");

    if (!headerNavigation) {
        console.warn("No Header Navigation found...");
        return;
    }

    if (ev.matches) {
        /* The viewport is 991 pixels wide or less */
        // Remove Desktop Events
        document.body.removeEventListener("click", navBigHandler);
        // Add Mobile Events
        document.body.addEventListener("click", navSmallHandler);
    } else {
        /* The viewport is more than 991 pixels wide */

        // Add Desktop Events
        // We must append click to body so we can close the navigation with a click outside
        document.body.addEventListener("click", navBigHandler);
        // Remove Mobile Events
        document.body.removeEventListener("click", navSmallHandler);
    }
}

/**
 * Init primary navigation
 */
(function () {
    /**
     * Responsive Mobile Mega Menu ^+^
     */
    const mql = window.matchMedia("(max-width: 991px)");
    mql.addEventListener("change", viewportCheckHandler);
    viewportCheckHandler(mql);

    /*
     * Flat style - We need a different layout if not more then 2 level navigation
     */
    document.querySelectorAll('.primenav-lvl-0').forEach(
        elem => elem.querySelector('.primenav-ul--1') === null ? elem.classList.add('primenav--flat') : null
    );
})()
