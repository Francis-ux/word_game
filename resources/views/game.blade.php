<!DOCTYPE html>
<html lang="en">

    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Word Typing Game</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>

    <body class="bg-gray-100 flex items-center justify-center h-screen">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-2xl">
            <h1 class="text-2xl font-bold mb-4 text-center">Word Typing Game</h1>
            <div id="game-area" class="text-center">
                <p id="timer" class="text-lg mb-4">Time: 60</p>
                <p id="current-word" class="text-xl font-semibold mb-4"></p>
                <input id="word-input" type="text" class="border p-2 w-full mb-4" placeholder="Type the word here">
                <button id="start-button" class="bg-blue-500 text-white px-4 py-2 rounded">Start Game</button>
                <p id="score" class="mt-4">Score: 0</p>
                <p id="accuracy" class="mt-2">Accuracy: 0%</p>
                <p id="wpm" class="mt-2">WPM: 0</p>
            </div>
            <div id="leaderboard" class="mt-6">
                <h2 class="text-xl font-bold mb-2">Leaderboard</h2>
                <ul id="leaderboard-list" class="list-disc pl-5"></ul>
            </div>
        </div>

        <script>
            let words = [];
            let currentWordIndex = 0;
            let score = 0;
            let correctWords = 0;
            let totalWordsTyped = 0;
            let timeLeft = 60;
            let timer;
            let gameStarted = false;

            const startButton = document.getElementById('start-button');
            const wordInput = document.getElementById('word-input');
            const currentWordElement = document.getElementById('current-word');
            const scoreElement = document.getElementById('score');
            const accuracyElement = document.getElementById('accuracy');
            const wpmElement = document.getElementById('wpm');
            const timerElement = document.getElementById('timer');
            const leaderboardList = document.getElementById('leaderboard-list');

            // Get CSRF token from meta tag (add this in the <head> if not present)
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

            async function startGame() {
                if (gameStarted) return;
                gameStarted = true;
                startButton.disabled = true;
                wordInput.disabled = false;
                wordInput.focus();
                score = 0;
                correctWords = 0;
                totalWordsTyped = 0;
                timeLeft = 60;
                currentWordIndex = 0;
                scoreElement.textContent = 'Score: 0';
                accuracyElement.textContent = 'Accuracy: 0%';
                wpmElement.textContent = 'WPM: 0';
                timerElement.textContent = `Time: ${timeLeft}`;

                try {
                    const response = await fetch('/words');
                    if (!response.ok) throw new Error('Failed to fetch words');
                    words = await response.json();
                    showNextWord();
                } catch (error) {
                    console.error('Error fetching words:', error);
                    alert('Failed to load words. Please try again.');
                    resetGame();
                    return;
                }

                timer = setInterval(() => {
                    timeLeft--;
                    timerElement.textContent = `Time: ${timeLeft}`;
                    if (timeLeft <= 0) {
                        endGame();
                    }
                }, 1000);
            }

            function showNextWord() {
                if (currentWordIndex < words.length) {
                    currentWordElement.textContent = words[currentWordIndex];
                    wordInput.value = '';
                } else {
                    endGame();
                }
            }

            async function endGame() {
                clearInterval(timer);
                gameStarted = false;
                startButton.disabled = false;
                wordInput.disabled = true;
                currentWordElement.textContent = 'Game Over!';
                const accuracy = totalWordsTyped > 0 ? ((correctWords / totalWordsTyped) * 100).toFixed(2) : 0;
                const wpm = ((correctWords / 60) * 60).toFixed(2);
                accuracyElement.textContent = `Accuracy: ${accuracy}%`;
                wpmElement.textContent = `WPM: ${wpm}`;

                const playerName = prompt('Enter your name for the leaderboard:');
                if (playerName) {
                    try {
                        const response = await fetch('/leaderboard', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                            },
                            body: JSON.stringify({
                                player_name: playerName,
                                score,
                                accuracy,
                                wpm
                            }),
                        });
                        if (!response.ok) throw new Error('Failed to save score');
                        await loadLeaderboard();
                    } catch (error) {
                        console.error('Error saving score:', error);
                        alert('Failed to save score. Please try again.');
                    }
                }
            }

            async function loadLeaderboard() {
                try {
                    const response = await fetch('/leaderboard');
                    if (!response.ok) throw new Error('Failed to fetch leaderboard');
                    const scores = await response.json();
                    leaderboardList.innerHTML = '';
                    if (scores.length === 0) {
                        leaderboardList.innerHTML = '<li>No scores yet.</li>';
                        return;
                    }
                    scores.forEach(score => {
                        const li = document.createElement('li');
                        li.textContent =
                            `${score.player_name}: ${score.score} points, ${score.accuracy}% accuracy, ${score.wpm} WPM`;
                        leaderboardList.appendChild(li);
                    });
                } catch (error) {
                    console.error('Error loading leaderboard:', error);
                    leaderboardList.innerHTML = '<li>Error loading leaderboard.</li>';
                }
            }

            wordInput.addEventListener('input', () => {
                if (!gameStarted) return;
                const typedWord = wordInput.value.trim();
                if (typedWord === currentWordElement.textContent) {
                    score += 10;
                    correctWords++;
                    totalWordsTyped++;
                    scoreElement.textContent = `Score: ${score}`;
                    currentWordIndex++;
                    showNextWord();
                } else if (typedWord.length >= currentWordElement.textContent.length) {
                    totalWordsTyped++;
                    currentWordIndex++;
                    showNextWord();
                }
                const accuracy = totalWordsTyped > 0 ? ((correctWords / totalWordsTyped) * 100).toFixed(2) : 0;
                accuracyElement.textContent = `Accuracy: ${accuracy}%`;
            });

            startButton.addEventListener('click', startGame);

            // Load leaderboard on page load
            loadLeaderboard();

            function resetGame() {
                clearInterval(timer);
                gameStarted = false;
                startButton.disabled = false;
                wordInput.disabled = true;
                currentWordElement.textContent = '';
            }
        </script>
    </body>

</html>
