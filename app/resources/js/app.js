import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


async function copyTextToClipboard(text) {
    if ('clipboard' in navigator) {
        return await navigator.clipboard.writeText(text)
    } else {
        return document.execCommand('copy', true, text)
    }
}

const copyToClipboardButton = document.querySelector('.copy-to-clipboard-button');
const newUrlLink = document.querySelector('#new-url-link');

copyToClipboardButton.addEventListener('click', event => {
    copyTextToClipboard(newUrlLink.innerHTML.trim())
        .then(result => {
            console.log(result);


            const currentCopyButtonHTML = copyToClipboardButton.innerHTML;
            copyToClipboardButton.innerHTML = 'Copied!';

            setTimeout(() => {
                copyToClipboardButton.innerHTML = currentCopyButtonHTML;
            }, '3000');
        })
        .catch((err) => {
            console.log('err:');
            console.log(err);
        });


});
