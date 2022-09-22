const form = document.querySelector('#post-form');
let loading = false;

const create = ev => {
    ev.preventDefault();
    clearErrors();

    const form = ev.target;
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
    form.addEventListener('submit', create);
}
