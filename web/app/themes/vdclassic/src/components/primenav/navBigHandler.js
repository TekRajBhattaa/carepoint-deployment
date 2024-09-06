import { headroom } from "../header";

/**
 * Closes every open sub navigation
 *
 * @param {string} sel - Selector
 */
function closeSubnav(sel = ".primenav-lvl-0--open") {
    document.documentElement.style.overflowY = 'visible';
    document
        .querySelectorAll(sel)
        .forEach((elem) => {
            elem.classList.remove(sel.substring(1))
        });
    document
        .querySelectorAll(".primenav__flyout")
        .forEach((elem) => (elem.style.minHeight = "auto"));

    if (headroom) headroom.unfreeze();
}

function openSubnav(src) {
    document.documentElement.style.overflowY = 'hidden';
    const flyout = src.closest(".primenav-lvl-0");

    if (flyout) {
        flyout.classList.add("primenav-lvl-0--open");
        if (headroom) headroom.freeze();
    }
}

/**
 * Show post thumbnail preview
 *
 * @param {MouseEvent} ev
 */
function showThumbnail(ev) {
    const previewUrl = ev.target.dataset.preview;
    const flyout = ev.target.closest(".menu-tile");
    const image = flyout.querySelector('.menu-tile__thumb > img');
    if (previewUrl && image) {
        // Store original image
        image.setAttribute('data-source-image', image.src);
        // Set new post-thumbnail
        image.src = previewUrl;
    }
}

/**
 * Hide post thumbnail preview
 *
 * @param {MouseEvent} ev
 */
function restoreThumbnail(ev) {
    const flyout = ev.target.closest(".menu-tile");
    const image = flyout?.querySelector('.menu-tile__thumb > img');
    if (image) {
        const sourceImageUrl = image.getAttribute('data-source-image');
        // Restore image
        image.src = sourceImageUrl;
    }
}

/**
 * Event Handler for Big Navigation
 *
 * @param {MouseEvent} ev
 */
function navBigHandler(ev) {
    const src = ev.target;

    if (src === null) {
        return;
    }

    // Click on close button
    if (src.matches(".primenav__close")) {
        closeSubnav();
    }

    // Click on 1st level navigation links
    else if (src.matches(".menu-item-has-children > .primenav-ln--0")) {
        ev.preventDefault();
        const menu = src.parentNode;

        if (menu.classList.contains("primenav-lvl-0--open")) {
            closeSubnav(".primenav-lvl-0--open");
        } else {
            closeSubnav(".primenav-lvl-0--open");
            openSubnav(menu);
        }

        return;
    }

    // Click outside flyout, close flyout
    if (!src.closest(".primenav__inner")) {
        closeSubnav();
    }
}

/**
 * Init large navigation
 */
(function () {
    /**
     * Show/Hide post thumbnail on mouseover of 3rd level navigation links
     */
    document.querySelectorAll(".primenav-ln--2").forEach((elem) => {
        elem.addEventListener("mouseenter", showThumbnail);
        elem.addEventListener("mouseleave", restoreThumbnail);
    });
})()

export { navBigHandler };
