import "./style.css"

document.querySelectorAll('.searchandfilter ul li h4').forEach(function(i) {
    i.addEventListener('click', function() {
        i.closest('li').classList.toggle("open");
    })
});

document.body.addEventListener("click", function (event){
    if( event.target.id === 'job--search-button' ) {
        event.preventDefault();
        const searchdata = document.querySelector('body .job-search-form input').value
        const searchElement = document.querySelector('body .searchandfilter .sf-input-text');
        searchElement.value = searchdata;
        document.querySelector('body .searchandfilter').dispatchEvent(new Event ("submit"));
    }
    if( event.target.id === 'reset-button' ) {
        document.querySelector('.search-filter-reset').dispatchEvent(new Event ("click"));
        event.preventDefault();
    }
});

document.querySelectorAll('.gform_footer').forEach(function(i) {
    i.classList.add("gform-footer");
});

