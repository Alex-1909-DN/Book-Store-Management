// Select the input fields by their IDs
let nameInput = document.querySelector("#name");
let emailInput = document.querySelector("#email");
let usernameInput = document.querySelector("#username");
let passwordInput = document.querySelector("#password");
let confirmPasswordInput = document.querySelector("#confirm-password");

// Create global variables for error messages
let defaultMSG = ""; // Default empty message when there's no error
let nameErrorMSG = "Name should not be empty.";
let emailErrorMSG = "Please enter a valid email address.";
let usernameErrorMSG = "Username should be non-empty, and within 30 characters long.";
let passwordErrorMSG = "Password should be at least 8 characters.";
let confirmPasswordErrorMSG = "Passwords do not match.";

// Create error message elements dynamically for each field
let nameError = document.createElement("p");
nameError.setAttribute("class", "warning");

let emailError = document.createElement("p");
emailError.setAttribute("class", "warning");

let usernameError = document.createElement("p");
usernameError.setAttribute("class", "warning");

let passwordError = document.createElement("p");
passwordError.setAttribute("class", "warning");

let confirmPasswordError = document.createElement("p");
confirmPasswordError.setAttribute("class", "warning");

// Method to validate name
function validateName() {
    let name = nameInput.value.trim(); // Get the name input value

    if (name.length > 0) {
        nameError.textContent = ""; // Clear error message if valid
        return true;
    } else {
        nameError.textContent = nameErrorMSG; // Set error message
        nameInput.insertAdjacentElement('afterend', nameError);
        return false;
    }
}

// Method to validate email
function validateEmail() {
    let email = emailInput.value; // Get the email input value
    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Simple email pattern

    if (emailPattern.test(email)) {
        emailError.textContent = ""; // Clear error message if valid
        return true;
    } else {
        emailError.textContent = emailErrorMSG; // Set error message
        emailInput.insertAdjacentElement('afterend', emailError);
        return false;
    }
}

// Method to validate username
function validateUsername() {
    let username = usernameInput.value; // Get the username input value

    if (username.length >= 1 && username.length < 30 && !username.includes(' ')) {
        usernameError.textContent = ""; // Clear error message if valid
        return true;
    } else {
        usernameError.textContent = usernameErrorMSG; // Set error message
        usernameInput.insertAdjacentElement('afterend', usernameError);
        return false;
    }
}

// Method to validate password
function validatePassword() {
    let password = passwordInput.value; // Get the password input value

    if (password.length >= 8) { // Check if password length meets requirement
        passwordError.textContent = ""; // Clear error message if valid
        return true;
    } else {
        passwordError.textContent = passwordErrorMSG; // Set error message
        passwordInput.insertAdjacentElement('afterend', passwordError);
        return false;
    }
}

// Method to validate confirm password
function validateConfirmPassword() {
    let confirmPassword = confirmPasswordInput.value; // Get the confirm password input value
    let password = passwordInput.value; // Get the password input value

    if (confirmPassword === password) { // Check if password and confirm password match
        confirmPasswordError.textContent = ""; // Clear error message if valid
        return true;
    } else {
        confirmPasswordError.textContent = confirmPasswordErrorMSG; // Set error message
        confirmPasswordInput.insertAdjacentElement('afterend', confirmPasswordError);
        return false;
    }
}

// Event listener for form submission (validation)
function validate() {
    let valid = true; // Global validation flag

    // Validate each field and set error message if invalid
    if (!validateName()) {
        valid = false;
    }

    if (!validateEmail()) {
        valid = false;
    }

    if (!validateUsername()) {
        valid = false;
    }

    if (!validatePassword()) {
        valid = false;
    }

    if (!validateConfirmPassword()) {
        valid = false;
    }

    return valid;
}

// Event listeners for blur events to trigger validation immediately when fields lose focus
nameInput.addEventListener("blur", validateName);
emailInput.addEventListener("blur", validateEmail);
usernameInput.addEventListener("blur", validateUsername);
passwordInput.addEventListener("blur", validatePassword);
confirmPasswordInput.addEventListener("blur", validateConfirmPassword);