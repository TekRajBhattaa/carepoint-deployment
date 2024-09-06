function init() {
    const formater = new Intl.NumberFormat([], {
        style: 'decimal',
        useGrouping: true,
        roundingPriority: "lessPrecision",
        minimumIntegerDigits: 2,
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    });

    const counters = document.querySelectorAll('.counter-item__count-to'),
        speed = 400,
        /**
         * create an IntersectionObserver with the specified callback that will be executed for each intersection change for every counter we have.
         * You may customize the options (2nd argument) per you requirement
         */
        observer = new IntersectionObserver(
            entries => entries.forEach(entry => entry.isIntersecting && animate(entry.target)),
            {
                threshold: 1 // tells the browser that we only need to execute the callback only when an element (counter) is fully visible in the viewport
            }
        ),
        // the animate function now accepts a counter (HTML element)
        animate = counter => {
            const endValue = parseFloat(counter.dataset.counterEnd);
            const startValue = parseFloat(counter.dataset.counterStart);
            const deltaValue = endValue / speed;
            const nextValue = startValue + deltaValue;
            if (nextValue < endValue) {
                counter.innerText = formater.format(nextValue).toString();
                counter.dataset.counterStart = nextValue;
                setTimeout(() => animate(counter), 1);
            } else {
                counter.innerText = formater.format(endValue).toString();
                counter.dataset.counterStart = endValue;
                observer.unobserve(counter);
            }
        };
    // attach the counters to the observer
    counters.forEach(c => observer.observe(c));
}

/**
 * ========== I N I T ==========
 */
window.addEventListener('DOMContentLoaded', init);
