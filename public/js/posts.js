const form = document.querySelector('#post-form');
let loading = false;

let intervalId;

const progressStart = (progressBar) => {
    progressBar.classList.remove('d-none');
    const innerBar = progressBar.querySelector('div.progress-bar');

    innerBar.style.width = '15%';
    innerBar.setAttribute('aria-valuenow', '15');
    innerBar.innerHTML = '15%';

    intervalId = setInterval(() => {
        let value = +innerBar.getAttribute('aria-valuenow');
        value += Math.floor(Math.random() * 10) + 8;

        if (value >= 100) {
            value = 99;
        }

        innerBar.style.width = value + '%';
        innerBar.setAttribute('aria-valuenow', value);
        innerBar.innerHTML = value + '%';
    }, 300);
};

const progressFinish = (progressBar) => {
    clearInterval(intervalId);
    const innerBar = progressBar.querySelector('div.progress-bar');

    innerBar.style.width = '100%';
    innerBar.setAttribute('aria-valuenow', '100');
    innerBar.innerHTML = '100%';

    setTimeout(() => {
        progressBar.classList.add('d-none');
    }, 750);
};

const create = ev => {
    ev.preventDefault();
    clearErrors();

    const form = ev.target;
    const submitBtn = form.querySelector('button[type="submit"]');
    const progressBar = form.querySelector('div.progress');

    submitBtn.setAttribute('disabled', 'true');
    progressStart(progressBar);

    const data = {
        titulo: document.querySelector('#titulo')?.value,
        descricao: document.querySelector('#descricao')?.value,
        imagem: document.querySelector('#imagem')?.files[0],
    };

    const formData = new FormData();

    for (let key in data) {
        formData.append(key, data[key]);
    }

    fetch(form.action, {
        method: 'post',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: formData
    })
        .then(response => {
            return response.json();
        })
        .then(data => {
            if (data.errors) {
                displayErrors(data.errors);
                return;
            }

            if (!data.result) {
                showAlert(data.message, 'danger');
                return;
            }

            location.href = '/home';
        })
        .catch(() => {
            showAlert('Não foi possível cadastrar a postagem. Por favor, tente novamente.', 'danger');
        })
        .finally(() => {
            progressFinish(progressBar);
            submitBtn.removeAttribute('disabled');
        });
};

const update = ev => {
    ev.preventDefault();
    clearErrors();

    const form = ev.target;
    const submitBtn = form.querySelector('button[type="submit"]');
    const progressBar = form.querySelector('div.progress');

    submitBtn.setAttribute('disabled', 'true');
    progressStart(progressBar);

    const data = {
        titulo: document.querySelector('#titulo')?.value,
        descricao: document.querySelector('#descricao')?.value,
        imagem: document.querySelector('#imagem').files[0] ?? null,
        _method: 'put'
    };

    const formData = new FormData();

    for (let key in data) {
        if (data[key] == null) continue;

        formData.append(key, data[key]);
    }

    fetch(form.action, {
        method: 'post',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: formData
    })
        .then(response => {
            return response.json();
        })
        .then(data => {
            if (data.errors) {
                displayErrors(data.errors);
                return;
            }

            if (!data.result) {
                showAlert(data.message, 'danger');
                return;
            }

            location.href = '/home';
        })
        .catch(() => {
            showAlert('Não foi possível editar a postagem. Por favor, tente novamente.', 'danger');
        })
        .finally(() => {
            progressFinish(progressBar);
            submitBtn.removeAttribute('disabled');
        });
};

const destroy = (element) => {
    if (loading) return;
    if (!confirm('Tem certeza que deseja deletar esta postagem?')) return;

    loading = true;

    const url = element.dataset.url;
    const options = {
        method: 'delete',
        headers: {
            'Accept': 'application/json'
        }
    };

    request(url, options)
        .then(data => {
            if (!data.result) {
                showAlert(data.message, 'danger');
                return;
            }

            showAlert('A postagem foi deletada com sucesso.', 'success');
            element.closest('div.post-item').remove();
        })
        .catch(() => {
            showAlert('Não foi possível deletar a postagem. Por favor, tente novamente.', 'danger');
        })
        .finally(() => {
            loading = false;
        });
};

const publish = (element) => {
    if (loading) return;
    if (!confirm('Tem certeza que deseja publicar esta postagem?')) return;

    loading = true;

    const url = element.dataset.url;
    const options = {
        method: 'put',
        headers: {
            'Accept': 'application/json'
        }
    };

    request(url, options)
        .then(data => {
            if (data.result) {
                element.remove();
            }

            const color = data.result ? 'success' : 'danger';

            showAlert(data.message, color);
        })
        .catch(() => {
            showAlert('Não foi possível publicar a postagem. Por favor, tente novamente.', 'danger');
        })
        .finally(() => {
            loading = false;
        });
};

if (form) {
    const frmRole = form.dataset.role;
    let handleSubmit;

    if (frmRole === 'create') {
        handleSubmit = create;
    }

    if (frmRole === 'update') {
        handleSubmit = update;
    }

    form.addEventListener('submit', handleSubmit);
}
