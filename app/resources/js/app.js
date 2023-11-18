import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


const newUrlInput = document.querySelector('#new_url');
const createUrlButton = document.querySelector('#create-url-submit-button');

createUrlButton.addEventListener('click', event => {
    event.preventDefault();

    fetch('https://jsonplaceholder.typicode.com/users')
        .then((response) => response.json())
        .then((data) => {
            this.users = data;
            this.isLoading = false;
        });

    console.log(event.target);
});
