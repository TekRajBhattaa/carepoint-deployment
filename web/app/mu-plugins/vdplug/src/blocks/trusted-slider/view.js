import Swiper from "swiper";
/* eslint-disable import/no-unresolved */
import { Navigation, Pagination } from 'swiper/modules';
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";
/* eslint-enable import/no-unresolved */

// Eslint Unable to resolve issue:
// https://github.com/import-js/eslint-plugin-import/issues/2266

import "./swiper-custom.css";
import "./style.css";

function init() {
    for (const sliderElem of document.querySelectorAll(".vdslider")) {
        // Default config for standard slider
        let swiperConf = {
            modules: []
        }

        // Hornetbox slider variant
        if (sliderElem.classList.contains('vdslider--hornetbox')) {
            const spaceBetweenItems = parseFloat(sliderElem.getAttribute('data-spacebetween'))
            const itemsForDesktop = parseFloat(sliderElem.getAttribute('data-maxitems'))
            
            swiperConf = {
                ...swiperConf,
                "slidesPerView": 1.5,
                "spaceBetween": spaceBetweenItems,
                "grabCursor": true,
                "autoplay": true,
                "breakpoints": {
                    "560": {
                        "slidesPerView": 2.5,
                        "spaceBetween": spaceBetweenItems
                    },
                    "768": {
                        "slidesPerView": 2.5,
                        "spaceBetween": spaceBetweenItems
                    },
                    "1024": {
                        "slidesPerView": itemsForDesktop,
                        "spaceBetween": spaceBetweenItems
                    },
                    "1400": {
                        "slidesPerView": itemsForDesktop,
                        "spaceBetween": spaceBetweenItems
                    }
                },
                on: {
                    resize () {
                        resize();
                    },
                }
            }
            resize();
        }

        // Optional navigation
        if (sliderElem.classList.contains('vdslider--has-navigation')) {
            swiperConf.modules.push(Navigation);
            swiperConf.navigation = {
                prevEl: sliderElem.querySelector('.vdslider__nav--prev'),
                nextEl: sliderElem.querySelector('.vdslider__nav--next'),
            }
        }

        // Optional pagination
        if (sliderElem.classList.contains('vdslider--has-pagination')) {
            swiperConf.modules.push(Pagination);
            swiperConf.pagination = {
                el: ".swiper-pagination",
                type: "bullets",
                clickable: true
            };
        }

        // Optional Loop mode
        if (sliderElem.classList.contains('vdslider--has-loop')) {
            swiperConf.loop = true;
        }

        // Init Swiper
        new Swiper(sliderElem.querySelector('.swiper'), swiperConf);
        
    };
}

function resize () {
    for (const sliderElem of document.querySelectorAll(".vdslider--hornetbox")) {
        const sectionStart = document.querySelector(".header-main .header__logo");
        const checkParent = sliderElem.closest(".section:where(.alignwide)");  
        if (checkParent) {
            sliderElem.style.cssText = "margin-left:"+sectionStart.offsetLeft+"px !important; visibility:visible;";
        } else  {
            sliderElem.style.cssText = "visibility:visible;";
        }
    }
}

/** + + + + + +  I N I T  + + + + + + */
window.addEventListener("DOMContentLoaded", init)
