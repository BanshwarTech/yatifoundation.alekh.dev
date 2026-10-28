/*!
    * Start Bootstrap - SB Admin v7.0.7 (https://startbootstrap.com/template/sb-admin)
    * Copyright 2013-2023 Start Bootstrap
    * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
    */
    // 
// Scripts
// 

window.addEventListener('DOMContentLoaded', event => {

    // Add a show/hide eye control to password inputs on admin pages.
    document.querySelectorAll('input[type="password"]').forEach((input, index) => {
        if (input.closest('.login-password-wrap') || input.dataset.passwordToggleReady === 'true') return;

        const wrapper = document.createElement('div');
        wrapper.className = 'password-field-wrap';
        input.parentNode.insertBefore(wrapper, input);
        wrapper.appendChild(input);
        input.dataset.passwordToggleReady = 'true';

        if (!input.id) input.id = `admin-password-${index + 1}`;

        const toggle = document.createElement('button');
        toggle.type = 'button';
        toggle.className = 'admin-password-toggle';
        toggle.setAttribute('aria-label', 'Show password');
        toggle.setAttribute('aria-controls', input.id);
        toggle.setAttribute('aria-pressed', 'false');
        toggle.innerHTML = '<i class="fas fa-eye" aria-hidden="true"></i>';
        wrapper.appendChild(toggle);

        toggle.addEventListener('click', () => {
            const show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            toggle.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
            toggle.setAttribute('aria-pressed', show ? 'true' : 'false');
            toggle.innerHTML = `<i class="fas fa-eye${show ? '-slash' : ''}" aria-hidden="true"></i>`;
        });
    });

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

});
