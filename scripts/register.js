document.getElementById('registrationForm').addEventListener('submit', function(event) {
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirm_password').value;
    var dateOfBirth = document.getElementById('data_nascita').value;
    var phone = document.getElementById('telefono').value;

    // Controllo se le password corrispondono
    if (password !== confirmPassword) {
        alert('Le password non corrispondono.');
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
        alert('Devi essere maggiorenne per registrarti.');
        event.preventDefault();
        return;
    }

    // Controllo se il telefono ha 10 cifre
    if (phone.length !== 10) {
        alert('Il numero di telefono deve avere 10 cifre.');
        event.preventDefault();
        return;
    }

    // Controllo se la mail è valida
    var emailRegex = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/;
    if (!emailRegex.test(email)) {
        alert('Inserisci un indirizzo email valido.');
        event.preventDefault();
        return;
    }

    // Controllo se la password ha almeno 8 caratteri
    var password = document.getElementById('password').value;
    if (password.length < 8) {
        alert('La password deve avere almeno 8 caratteri.');
        event.preventDefault();
        return;
    }
});