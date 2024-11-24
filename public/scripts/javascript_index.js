// Select input fields and form
let usernameInput = document.querySelector("#username");
let passwordInput = document.querySelector("#password");
let form = document.querySelector("form");

// Create dynamic error message elements
let usernameError = document.createElement("p");
usernameError.className = "warning";

let passwordError = document.createElement("p");
passwordError.className = "warning";

// Username validation
function validateUsername() {
    let username = usernameInput.value.trim();
    if (username.length >= 1 && username.length <= 30 && !username.includes(" ")) {
        if (usernameError.parentElement) {
            usernameError.remove();
        }
        return true;
    } else {
        usernameError.textContent = "Username must be non-empty, under 30 characters, and without spaces.";
        if (!usernameError.parentElement) {
            usernameInput.insertAdjacentElement("afterend", usernameError);
        }
        return false;
    }
}

// Password validation
function validatePassword() {
    let password = passwordInput.value.trim();
    if (password.length >= 8) {
        if (passwordError.parentElement) {
            passwordError.remove();
        }
        return true;
    } else {
        passwordError.textContent = "Password must be at least 8 characters.";
        if (!passwordError.parentElement) {
            passwordInput.insertAdjacentElement("afterend", passwordError);
        }
        return false;
    }
}

// Validate form on submission
form.addEventListener("submit", (event) => {
    let isUsernameValid = validateUsername();
    let isPasswordValid = validatePassword();

    if (!isUsernameValid || !isPasswordValid) {
        event.preventDefault();
    }
});

// Validate fields on blur
usernameInput.addEventListener("blur", validateUsername);
passwordInput.addEventListener("blur", validatePassword);