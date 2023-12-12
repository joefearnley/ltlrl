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

const copyToClipboardButtons = document.querySelectorAll('button.copy-to-clipboard');
// const newUrlLink = document.querySelector('#new-url-link');


copyToClipboardButtons.forEach(button => {
    button.addEventListener('click', event => {
        console.log('clicked...');
        console.log(button.previousElementSibling.innerHTML.trim());

        copyTextToClipboard(button.previousElementSibling.innerHTML.trim())
            .then(result => {
                console.log(result);

                const currentCopyButtonHTML = button.innerHTML;
                button.innerHTML = 'Copied!';

                setTimeout(() => {
                    button.innerHTML = currentCopyButtonHTML;
                }, '3000');
            })
            .catch((err) => {
                console.log('error copying to clipboard:');
                console.log(err);
            });
    });
});
