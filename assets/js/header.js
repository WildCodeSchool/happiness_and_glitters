const burgerIcon = document.getElementById("burger");
const navbar = document.getElementById("mytopnav");

function displayMenu() {
    console.log("displayed burger");
    navbar.classList.toggle("displayed");
}
console.log("js header.js executé");
burgerIcon.addEventListener("click", displayMenu);
