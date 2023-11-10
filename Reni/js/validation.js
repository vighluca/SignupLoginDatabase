document.addEventListener('DOMContentLoaded', function () {
    new window.JustValidate('.js-form', {
        rules: {
            email: {
                required: true,
                email: true,
                remote: {
                    url: 'validate-email.php',
                    type: 'GET',
                }
            }
        },
        messages: {
            email: {
                remote: 'Ez az e-mail cím már foglalt.'
            }
        }
    });
});
