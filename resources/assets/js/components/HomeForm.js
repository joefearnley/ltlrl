
class HomeForm {
    constructor() {
        this.submitButton = document.querySelector('#make-url-little');
        this.submitButton.addEventListener('click', this.createUrl);
        this.results = document.querySelector('#results');
        this.urlField = document.querySelector('#url');
    }

    createUrl () {
        axios.post('/url/create')
            .then(this.showResult)
            .catch(this.handleError);
    }

    handleError() {
        // duh....
    }

    showResult (url) {
        this.results.innerHTML = this.template(url.url);
    }

    template (url) {
        return `
        <h4>
            URL has been made little! - <strong>${url}</strong>
            <a class="button is-success"><i class="fa fa-clipboard" aria-hidden="true"></i> Copy to Clipboard</a>
        </h4>
        `;
    }
}

export.module = HomeForm;
