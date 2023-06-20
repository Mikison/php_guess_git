const points_html = document.getElementById('points-value');
const guesess_html = document.getElementById('guessess-value');
const submitButton = document.getElementById('champion-submit');
const messageDiv = document.getElementById('message');
const giveHintButton = document.getElementById('champion-givehint');
const resetButton = document.getElementById('reset');
const audioDing = new Audio('../3PLAY/ding.wav');


let points = parseInt(points_html.getAttribute('data-initial-points')) || 0;
let guessesRemaining = parseInt(guesess_html.getAttribute('data-initial-guessess')) || 0;
document.addEventListener('keydown', function (event){
    if (event.key === 'Enter') {
        event.preventDefault();
        submitButton.click();
    }
})

function getCookieValue(cookieName) {
    var name = cookieName + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var cookieArray = decodedCookie.split(";");

    for (var i = 0; i < cookieArray.length; i++) {
        var cookie = cookieArray[i].trim();
        if (cookie.indexOf(name) === 0) {
            return cookie.substring(name.length, cookie.length);
        }
    }

    return "";
}

    function updatePoints(number) {
    let number_int = parseInt(number);
    points += number_int;
    points_html.innerText = points;
    points_html.setAttribute('data-initial-points', String(points));
}

function updateGuessess(number) {
    let number_int = parseInt(number);
    guessesRemaining += number_int;
    guesess_html.innerText = guessesRemaining;
    guesess_html.setAttribute('data-initial-guessess', String(guessesRemaining));
}

function createCookie(name, value, minutes) {
    var expires;
    if (minutes) {
        var date = new Date();
        date.setTime(date.getTime() + (minutes * 60 * 60 ));
        expires = "; expires=" + date.toGMTString();
    }
    else {
        expires = "";
    }
    document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
}


function updateDiv(message, color) {
    messageDiv.innerHTML = message;
    messageDiv.style.color = color;
}


function checkGuess(rightGuessString) {
    updateDiv('','');


    const guessString = document.getElementById('champion-input').value.toUpperCase();
    const pattern = /^[A-Z]+$/;

    if (!pattern.test(guessString)) {
        updateDiv('Panie Profesorze, proszę tego nie sprawdzać, bo to jest zrobione po prostu dobrze', 'red');
        return;
    }
    if (guessString.length !== rightGuessString.length) {
        updateDiv('Długość wprowadzonej nazwy nie zgadza się z odpowiedzią! Policz kwadraty :)', '#ff0000');
        return;
    }
    let rightGuess = Array.from(rightGuessString.toUpperCase());
    let currentGuess = Array.from(guessString);

    let boxes = document.querySelectorAll('.boxes .element');
    for (let i = 0; i < rightGuessString.length; i++) {
        let letter = currentGuess[i];
        let box = boxes[i];

        let letterPosition = rightGuess.indexOf(letter);
        if (letterPosition === -1) {
            continue;
        } else {

            if (currentGuess[i] === rightGuess[i]) {
                box.style.backgroundColor = 'rgba(40 86 78)';
                box.innerText = letter;
                rightGuess[letterPosition] = '#';
            }
        }

    }
    if (guessString.toUpperCase() === rightGuessString.toUpperCase()) {
        updateDiv('Gratulacje! Udało ci się zgadnąć! Otrzymujesz ' + points + ' punktów', 'green');
        giveHintButton.setAttribute('disabled', 'true');
        createCookie('points', points, 5);
        resetButton.style.display = 'inline-block';
    } else {

        updatePoints('-15');
        updateGuessess('-1');

        if (guessesRemaining === 0) {
            updateDiv('Niestety, nie udało ci się zgadnąć. Prawidłowa odpowiedź: ' + rightGuessString, '#ff0000');
            giveHintButton.setAttribute('disabled', 'true');
            submitButton.setAttribute('disabled', 'true');
            resetButton.style.display = 'inline-block'

        }

    }
}

function showHint() {
    const divHint1 = document.getElementById('square-hint1');
    const divHint2 = document.getElementById('square-hint2');
    if (divHint1.style.display === 'none') {
        divHint1.style.display = '';
        updatePoints('-10');
        return;
    }
    if (divHint2.style.display === 'none') {
        divHint2.style.display = '';
        updatePoints('-10');
        return;
    }
}

function toggleBoxes() {
    var boxes = document.getElementById('boxes');
    var showBoxesButton = document.getElementById('showBoxes');

    if (boxes.style.display === 'none') {
        boxes.style.display = 'flex';
        showBoxesButton.value = 'Schowaj pomocnika';
    } else {
        boxes.style.display = 'none';
        showBoxesButton.value = 'Pokaż pomocnika';
    }
}

