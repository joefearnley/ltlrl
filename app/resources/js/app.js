import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


const copyToClipboardButtons = document.querySelectorAll('button.copy-to-clipboard');

copyToClipboardButtons.forEach(button => {
    button.addEventListener('click', event => {
        const copyText = button.previousElementSibling.innerHTML.trim();

        if ('clipboard' in navigator) {
            navigator.clipboard.writeText(copyText)
                .then(() => {
                    console.log('Text copied');
                })
                .catch((err) => console.error(err.name, err.message));

        } else {
            const textArea = document.createElement('textarea');
            textArea.value = copyText;
            textArea.style.opacity = 0;
            document.body.appendChild(textArea);
            textArea.select();

            try {
                document.execCommand('copy');
            } catch (err) {
                console.error(err.name, err.message);
            }

            document.body.removeChild(textArea);
        }

        const currentCopyButtonHTML = button.innerHTML;
        button.innerHTML = 'Copied!';

        setTimeout(() => {
            button.innerHTML = currentCopyButtonHTML;
        }, '3000');
    });
});
