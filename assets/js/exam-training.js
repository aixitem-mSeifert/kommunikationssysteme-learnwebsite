document.addEventListener('DOMContentLoaded', () => {
    const paper = document.querySelector('.exam-paper');
    const timer = document.getElementById('exam-timer');
    const form = document.getElementById('exam-form');
    let remaining = Number(paper?.dataset.duration || 0) * 60;

    const updateTimer = () => {
        const hours = Math.floor(remaining / 3600);
        const minutes = Math.floor((remaining % 3600) / 60);
        const seconds = remaining % 60;
        if (timer) timer.textContent = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        if (remaining > 0) remaining -= 1;
    };
    if (timer) updateTimer();
    const interval = timer ? window.setInterval(updateTimer, 1000) : null;

    form.addEventListener('submit', (event) => {
        event.preventDefault();
        if (interval) window.clearInterval(interval);
        form.querySelectorAll('.exam-solution').forEach((solution) => { solution.hidden = false; });
        form.querySelectorAll('textarea').forEach((answer) => { answer.readOnly = true; });
        form.querySelector('button[type="submit"]').hidden = true;
        document.getElementById('exam-result').textContent = 'Abgegeben. Vergleichen Sie Ihre Antworten mit den Kriterien und markieren Sie erfüllte Punkte.';
        const progress = JSON.parse(localStorage.getItem('ks-progress') || '{"version":1,"completed":[],"cards":{},"attempts":[]}');
        progress.attempts = [...(progress.attempts || []), { type: 'exam', at: new Date().toISOString() }].slice(-20);
        localStorage.setItem('ks-progress', JSON.stringify(progress));
        form.querySelector('.exam-solution')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
});