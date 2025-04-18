
    document.addEventListener("DOMContentLoaded", function () {
      const signupForm = document.querySelector('form');
      const usernameInput = document.getElementById('username');
      const emailInput = document.getElementById('email');
      const phoneNumberInput = document.getElementById('PhoneNumber');
      const passwordInput = document.getElementById('password');
      const confirmPasswordInput = document.getElementById('confirm-password');

      signupForm.addEventListener('submit', function (event) {
        event.preventDefault();
        clearErrorMessages(); // Clear previous errors
        let isValid = true;

        const username = usernameInput.value.trim();
        const email = emailInput.value.trim();
        const phoneNumber = phoneNumberInput.value.trim();
        const password = passwordInput.value.trim();
        const confirmPassword = confirmPasswordInput.value.trim();

        // Username validation
        if (!/\d/.test(username)) {
          showError(usernameInput, 'Username must contain at least one number for uniqueness.');
          isValid = false;
        }

        // Email validation
        const emailRegex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!emailRegex.test(email)) {
          showError(emailInput, 'Please enter a valid email address.');
          isValid = false;
        }

        // Phone number validation
        const phoneRegex = /^\+8801\d{9}$/;
        if (!phoneRegex.test(phoneNumber)) {
          showError(phoneNumberInput, 'Phone number must start with +8801 and be exactly 14 digits long.');
          isValid = false;
        }

        // Password validation
        const strength = checkPasswordStrength(password);
        if (strength.text === 'Weak') {
          showError(passwordInput, 'Password must be at least Medium strength.');
          isValid = false;
        }
        if (password === username) {
          showError(passwordInput, 'Password must not be the same as the username.');
          isValid = false;
        }

        // Confirm password validation
        if (password !== confirmPassword) {
      showError(confirmPasswordInput, 'Password and Confirm Password must match.');
      isValid = false;
    }

    if (isValid) {
      alert('Account successfully created!');
    }
  });

  // Function to show error message
  function showError(inputElement, message) {
    const errorElement = document.createElement('small');
    errorElement.textContent = message;
    errorElement.style.color = 'red';
    errorElement.style.display = 'block';
    inputElement.parentElement.appendChild(errorElement);
  }

  // Function to clear all error messages
  function clearErrorMessages() {
    const errorMessages = document.querySelectorAll('small');
    errorMessages.forEach((error) => error.remove());
  }

      // Password strength indicator
      passwordInput.addEventListener('input', function () {
        const strengthIndicator = document.getElementById('strength-text') || createStrengthIndicator();
        const password = passwordInput.value;
        const strength = checkPasswordStrength(password);

        strengthIndicator.textContent = `Password Strength: ${strength.text}`;
        strengthIndicator.style.color = strength.color;
      });

      // Create strength indicator
      function createStrengthIndicator() {
        const strengthIndicator = document.createElement('p');
        strengthIndicator.id = 'strength-text';
        passwordInput.parentElement.appendChild(strengthIndicator);
        return strengthIndicator;
      }

      // Check password strength
      function checkPasswordStrength(password) {
        let score = 0;

        if (password.length >= 8) score++;
        if (/[A-Z]/.test(password)) score++;
        if (/[a-z]/.test(password)) score++;
        if (/\d/.test(password)) score++;
        if (/[@$!%*?&#]/.test(password)) score++;

        if (score >= 4) return { text: 'Strong', color: 'green' };
        if (score === 3) return { text: 'Medium', color: 'orange' };
        return { text: 'Weak', color: 'red' };
      }
    });
