document.getElementById('signup-form').addEventListener('submit', function(event) {
    event.preventDefault();

    var username = document.getElementById('signup-username').value;
    var email = document.getElementById('signup-email').value;
    var phone = document.getElementById('signup-phone').value;
    var country = document.getElementById('signup-country').value;
    var city = document.getElementById('signup-city').value;
    var password = document.getElementById('signup-password').value;
    var confirmPassword = document.getElementById('signup-confirm-password').value;

    if (!username) {
        alert('Please enter your name.');
        return;
    }

    if (!email) {
        alert('Please enter your email.');
        return;
    }

    if (!phone) {
        alert('Please enter your phone number.');
        return;
    }

    if (!country) {
        alert('Please enter your country.');
        return;
    }

    if (!city) {
        alert('Please enter your city.');
        return;
    }

    if (!password) {
        alert('Please enter your password.');
        return;
    }

    if (password !== confirmPassword) {
        alert('Passwords do not match.');
        return;
    }

    alert('User signed up successfully.');
});