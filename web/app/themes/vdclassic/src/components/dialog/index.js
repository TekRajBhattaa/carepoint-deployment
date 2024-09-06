import './style.css';

/**
 * Controls a video inside iframe
 * Ideas taken from https://codepen.io/mcakir/pen/JpQpwm
 *
 * @param {*} action
 * @param {*} src
 */
function messageFn(action, src) {
    if (src.search("vimeo") > 0) { // case for Vimeo
        return JSON.stringify({
            method: action
        });
    }
    else if (src.search("youtube") > 0) { // case for youTube
        return JSON.stringify({
            event: 'command',
            func: action + 'Video'
        });
    }

    // case for other video services (hurriyet videos, dailymotion etc..)
    return action;
}

function init() {
    document.documentElement.addEventListener('click', ev => {
        const target = ev.target;

        if (target.matches('[data-youtube]')) {
            ev.preventDefault();
            const component = target?.closest('article');
            const dialog = component?.querySelector('dialog');
            dialog?.showModal();
        }
        else if (target.matches('.dialog__close') || target.tagName === 'DIALOG') {
            const dialog = target.closest('dialog');
            try {
                const video = dialog.querySelector('.video-container iframe');
                video.contentWindow.postMessage(messageFn('pause', video.src), '*');
            } catch (error) {
                console.warn(error);
            }
            dialog?.close();
        }
    });
}

init();
