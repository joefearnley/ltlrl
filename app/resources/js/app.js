import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


const copyToClipboarButton = document.querySelector('.copy-to-clipboard-button');
const newUrlInput = document.querySelector('#new_url');

copyToClipboarButton.addEventListener('click', event => {
    navigator.clipboard.writeText(newUrlInput.value);

    // let user know it has been copied
});
