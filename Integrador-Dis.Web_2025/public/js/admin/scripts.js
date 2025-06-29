function fillFormFields(user) {
    const fields = ['role', 'dni', 'name', 'surname', 'gender', 'birth_date', 'email', 'address', 'phone'];
    fields.forEach(field => {
        const el = document.getElementById(field);
        if (el) el.value = user[field] || '';
    });
}

function setButtonText(formId, text) {
    const btn = document.querySelector(`#${formId} form button[type="submit"]`);
    if (btn) btn.textContent = text;
}

function editUser(userId) {
    clearErrors();
    fetch(`/admin/users/${userId}/edit`)
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                document.getElementById('user_id').value = data.user.id;
                fillFormFields(data.user);
                const edition = document.getElementById('edition');
                edition.style.display = 'block';
                edition.scrollIntoView({ behavior: 'smooth' });
                setButtonText('edition', 'Actualizar Usuario');
            } else {
                showAjaxError([data.message]);
            }
        })
        .catch(error => {
            console.error('Error al editar el usuario:', error);
            showAjaxError(['Error al cargar los datos del usuario. Por favor, inténtelo de nuevo más tarde.']);
        });
}

function cancelEdit() {
    document.getElementById('edition-form').reset();
    document.getElementById('user_id').value = '';
    clearErrors();
    document.getElementById('edition').style.display = 'none';
    setButtonText('edition', 'Crear Usuario');
}

function showAjaxError(errors) {
    const errorDiv = document.getElementById('ajax-errors');
    const errorList = document.getElementById('ajax-error-list');
    errorList.innerHTML = '';
    for (const error of errors) {
        const li = document.createElement('li');
        li.textContent = error;
        errorList.appendChild(li);
    }
    errorDiv.style.display = 'block';
    errorDiv.scrollIntoView({ behavior: 'smooth' });
}

function clearErrors() {
    document.getElementById('ajax-errors').style.display = 'none';
    document.querySelectorAll('.error-field').forEach(f => f.classList.remove('error-field'));
    document.querySelectorAll('.error-message').forEach(m => m.style.display = 'none');
}

function showCreateForm() {
    clearErrors();
    const creation = document.getElementById('creation');
    creation.style.display = 'block';
    creation.scrollIntoView({ behavior: 'smooth' });
}

function hideCreateForm() {
    document.getElementById('creation').style.display = 'none';
    document.querySelector('#creation form').reset();
    clearErrors();
}

document.addEventListener('DOMContentLoaded', function() {
    const createForm = document.querySelector('#creation form');
    if (createForm) {
        createForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    data.errors ? showValidationErrors(data.errors) : showAjaxError([data.message]);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAjaxError(['Error de conexión. Por favor, inténtelo de nuevo.']);
            });
        });
    }
});

function showValidationErrors(errors) {
    clearErrors();
    const errorList = [];
    for (const field in errors) {
        const el = document.querySelector(`[name="${field}"]`);
        if (el) el.classList.add('error-field');
        errorList.push(...errors[field]);
    }
    showAjaxError(errorList);
}
