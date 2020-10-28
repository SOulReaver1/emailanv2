import { checkIfFileExist, awaitSendToServer, notAwaitSendToServer, getEmailsOfFile, initializeSubmit} from '../functions/functions.js';

const [myButton, myFile] = [
    document.getElementById('myButton'),
    document.getElementById('file')
];

$('form').on('submit', (e) => {
    try {
        e.preventDefault();
        initializeSubmit('start', myButton);
        var formData = new FormData(e.target)
        getEmailsOfFile(myFile).then(emails => {
            if(formData.get('importMode') === 'normal'){
                checkIfFileExist(formData, true).then(response => {
                    var formData2 = new FormData();
                    formData2.append('emails', JSON.stringify(emails));
                    awaitSendToServer(emails.length, formData2, '/', (res) => {
                        initializeSubmit('success', myButton, 'Votre base est bien envoyer !');
                    });
                });
            }else if(formData.get('importMode') === 'speed'){
                checkIfFileExist(formData, true).then(response => {
                    var formData2 = new FormData();
                    formData2.append('data', JSON.stringify(response));
                    formData2.append('base_id', formData.get('base'));
                    notAwaitSendToServer(formData2, '/').then(response => {
                        initializeSubmit('success', myButton, 'Votre base est en cours d\'envoie !');
                    });
                });
            }
        }).catch(err => {
            initializeSubmit('error', myButton, err);
        });
    }catch(err){
        initializeSubmit('error', myButton, `Vérifiez que tous les champs soient bien remplis !`);
    }
})