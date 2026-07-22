document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.querySelector('.nav-toggle');
    const navigation = document.querySelector('.site-nav');

    toggle?.addEventListener('click', () => {
        const expanded = toggle.getAttribute('aria-expanded') === 'true';
        toggle.setAttribute('aria-expanded', String(!expanded));
        navigation?.classList.toggle('is-open', !expanded);
    });

    document.querySelectorAll('[data-filter-input]').forEach((input) => {
        input.addEventListener('input', () => {
            const target = document.getElementById(input.dataset.filterInput);
            const query = input.value.trim().toLocaleLowerCase('de');
            target?.querySelectorAll('[data-filter-text]').forEach((item) => {
                const area = target.dataset.activeArea || '';
                item.hidden = !item.dataset.filterText.toLocaleLowerCase('de').includes(query) || (area && item.dataset.areaId !== area);
            });
        });
    });

    document.querySelectorAll('[data-area-filter]').forEach((select) => {
        select.addEventListener('change', () => {
            const target = document.getElementById(select.dataset.areaFilter);
            if (!target) return;
            target.dataset.activeArea = select.value;
            const search = document.querySelector(`[data-filter-input="${select.dataset.areaFilter}"]`);
            search?.dispatchEvent(new Event('input'));
        });
    });

    const progress = JSON.parse(localStorage.getItem('ks-progress') || '{"completed":[]}');
    const overall = document.getElementById('overall-progress');
    if (overall && Array.isArray(progress.completed)) {
        const questionCount = Number(overall.dataset.questionCount) || 1;
        overall.textContent = `${Math.min(100, Math.round((progress.completed.length / questionCount) * 100))} %`;
    }
});