// Select and update the chosen unicorn by the user
const unicorns = document.querySelectorAll(".unicorn");
let select = document.getElementById("userUnicorn");

unicorns.forEach((unicorn) => {
    unicorn.addEventListener("click", () => {
        changeSelected(unicorn.id);
        unicorn.classList.toggle("shadow-drop-2-center");
        unicorns.forEach((unicorn) => {
            if (select.value != unicorn.id) {
                unicorn.classList.toggle("opacity-low");
            }
        });
    });
});

function changeSelected(unicornId) {
    select.value = unicornId;
}

// Selection by the opponent

const SelectedByOpponent = () => {
    let selectOpponent = document.getElementById("opponentUnicorn");
    if (Math.random() * 10 < 3.3) {
        selectOpponent.value = 1;
    } else if (Math.random() * 10 > 3.3 && Math.random() * 10 < 6.7) {
        selectOpponent.value = 2;
    } else {
        selectOpponent.value = 3;
    }
};

SelectedByOpponent();
