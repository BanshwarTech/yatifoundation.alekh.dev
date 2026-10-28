window.addEventListener('DOMContentLoaded', event => {
    // Simple-DataTables
    // https://github.com/fiduswriter/Simple-DataTables/wiki

    const datatablesSimple = document.getElementById('datatablesSimple');
    if (datatablesSimple) {
        const pageSize = 10;
        const dataTable = new simpleDatatables.DataTable(datatablesSimple, {
            searchable: true,
            sortable: true,
            perPage: pageSize,
            perPageSelect: [10, 25, 50, 100],
            firstLast: true,
            nextPrev: true
        });

        const showSinglePageState = () => {
            const wrapper = datatablesSimple.closest('.datatable-wrapper');
            const bottom = wrapper && wrapper.querySelector('.datatable-bottom');
            const rows = datatablesSimple.tBodies[0]
                ? Array.from(datatablesSimple.tBodies[0].rows).filter(row => !row.classList.contains('datatables-empty'))
                : [];
            const selector = wrapper && wrapper.querySelector('.datatable-selector');
            const selectedPageSize = selector ? Number(selector.value) : pageSize;

            if (!bottom) return;
            const singlePagePagination = bottom.querySelector('.admin-single-page-pagination');
            if (rows.length > selectedPageSize) {
                if (singlePagePagination) singlePagePagination.remove();
                return;
            }
            if (singlePagePagination) return;
            if (bottom.querySelector('.datatable-pagination a')) return;

            const nav = document.createElement('nav');
            nav.className = 'admin-single-page-pagination';
            nav.setAttribute('aria-label', 'Table pagination');
            nav.innerHTML = '<button type="button" disabled aria-label="Previous page">‹</button><button type="button" class="current" aria-current="page" aria-label="Page 1">1</button><button type="button" disabled aria-label="Next page">›</button>';
            bottom.appendChild(nav);
        };

        window.requestAnimationFrame(showSinglePageState);
        dataTable.on('datatable.perpage', () => window.requestAnimationFrame(showSinglePageState));
    }
});
