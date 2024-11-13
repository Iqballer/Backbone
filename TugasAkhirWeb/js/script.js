document.addEventListener('DOMContentLoaded', () => {
    const loginBtn = document.getElementById('loginBtn');
    const registerBtn = document.getElementById('registerBtn');
    const loginPopup = document.getElementById('loginPopup');
    const registerPopup = document.getElementById('registerPopup');
    const closeLogin = document.getElementById('closeLogin');
    const closeRegister = document.getElementById('closeRegister');

    loginBtn.addEventListener('click', () => {
        loginPopup.style.display = 'block';
    });

    registerBtn.addEventListener('click', () => {
        registerPopup.style.display = 'block';
    });

    closeLogin.addEventListener('click', () => {
        loginPopup.style.display = 'none';
    });

    closeRegister.addEventListener('click', () => {
        registerPopup.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target == loginPopup) {
            loginPopup.style.display = 'none';
        }
        if (event.target == registerPopup) {
            registerPopup.style.display = 'none';
        }
    });
});