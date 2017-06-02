
const homeForm = {
    results: document.querySelector('#results'),
    urlField: document.querySelector('#url'),
    init: () => {
        let self = this;
        console.log('calling init...');
        console.log(this);
        //document.querySelector('#make-url-little').addEventListener('click', self.createUrl.bind(this));
    },
    showResult: (url) => {
        this.results.innerHTML = this.template(url.url);
    },
    createUrl: () => {
        console.log('creating url..');
        axios.post('/url/create')
            .then(this.showResult)
            .catch(this.handleError);
    },
    handleError: () => {
        // duh....
    },
    template (url) {
        return `
            <h4>
                URL has been made little! - <strong>${url}</strong>
                <a class="button is-success"><i class="fa fa-clipboard" aria-hidden="true"></i> Copy to Clipboard</a>
            </h4>
        `;
    }
};
(() => {
    homeForm.init()
})();
