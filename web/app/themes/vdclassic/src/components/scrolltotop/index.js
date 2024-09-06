import "./style.css"


const toTop = document.querySelector('.scrolltotop');

if (toTop) {
    window.addEventListener('scroll', () => {
        if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
            toTop.classList.add('scrolltotop--enabled');
        } else {
            toTop.classList.remove('scrolltotop--enabled');
        }
    });
}
