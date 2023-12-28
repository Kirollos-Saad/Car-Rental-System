document.getElementById('admin-form').addEventListener('submit', function(event) {
    event.preventDefault();
    if (validate()) {        
        this.submit();
    } 
});

function validate() {
    var email = document.getElementById("admin-email").value;
    if (email == "" | email == null) {
        alert("Please enter an Email");
        return false
    }

    var password = document.getElementById("admin-password").value;
    if (password == "" | password == null) {
        alert("Please enter a password");
        return false

    }

    return true
}
