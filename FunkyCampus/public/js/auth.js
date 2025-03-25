document.addEventListener('DOMContentLoaded', function () {

    // Toggle Password
    function passwordToggle(passwordFieldSelector, toggleButtonSelector) {
        const passwordField = document.querySelector(passwordFieldSelector);
        const toggleButton = document.querySelector(toggleButtonSelector);

        if (passwordField && toggleButton) {
            const icon = toggleButton.querySelector('i');

            toggleButton.addEventListener('click', function () {
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });
        }
    }

    passwordToggle('#password', '.password-field:nth-of-type(1) .toggle-password');
    passwordToggle('#confirm_password', '.password-field:nth-of-type(2) .toggle-password');

    // Consts
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirm_password'); // Может быть null
    const signupButton = document.getElementById('btn-signup');
    const loginButton = document.getElementById('btn-login');
    const restoreButton = document.getElementById('btn-restore');
    const resetButton = document.getElementById('btn-reset');
    const patternMessage = document.getElementById('password-pattern-message');
    const mismatchMessage = document.getElementById('password-mismatch-message');

    // Email Validation
    function validateEmail(email) {
        const emailPattern = /^(([^<>()[\].,;:\s@"]+(\.[^<>()[\].,;:\s@"]+)*)|(".+"))@(([^<>()[\].,;:\s@"]+\.)+[^<>()[\].,;:\s@"]{2,})$/iu;
        return emailPattern.test(email);
    }

    // Password Validation
    function validatePassword(password) {
        const hasLetters = /[a-zA-Z]/.test(password);
        const hasDigits = /[0-9]/.test(password);
        return password.length >= 8 && hasLetters && hasDigits;
    }

    // Проверяем, совпадают ли пароли (если поле confirmPassword присутствует)
    function passwordsMatch() {
        if (!confirmPasswordInput) return true;  // Если confirmPasswordInput не существует, возвращаем true
        return passwordInput.value === confirmPasswordInput.value;
    }

    // Update Buttons
    function updateButtonState() {
        const email = emailInput ? emailInput.value.trim() : '';
        const password = passwordInput ? passwordInput.value.trim() : '';
        const isEmailValid = validateEmail(email);
        const isPasswordValid = validatePassword(password);
        const doPasswordsMatch = passwordsMatch();

        if (loginButton) {
            loginButton.disabled = !(isEmailValid && isPasswordValid);
        }

        if (signupButton) {
            signupButton.disabled = !(isEmailValid && isPasswordValid && doPasswordsMatch);
        }

        if (restoreButton) {
            restoreButton.disabled = !(isEmailValid || (isPasswordValid && doPasswordsMatch));
        }

        if (resetButton) {
            resetButton.disabled = !(email || password || (confirmPasswordInput && confirmPasswordInput.value));
        }

        if (patternMessage) {
            patternMessage.style.display = isPasswordValid ? 'none' : 'block';
        }

        if (mismatchMessage) {
            mismatchMessage.style.display = passwordsMatch() ? 'none' : 'block';
        }
    }

    // Event Listeners
    if (emailInput) emailInput.addEventListener('input', updateButtonState);
    if (passwordInput) passwordInput.addEventListener('input', updateButtonState);
    if (confirmPasswordInput) confirmPasswordInput.addEventListener('input', updateButtonState);

    if (resetButton) {
        resetButton.addEventListener('click', function () {
            if (emailInput) emailInput.value = '';
            if (passwordInput) passwordInput.value = '';
            if (confirmPasswordInput) confirmPasswordInput.value = '';
            updateButtonState();
        });
    }

    // Initial state check
    updateButtonState();
});
