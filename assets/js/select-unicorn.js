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
        SelectedByOpponent();
    });
});

function changeSelected(unicornId) {
    select.value = unicornId;
}

// Selection by the opponent

function SelectedByOpponent() {
    let selectOpponent = document.getElementById("opponentUnicorn");
    const rnd = Math.random() * 10;
    if (rnd < 3.3) {
        selectOpponent.value = 1;
    } else if (rnd > 3.3 && rnd < 6.7) {
        selectOpponent.value = 2;
    } else {
        selectOpponent.value = 3;
    }
}
