let textDiv = document.getElementById("paragraphs-flip"); //catches the flip-text ID
let cardDiv = document.getElementById("card-flip"); //catches the card-flip ID
let blink = document.getElementById("blink"); //catches the blinking paragraph
let textDivContent = textDiv.innerHTML;
let cardDivContent = cardDiv.innerHTML;

function flipWithTimeout() {
    if (cardDiv.innerHTML === cardDivContent) {
        cardDiv.classList.add('flip-2-ver-right-2');
        blink.innerHTML = "<p>Clique sur le texte !</p>";
        setTimeout(removeClass, 450);
        cardDiv.innerHTML = textDivContent;
    } else {
        cardDiv.classList.add('flip-2-ver-right-2');
        blink.innerHTML = "<p>Clique sur la licorne !</p>";
        setTimeout(removeClass, 450);
        cardDiv.innerHTML = cardDivContent;
    }
}

function removeClass() {
    cardDiv.classList.remove('flip-2-ver-right-2');
}

cardDiv.addEventListener('click', flipWithTimeout);
