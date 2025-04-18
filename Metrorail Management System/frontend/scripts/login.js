// Select the form element


const loginForm = document.querySelector('form');

// Add an event listener to handle form submission
loginForm.addEventListener('submit', function (event) {
    // Prevent the default form submission behavior
    event.preventDefault();

    // Get the email and password input values
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();

    // Perform basic validation
    if (!email) {
        alert('Please enter your email or phone number.');
        return;
    }

    if (!password) {
        alert('Please enter your password.');
        return;
    }

    // Simulate authentication (replace with real API call)
    const user = {
        email: "test@example.com", // Replace with your backend logic
        password: "password123"   // Replace with your backend logic
    };

    if (email === user.email && password === user.password) {
        alert('Login successful!');
        // Redirect to the dashboard or another page
        window.location.href = 'dashboard.html'; // Replace with your actual dashboard page
    } else {
        alert('Invalid email or password. Please try again.');
    }
});
