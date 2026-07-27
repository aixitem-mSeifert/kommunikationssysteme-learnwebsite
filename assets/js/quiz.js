document.addEventListener('DOMContentLoaded', () => {
    const questions = Array.isArray(window.KS_QUIZ) ? window.KS_QUIZ : [];
    const setup = document.getElementById('quiz-setup');
    const stage = document.getElementById('quiz-stage');
    const result = document.getElementById('quiz-result');
    const form = document.getElementById('quiz-form');
    let active = [];
    let current = 0;
    let score = 0;
    let correctIds = [];
    let answers = [];

    const shuffle = (items) => {
        for (let index = items.length - 1; index > 0; index -= 1) {
            const swapIndex = Math.floor(Math.random() * (index + 1));
            [items[index], items[swapIndex]] = [items[swapIndex], items[index]];
        }
        return items;
    };

    const render = () => {
        const question = active[current];
        document.getElementById('quiz-position').textContent = `Frage ${current + 1} von ${active.length}`;
        document.getElementById('quiz-progress').style.width = `${(current / active.length) * 100}%`;
        document.getElementById('quiz-prompt').textContent = question.prompt;
        const options = shuffle(question.options.map((option, index) => ({ option, index })));
        document.getElementById('quiz-options').innerHTML = options.map(({ option, index }) => `<label><input type="radio" name="answer" value="${index}" required><span>${option}</span></label>`).join('');
        document.getElementById('quiz-feedback').hidden = true;
        document.getElementById('quiz-next').hidden = true;
    };

    document.getElementById('quiz-start').addEventListener('click', () => {
        const area = document.getElementById('quiz-area').value;
        const difficulty = document.getElementById('quiz-difficulty').value;
        active = questions.filter((question) => (area === 'all' || question.areaId === area) && (difficulty === 'all' || question.difficulty === difficulty));
        active = shuffle(active);
        current = 0;
        score = 0;
        correctIds = [];
        answers = [];
        setup.hidden = true;
        result.hidden = true;
        stage.hidden = false;
        render();
    });

    document.getElementById('quiz-options').addEventListener('change', () => {
        if (answers[current]) {
            return;
        }

        const choice = Number(new FormData(form).get('answer'));
        const question = active[current];
        const correct = choice === question.correctAnswer;
        answers[current] = { prompt: question.prompt, correct };
        if (correct) {
            score += question.points;
            correctIds.push(question.id);
        }
        form.querySelectorAll('input').forEach((input) => { input.disabled = true; });
        const feedback = document.getElementById('quiz-feedback');
        feedback.className = `quiz-feedback ${correct ? 'is-correct' : 'is-wrong'}`;
        feedback.innerHTML = `<strong>${correct ? 'Richtig' : 'Nicht richtig'}</strong><p>${question.explanation}</p>${question.sourceNote ? `<p class="source-note">${question.sourceNote}</p>` : ''}`;
        feedback.hidden = false;
        document.getElementById('quiz-next').hidden = false;
    });

    document.getElementById('quiz-next').addEventListener('click', () => {
        current += 1;
        if (current < active.length) {
            render();
            return;
        }
        stage.hidden = true;
        result.hidden = false;
        document.getElementById('quiz-score').textContent = `${score} von ${active.length} Punkten`;
        document.getElementById('quiz-summary').textContent = `${Math.round((score / active.length) * 100)} Prozent der Fragen richtig beantwortet.`;
        document.getElementById('quiz-question-summary').innerHTML = answers.map((answer, index) => `<li class="quiz-question-summary-item ${answer.correct ? 'is-correct' : 'is-wrong'}"><span>Frage ${index + 1}</span><strong>${answer.correct ? 'Richtig' : 'Falsch'}</strong><p>${answer.prompt}</p></li>`).join('');
        const progress = JSON.parse(localStorage.getItem('ks-progress') || '{"version":1,"completed":[],"cards":{},"attempts":[]}');
        progress.version = 1;
        progress.completed = [...new Set([...(progress.completed || []), ...correctIds])];
        progress.attempts = [...(progress.attempts || []), { type: 'quiz', score, total: active.length, at: new Date().toISOString() }].slice(-20);
        localStorage.setItem('ks-progress', JSON.stringify(progress));
    });

    document.getElementById('quiz-restart').addEventListener('click', () => {
        result.hidden = true;
        setup.hidden = false;
    });
});