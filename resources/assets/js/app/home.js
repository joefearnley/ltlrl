
(function() {
    const submitButton = document.querySelector('#make-url-little');
    const l = Ladda.create(submitButton);

    submitButton.addEventListener('click', (e) => {
        e.preventDefault();
        l.start();
    });
})();