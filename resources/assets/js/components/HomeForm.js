
class HomeForm {
    constructor() {
        this.submitButton = document.querySelector('#make-url-little');
        this.submitButton.addEventListener('click', (e) => { this.createUrl(e) });
        this.results = document.querySelector('#results');
        this.urlField = document.querySelector('#url');
    }

    createUrl () {
        axios.post('/url/create', { 'url' : this.urlField.value })
            .then(response => this.showResult(response.data.url).bind(this))
            .catch(error => this.handleError(error));
    }

    showResult (url) {
        this.results.innerHTML = this.template(url.url);
    }

    handleError(error) {
        const errorMessage = error.response.data.url[0];
    }

    template (url) {
        return `
        <h4>
            URL has been made little! - <strong>${url.url}</strong>
            <a class="button is-success"><i class="fa fa-clipboard" aria-hidden="true"></i> Copy to Clipboard</a>
        </h4>
        `;
    }
}

module.exports = HomeForm;
