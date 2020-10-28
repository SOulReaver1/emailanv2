const { isEmpty } = require("lodash");

module.exports = {
    checkIfFileExist: (formData, store) => {
        const alert = document.getElementById('alert-info');
        alert.style.display = 'block';
        alert.innerHTML = 'Votre fichier est en cours de vérification ...';
        return fetch('/store/check', {
            method: 'POST',
            headers: new Headers({
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }),
            body: formData,
            redirect: 'manual'
        }).then(response => response)
        .then(responseData => {
            if(responseData.status === 0){
                return document.location.reload(true);
            }
            return responseData.json();
        }).then(response => {
            if(isEmpty(response)){
                alert.innerHTML = 'Nouveau fichier détecter !';
                return store && module.exports.storeFile(formData, alert);
            }
            alert.style.display = 'none';
            return response;
        }).catch(err => {
            module.exports.initializeSubmit('error', null, err);
        });
    },
    storeFile: (formData, alert) => {
        alert.innerHTML = 'Votre fichier est en cours d\'enregistrement ...'
        return fetch('/store', {
            method: 'POST',
            headers: new Headers({
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }),
            body: formData,
            redirect: 'manual'
        }).then(response => response.json())
        .then(response => {
            alert.style.display = "none";
            return response;
        }).catch(err => {
            return err;
        });
    },
    getEmailsOfFile: myFile => {
        const isEmail = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,3})$/gm;
        var file = myFile.files[0];
        var reader = new FileReader();
        reader.readAsText(file, "UTF-8");
        return new Promise((response, reject) => {
            reader.onload = function (evt){
                const emails = evt.target.result.match(isEmail);
                return emails && emails.length > 0 ? response(emails) : reject('Il n\'y a pas d\'emails en clair dans votre fichier !');
            };
        }).catch(err => {
            module.exports.initializeSubmit('error', null, err);
        });
        
    },
    awaitSendToServer: (length, formData, url, callback = false, progress = 0) => {
        const alert = document.getElementById('alert-info');
        alert.innerHTML = 'Vous avez choisi le mode normal ! Votre fichier est en cours d\'envoie ! Veuillez '
        const emails = JSON.parse(formData.get('emails'));
        const progressBar = document.getElementById('progress-bar');
        const sendNbr = 10000;
        var array = emails.slice(0, sendNbr);
        var result = progress*100/length;
        progressBar.style.width = `${result}%`;
        if(array.length > 0){
            return fetch(url, {
                method: 'POST',
                headers: new Headers({
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                }),
                body: formData,
                redirect: 'manual'
            }).then(reponse => {
                if(response.status === 0){
                    return document.location.reload(true);
                }
                formData.set('emails', JSON.stringify(emails.slice(sendNbr, emails.length)));
                return module.exports.awaitSendToServer(length, formData, url, callback, progress+array.length);                
            }).catch(err => {
                module.exports.initializeSubmit('error', null, err);
            });
        }
        return callback() ?? true;
    },
    notAwaitSendToServer: (formData, url) => {
        return fetch(url, {
            method: 'POST',
            headers: new Headers({
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }),
            body: formData,
            redirect: 'manual'
        }).then(response => {
            if(response.status === 0){
                return document.location.reload(true);
            }
            const progressBar = document.getElementById('progress-bar');
            progressBar.style.width = '100%';
            return response;
        }).catch(err => {
            module.exports.initializeSubmit('error', null, err);
        });
    },
    initializeSubmit: (statut, button = null, message = null) => {
        const [alertSuccess, alertDanger, errorDanger] = [
            document.getElementById('alert-success'),
            document.getElementById('alert-danger'),
        ];
        if(button !== null){
            button.removeAttribute('disabled');
            button.children["loader"].style.display = "none";
        }
        switch (statut){
            case 'start':
                alertDanger.style.display = 'none';
                alertSuccess.style.display = 'none';
                button.setAttribute('disabled', true);
                button.children["loader"].style.display = "block";
            break;
            case 'success':
                alertSuccess.style.display = 'block';
                alertSuccess.innerHTML = message;
            break;
            case 'error':
                alertDanger.style.display = 'block';
                alertDanger.innerHTML = message;
            break;
        }
    },
};