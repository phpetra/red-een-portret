(function () {

    var app = {
        container: document.querySelector('#app'),
        currentLetter: '',

        init: function () {
            let self = this;
            this.alphabet();

            // attach event listeners
            this.container.addEventListener('click', function (e) {
                if (e.target.className.includes('choose')) {
                    self.loadTemplate(e.target.dataset.letter);
                }
            });

            this.container.addEventListener('click', function (e) {
                if (e.target.className.includes('name-toggle')) {
                    document.querySelector('#names').classList.toggle('is-visible');
                }
            });
        },

        loadTemplate: function (letter) {
            let self = this;
            self.currentLetter = letter;

            fetch('./html/' + letter + '.portraits.html')
                .then(response => {
                    return response.text()
                })
                .then(data => {
                    document.querySelector('#content').innerHTML = data;
                    self.alphabet(); //redraw to make bold
                    self.loadNames(letter);
                })
                .catch(err => {
                    console.log(err)
                })
        },

        loadNames: function(letter) {
            let self = this;
            fetch('./names.json')
                .then(response => {
                    return response.json()
                })
                .then(names => {
                    let dom = '';
                    names.forEach(function(name) {
                        if (name.letter === self.currentLetter) {
                            dom += ` <a href="#${name.uri}" data-letter="${name.letter}" class="choose js-trigger">${name.sortName}</a>`;
                        }
                    });
                    document.querySelector('#names').innerHTML = dom;
                })
                .catch(err => {
                    // implement error
                    console.log(err)
                })
        },

        alphabet: function () {
            let self = this;
            let az = "_abcdefghijklmnopqrstuvwyz".split("");
            let dom = '';
            az.forEach(function (letter) {
                let style = 'is-size-4 choose ';
                if (letter === self.currentLetter) {
                    style += 'has-text-weight-bold';
                }
                dom += ` <a href="#${letter}" data-letter="${letter}" class="${style}">${letter}</a>`;
            });
            document.querySelector('.alphabet').innerHTML = dom
        },
    };

    app.init();

})();
