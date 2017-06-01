
class HomeForm {
    constructor() {
        this.submitButton = document.querySelector('#make-url-little');
        this.submitButton.addEventListener('click', this.createUrl);
    }
    createUrl () {
        axios.post('/url/create')
            .then(response => {
                this.showResult(response);
            }).catch(error => {
                this.handleError(error);
            });
    }
    handleError() {
        // duh....
    }

    showResult (url) {
        // let the user know they have something to work with.
    }
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