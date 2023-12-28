document.getElementById('signin-form').addEventListener('submit', function(event) {
    event.preventDefault();
    if (validate()) {        
        this.submit();
    } 
});

function validate() {
    var email = document.getElementById("signin-email").value;
    if (email == "" | email == null) {
        alert("Please enter an Email");
        return false
    }

    var password = document.getElementById("signin-password").value;
    if (password == "" | password == null) {
        alert("Please enter a password");
        return false

    }

    return true
}
window.onload = function() {
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('signup') === 'success') {
        alert('User signed up successfully.');
    }
}