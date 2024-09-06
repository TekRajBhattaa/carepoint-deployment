import { headroom } from "../header";
import "./hamburger.css";

/**
 * Toggle Mobile Navigation
 *
 */
function toggleMobileNav() {
    const hamburgerToggle = document.querySelector(".header__toggle");
    const headerNav = document.querySelector(".header__menus");

    if (hamburgerToggle && headerNav) {
        headerNav.classList.toggle("header__menus--open");
        hamburgerToggle.setAttribute(
            "aria-expanded",
            hamburgerToggle.getAttribute("aria-expanded") === "false"
                ? "true"
                : "false"
        );
        if (headerNav.classList.contains('header__menus--open')) {
            document.body.style.overflowY = 'hidden';
            if (headroom) headroom.freeze();
        }
        else {
            document.body.style.overflowY = 'auto';
            if (headroom) headroom.unfreeze();
        }
    }
}

/**
 * Event Handler for Small Navigation
 *
 * @param {MouseEvent} ev
 */
function navSmallHandler(ev) {
    const src = ev.target;

    if (src === null) {
        return;
    }

    // Click on navigation links with sub navigation
    if (src.matches(".menu-item-has-children > .primenav-ln")) {
        ev.preventDefault();
        const curListWrapper = src.closest(".primenav__wrapper");
        const nextListWrapper = curListWrapper.nextElementSibling;
        const subMenuWrapper = nextListWrapper.querySelector(
            ".primenav__subwrapper"
        );
        const subNav = src.parentNode
            .querySelector(".primenav-ul")
            .cloneNode(true);
        subMenuWrapper.innerHTML = "";
        subMenuWrapper.append(subNav);
        nextListWrapper.classList.add("primenav__wrapper--visible");
    }

    // Click on "Back" Link
    if (src.matches(".primenav-backlink")) {
        const parent = src.closest(".primenav__wrapper");
        parent.classList.remove("primenav__wrapper--visible");
    }
}

/**
 * Init small navigation
 */
(function () {
    /**
     * Mobile navigation toggle
     */
    const mobileNavToggle = document.querySelector(".header__toggle");
    if (mobileNavToggle) {
        mobileNavToggle.addEventListener("click", toggleMobileNav);
    }

    /**
     * Mobile Navigation
     */
    const listWrapper = document.querySelector(".primenav__wrapper--1");

    // Exit early if there's no navigation markup (e.g. preview site)
    if (listWrapper === null) {
        return;
    }

    // Slide Elements for horizontal slide level 2 + 3
    [2].forEach((num) =>
        listWrapper.insertAdjacentHTML(
            "afterend",
            `<div class="styled-scrollbars primenav__wrapper primenav__wrapper--${num}">
                <button type="button" class="primenav-backlink">
                    <svg class="icon"><use href="/ico.svg#chevron-left"></use></svg> Zurück
                </button>
                <div class="primenav__subwrapper"></div>
             </div>`
        )
    );
})();

export { navSmallHandler };
