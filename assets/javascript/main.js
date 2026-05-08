window.addEventListener('scroll', function () {
    const nav = document.querySelector('nav');
    if (window.scrollY > 50) {
        nav.classList.add('bg-dark', 'shadow');
    } else {
        nav.classList.remove('bg-dark', 'shadow');
    }
});
/**
 * WOWFOOD Main JavaScript
 * Handles Signup Validation and UI interactions
 */

/**
 * WOWFOOD Main JavaScript
 * Reorganized for Internal Password Toggles & Real-time Validation
 */

document.addEventListener('DOMContentLoaded', function() {
    // 1. Password Visibility Toggle (Now targets the icon directly)
    initPasswordToggle();

    // 2. Real-time Email Format Check
    initEmailValidation();

    // 3. Password & Confirm Match Check
    initPasswordMatchValidation();
});

/**
 * Handles clicking the eye icon inside the password fields
 */
function initPasswordToggle() {
    // Select the icons directly since we removed the button wrapper
    const toggleIcons = document.querySelectorAll('.password-toggle-icon');
    
    toggleIcons.forEach(icon => {
        icon.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);

            if (!input) return;

            if (input.type === 'password') {
                input.type = 'text';
                this.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                input.type = 'password';
                this.classList.replace('bi-eye-slash', 'bi-eye');
            }
        });
    });
}

/**
 * Validates email format as the user types
 */
function initEmailValidation() {
    const emailInput = document.getElementById('email');
    const feedback = document.getElementById('emailFeedback');
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailInput || !feedback) return;

    emailInput.addEventListener('input', function() {
        const value = this.value.trim();
        if (value === "") {
            updateUI(this, feedback, "", "");
        } else if (emailPattern.test(value)) {
            updateUI(this, feedback, "Email format looks correct.", "text-success", true);
        } else {
            updateUI(this, feedback, "Please enter a valid email address.", "text-danger", false);
        }
    });
}

/**
 * Ensures Password and Confirm Password are identical
 */
function initPasswordMatchValidation() {
    const pass = document.getElementById('password');
    const confirm = document.getElementById('confirm_password');
    const feedback = document.getElementById('confirmFeedback');

    if (!pass || !confirm || !feedback) return;

    const validate = () => {
        const p1 = pass.value;
        const p2 = confirm.value;

        if (p2 === "") {
            updateUI(confirm, feedback, "", "");
        } else if (p1 === p2) {
            updateUI(confirm, feedback, "Passwords match!", "text-success", true);
        } else {
            updateUI(confirm, feedback, "Passwords do not match.", "text-danger", false);
        }
    };

    pass.addEventListener('input', validate);
    confirm.addEventListener('input', validate);
}

/**
 * Helper: Updates Bootstrap classes and feedback text
 */
function updateUI(input, feedbackElement, message, textClass, isValid = null) {
    if (!feedbackElement) return;
    
    feedbackElement.innerHTML = message;
    feedbackElement.className = `small mt-1 ${textClass}`;
    
    if (isValid === true) {
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
    } else if (isValid === false) {
        input.classList.remove('is-valid');
        input.classList.add('is-invalid');
    } else {
        input.classList.remove('is-valid', 'is-invalid');
    }
}