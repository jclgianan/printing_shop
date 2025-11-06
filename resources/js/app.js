require('./bootstrap');

document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('registerModal');
    const signupButton = document.querySelector('.signup-btn');

    if (modal && signupButton) {
        signupButton.addEventListener('click', (event) => {
            event.preventDefault();
            modal.classList.add('active');
        });

        modal.addEventListener('click', (event) => {
            if (event.target === modal || event.target.classList.contains('close')) {
                modal.classList.remove('active');
            }
        });
    }
});

// Make sure modal close button works after error messages
document.addEventListener('DOMContentLoaded', function () {
    const closeBtn = document.querySelector('#registerModal .close');
    const modal = document.getElementById('registerModal');

    if (closeBtn && modal) {
        closeBtn.addEventListener('click', function () {
            modal.style.display = 'none';
        });
    }

    
});

