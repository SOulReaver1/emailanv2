import { notAwaitSendToServer, getEmailsOfFile, initializeSubmit, checkIfFileExist} from '../functions/functions.js';

const [dbButton, dbFile] = [
    document.getElementById('dbButton'),
    document.getElementById('dbFile'),
];

$("#dbForm").on('submit', function(e) {
    e.preventDefault();
    initializeSubmit('start', dbButton);
    const formData = new FormData(e.target);
    getEmailsOfFile(dbFile).then(res =>{
        checkIfFileExist(formData, true).then(response => {
            const formData2 = new FormData();
            formData2.append('path', response.path);
            console.log(...formData2)
            notAwaitSendToServer(formData2, '/comparateur/create/database').then(res => {
                initializeSubmit('success', dbButton, 'Nickel');
            });
        });
    });
});