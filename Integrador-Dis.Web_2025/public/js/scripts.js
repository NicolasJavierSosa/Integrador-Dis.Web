const courses = [
    {
        id: 1,
        title: 'Desarrollo Web Full Stack',
        description: 'Aprende a construir aplicaciones web completas...',
        schedule: 'Lunes, Miércoles, Viernes 18:00 a 21:00',
        modality: 'Online en vivo',
        image: 'https://placehold.co/300x200/c4b5fd/6d28d9?text=Web+Dev'
    },
    {
        id: 2,
        title: 'Diseño Gráfico Profesional',
        description: 'Domina herramientas de diseño...',
        schedule: 'Martes, Jueves 17:00 a 20:00',
        modality: 'Presencial',
        image: 'https://placehold.co/300x200/c4b5fd/6d28d9?text=Dise%C3%B1o'
    }
    // etc.
];

let isAuthenticated = false;

function handleAuthClick() {
    isAuthenticated = !isAuthenticated;
    updateAuthButton();
    showMessageBox('Estado: ' + (isAuthenticated ? 'Autenticado' : 'No autenticado'));
}

function updateAuthButton() {
    const authButton = document.querySelector('nav button');
    authButton.textContent = isAuthenticated ? 'Cerrar sesión' : 'Iniciar sesión / Registrarse';
}

function showMessageBox(message) {
    const modal = document.getElementById('course-modal');
    const msg = document.getElementById('auth-message-box');
    msg.textContent = message;
    msg.classList.remove('hidden');
    modal.classList.remove('hidden');
    setTimeout(() => {
        msg.classList.add('hidden');
        modal.classList.add('hidden');
    }, 3000);
}

function openModal(course) {
    document.getElementById('modal-title').textContent = course.title;
    document.getElementById('modal-description').textContent = course.description;
    document.getElementById('modal-schedule').textContent = course.schedule;
    document.getElementById('modal-modality').textContent = course.modality;

    const modal = document.getElementById('course-modal');
    const content = document.getElementById('modal-content');

    modal.classList.remove('hidden');
    setTimeout(() => {
        content.classList.remove('opacity-0', 'scale-95');
        content.classList.add('opacity-100', 'scale-100');
    }, 50);
}

function closeModal() {
    const modal = document.getElementById('course-modal');
    const content = document.getElementById('modal-content');

    content.classList.remove('opacity-100', 'scale-100');
    content.classList.add('opacity-0', 'scale-95');
    setTimeout(() => {
        modal.classList.add('hidden');
        document.getElementById('auth-message-box').classList.add('hidden');
    }, 300);
}

function renderCourses() {
    const courseList = document.getElementById('course-list');
    courseList.innerHTML = '';
    courses.forEach(course => {
        const card = `
            <div class="card-bg p-6 rounded-lg shadow-md hover:shadow-xl transition-all duration-300 ease-in-out transform hover:-translate-y-1 cursor-pointer"
                 onclick='openModal(${JSON.stringify(course)})'>
                <img src="${course.image}" alt="${course.title}" class="w-full h-40 object-cover rounded-md mb-4 shadow-sm">
                <h3 class="text-xl font-semibold text-purple-900 mb-2">${course.title}</h3>
                <p class="text-purple-700 text-sm">${course.description.substring(0, 100)}...</p>
            </div>
        `;
        courseList.innerHTML += card;
    });
}

document.addEventListener('DOMContentLoaded', () => {
    renderCourses();
    updateAuthButton();
});
