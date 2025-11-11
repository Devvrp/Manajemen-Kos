document.addEventListener('DOMContentLoaded', function() {
    const deleteForms = document.querySelectorAll('form[onsubmit*="confirm"]');
    deleteForms.forEach(form => {
        const confirmMessage = form.getAttribute('onsubmit').match(/return confirm\('(.+?)'\)/);
        const message = (confirmMessage && confirmMessage[1]) ? confirmMessage[1] : 'Anda yakin ingin melanjutkan?';
        form.removeAttribute('onsubmit');
        form.addEventListener('submit', function(event) {
            if (!confirm(message)) {
                event.preventDefault();
            }
        });
    });
});