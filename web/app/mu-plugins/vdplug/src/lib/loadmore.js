/**
 * Load more button handler
 *
 * @param {HTMLButtonElement} btn
 */
async function loadMore(btn) {
    const apiUrl = btn.dataset.query
    const nextPage = parseInt(btn.dataset.nextPage, 10)

    const response = await fetch(`/wp-json${apiUrl}&page=${nextPage}`)
    const data = await response.json()
    const totalPages = parseInt(response.headers.get('x-wp-totalpages'), 10)

    // Update loadmore link
    if (nextPage < totalPages) {
        btn.setAttribute('data-next-page', nextPage + 1)
    }
    else {
        btn.setAttribute('disabled', true)
    }

    return new Promise(function (resolve, reject) {
        if (response.status === 200 && Array.isArray(data)) {
            // return data
            resolve(data, totalPages);
        }
        else {
            reject('error');
        }
    });
}

export { loadMore }
