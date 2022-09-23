const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

const showAlert = (message, color) => {
    const alert = document.querySelector('#alert');

    alert.classList.remove('hide-alert', 'alert-danger', 'alert-success');
    alert.classList.add('show-alert', 'alert-' + color);

    alert.querySelector('span.alert-text').innerHTML = message;
};

const hideAlert = (button) => {
    const alert = button.closest('div.alert');

    alert.classList.add('hide-alert');
    alert.classList.remove('show-alert');
};

const displayErrors = errors => {
    for (const error in errors) {
        const input = document.querySelector(`[name="${error}"]`);
        const div = document.querySelector(`[name="${error}"] + div.error-message`);

        div.innerHTML = errors[error][0] ?? '';
        input.classList.add('is-invalid');
    }
};

const clearErrors = () => {
    document.querySelectorAll('.is-invalid').forEach(input => {
        input.classList.remove('is-invalid');
        const div = input.nextElementSibling;

        div.innerHTML = '';
    });
};

const request = async (url, options) => {
    if (!options.headers['X-CSRF-TOKEN']) {
        options.headers['X-CSRF-TOKEN'] = csrfToken;
    }

    const response = await fetch(url, options);

    return await response.json();
};
