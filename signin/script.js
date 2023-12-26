document.getElementById('signin-form').addEventListener('submit', function(event) {
    event.preventDefault();

    var username = document.getElementById('signin-username').value;
    var password = document.getElementById('signin-password').value;

    console.log('Sign in form submitted with username ' + username + ' and password ' + password);
});