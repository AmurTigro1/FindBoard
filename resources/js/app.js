import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener("DOMContentLoaded", function () {
    const loadingSpinner = document.getElementById("loading-spinner");

    // Show spinner on form submission
    const forms = document.querySelectorAll("form");
    forms.forEach((form) => {
        form.addEventListener("submit", function () {
            loadingSpinner.classList.remove("hidden");
        });
    });

    // Show spinner during AJAX requests (if using Axios)
    if (window.axios) {
        window.axios.interceptors.request.use((config) => {
            loadingSpinner.classList.remove("hidden");
            return config;
        });

        window.axios.interceptors.response.use(
            (response) => {
                loadingSpinner.classList.add("hidden");
                return response;
            },
            (error) => {
                loadingSpinner.classList.add("hidden");
                return Promise.reject(error);
            }
        );
    }
});

