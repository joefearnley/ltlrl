
class HomeForm {
    constructor() {
        this.submitButton = document.querySelector('#make-url-little');
        this.submitButton.addEventListener('click', this.createUrl);
    }
    createUrl () {}
    handleError() {}
    showResult () {}
}

var createUrl = () => {
    featch('/url/create')
        .then(response => {
            return response.json();
        }).then(response => {
        }).catch(error => {
            console.log(error);
        });
};

(function() {
    const submitButton = document.querySelector('#make-url-little');
    const l = Ladda.create(submitButton);

    submitButton.addEventListener('click', (e) => {
        e.preventDefault();
        l.start();
    });
})();