import './icon.css';

const icon = (name, classes = '') =>
    `<svg class="icon icon-${name} ${classes}"><use href="/ico.svg#${name}"></use></svg>`;

export { icon };
