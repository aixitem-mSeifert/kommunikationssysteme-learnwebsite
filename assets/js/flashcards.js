document.addEventListener('DOMContentLoaded', () => {
    const allCards = Array.isArray(window.KS_CARDS) ? window.KS_CARDS : [];
    const select = document.getElementById('card-area');
    let cards = allCards;
    let current = 0;

    const render = () => {
        const card = cards[current];
        document.getElementById('card-position').textContent = card ? `${current + 1} / ${cards.length}` : 'Keine Karten';
        document.getElementById('card-category').textContent = card?.category || '';
        document.getElementById('card-front').textContent = card?.front || 'Keine Karte für diesen Filter';
        document.querySelector('#card-back p').textContent = card?.back || '';
        document.getElementById('card-source-status').textContent = card ? `Quellenstatus: ${card.sourceStatus}` : '';
        document.getElementById('card-back').hidden = true;
        document.getElementById('card-rating').hidden = true;
        document.getElementById('card-reveal').hidden = !card;
    };

    select.addEventListener('change', () => {
        cards = select.value === 'all' ? allCards : allCards.filter((card) => card.areaId === select.value);
        current = 0;
        render();
    });
    document.getElementById('card-reveal').addEventListener('click', () => {
        document.getElementById('card-back').hidden = false;
        document.getElementById('card-rating').hidden = false;
        document.getElementById('card-reveal').hidden = true;
    });
    document.querySelectorAll('[data-rating]').forEach((button) => button.addEventListener('click', () => {
        const card = cards[current];
        const progress = JSON.parse(localStorage.getItem('ks-progress') || '{"version":1,"completed":[],"cards":{},"attempts":[]}');
        progress.cards = { ...(progress.cards || {}), [card.id]: button.dataset.rating };
        localStorage.setItem('ks-progress', JSON.stringify(progress));
        current = (current + 1) % cards.length;
        render();
    }));
    render();
});