import './wpml-switch.css';

const wpmlSwitch = document.querySelector('.wpml-switch');

if (wpmlSwitch) {
    wpmlSwitch.addEventListener('change', ev => {
        const link = ev.target.options[ev.target.selectedIndex].value
        location.href = link;
    })
}
