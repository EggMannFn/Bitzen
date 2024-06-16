document.getElementById('registrationForm').addEventListener('submit', function(event) {
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirm_password').value;
    var dateOfBirth = document.getElementById('data_nascita').value;
    var phone = document.getElementById('telefono').value;

    // Controllo se le password corrispondono
    if (password !== confirmPassword) {
        alert('Passwords do not correspond.');
        event.preventDefault();
        return;
    }

    // Controllo se l'utente è maggiorenne
    var today = new Date();
    var birthDate = new Date(dateOfBirth);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    if (age < 18) {
        alert('You have to be older than 18 to register.');
        event.preventDefault();
        return;
    }

    // Controllo se il telefono ha 10 cifre
    if (phone.length !== 10) {
        alert('Phone number should have 10 digits.');
        event.preventDefault();
        return;
    }

    // Controllo se la mail è valida
    var emailRegex = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/;
    if (!emailRegex.test(email)) {
        alert('Insert a valid email address.');
        event.preventDefault();
        return;
    }

    // Controllo se la password ha almeno 8 caratteri
    var password = document.getElementById('password').value;
    if (password.length < 8) {
        alert('Password should have minimum 8 characters.');
        event.preventDefault();
        return;
    }
});