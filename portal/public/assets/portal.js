'use strict';
const search = document.getElementById('course-search');
if (search) {
    const cards = Array.from(document.querySelectorAll('.course-card'));
    const filter = () => {
        const term = search.value.trim().toLowerCase();
        let shown = 0;
        cards.forEach(card => {
            card.hidden = !card.dataset.search.includes(term);
            if (!card.hidden) shown++;
        });
        document.getElementById('search-status').textContent = `${shown} course${shown === 1 ? '' : 's'} found`;
        document.getElementById('no-results').hidden = shown !== 0;
    };
    search.addEventListener('input', filter);
}
document.querySelectorAll('.delete-course').forEach(form => {
    form.addEventListener('submit', event => {
        if (!window.confirm('Delete this course and all of its registrations? This cannot be undone.')) event.preventDefault();
    });
});
