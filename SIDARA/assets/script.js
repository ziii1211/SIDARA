const togglePassword = document.querySelector('#togglePassword');
const password = document.querySelector('#kata_sandi');

if (togglePassword) {
    togglePassword.addEventListener('click', function (e) {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('bx-hide');
        this.classList.toggle('bx-show');
    });
}

let sidebar = document.querySelector(".sidebar");
let sidebarBtn = document.querySelector(".sidebarBtn");

if (sidebarBtn) {
    sidebarBtn.addEventListener("click", () => {
        sidebar.classList.toggle("close");
    });
}

let arrow = document.querySelectorAll(".arrow");
for (var i = 0; i < arrow.length; i++) {
    arrow[i].addEventListener("click", (e) => {
        let arrowParent = e.target.parentElement.parentElement;
        arrowParent.classList.toggle("showMenu");
    });
}