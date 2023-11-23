import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


async function copyTextToClipboard(text) {
    console.log("copying to clipboard")
    if ('clipboard' in navigator) {
        return await navigator.clipboard.writeText(text)
    } else {
        console.log('no clipboard in navigator');
        return document.execCommand('copy', true, text)
    }
}

const copyToClipboardButton = document.querySelector('.copy-to-clipboard-button');
const newUrlLink = document.querySelector('#new-url-link');

copyToClipboardButton.addEventListener('click', event => {
    copyTextToClipboard(newUrlLink.innerHTML.trim())
        .then(() => {
            console.log('soifjowiejfwoefij');

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
