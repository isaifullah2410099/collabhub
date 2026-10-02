// Small password check for the registration page.
// PHP checks the passwords again when the form is submitted.
const password = document.getElementById('password');
const confirmPassword = document.getElementById('confirm_password');
const passwordMessage = document.getElementById('passwordMessage');

function checkPasswords(){
    // Stop if this page does not have the registration fields.
    if(!password || !confirmPassword || !passwordMessage){
        return;
    }

    if(confirmPassword.value == ''){
        passwordMessage.innerHTML = '';
    }
    else if(password.value == confirmPassword.value){
        passwordMessage.innerHTML = 'Passwords match.';
    }
    else{
        passwordMessage.innerHTML = 'Passwords do not match.';
    }
}

if(password && confirmPassword){
    password.addEventListener('keyup', checkPasswords);
    confirmPassword.addEventListener('keyup', checkPasswords);
}
