const { initializeSubmit, getEmailsOfFile, checkIfFileExist, notAwaitSendToServer } = require("../functions/functions");

const [file1, file2, fileButton] = [document.getElementById('file1'),document.getElementById('file1'), document.getElementById('fileButton')]

$("#fileForm").on('submit', function(e) {
    e.preventDefault();
    initializeSubmit('start', fileButton);
    const formData = new FormData(e.target);
    getEmailsOfFile(file1).then(res =>{
        const formFile1 = new FormData();
        formFile1.append('file', formData.get('file1'));
        const formFile2 = new FormData();
        formFile2.append('file', formData.get('file2'));
        getEmailsOfFile(file2).then(res =>{
            checkIfFileExist(formFile1, true).then(res1 => {
                checkIfFileExist(formFile2, true).then(res2 => {
                    const formData2 = new FormData();
                    formData2.append('path1', res1.path);
                    formData2.append('path2', res2.path);
                    formData2.append('statut', formData.get('statut'));
                    notAwaitSendToServer(formData2, '/comparateur/create/files').then(res => {
                        initializeSubmit('success', fileButton, 'Nickel');
                    });
                });
            });
        });
    });
});