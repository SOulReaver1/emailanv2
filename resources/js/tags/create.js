import { checkIfFileExist, awaitSendToServer, notAwaitSendToServer, getEmailsOfFile, initializeSubmit} from '../functions/functions.js';
var [tags, bases, method] = ["", "", $('input:checked')[0].value];
$('#dropdown').dropdown({
    allowAdditions: true,
    onChange: function(val){
        tags = val.split(',');
    }
});
$('#base').dropdown({
    onChange: function(array, id, val){
        bases = array;
    }
});

$('.custom-control-input').on('click', function(){
    switch($(this).attr('id')){
        case 'customRadioInline2':
            $('#methodDomain').css({'display': 'none'});
            $('#methodFile').css({'display': 'block'});
            method = 'file';
            break;
        case 'customRadioInline3':
            $('#methodDomain').css({'display': 'block'});
            $('#methodFile').css({'display': 'none'});
            method = 'domains';
            break;
        default:
            $('#methodFile').css({'display': 'none'});
            $('#methodDomain').css({'display': 'none'});
            method = 'base';
    }
})

const [button] = [document.getElementById('myButton')];

$("#myForm").on('submit', function (e) {
    try{
        e.preventDefault();
        initializeSubmit('start', button);
        const formData = new FormData(e.target);
        formData.set('bases', JSON.stringify(bases));
        formData.set('tags', JSON.stringify(tags));
        formData.append('method', method);
        switch (method){
            case 'base':
                formData.delete('file');
                notAwaitSendToServer(formData, '/tags').then(res => {
                    initializeSubmit('success', button, 'Les tags sont en cours d\'importation !');
                });
            break;
            case 'file':
                checkIfFileExist(formData, true).then(res => {
                    formData.delete('file');
                    formData.set('path', res.path);
                    notAwaitSendToServer(formData, '/tags').then(res => {
                        initializeSubmit('success', button, 'Les tags sont en cours d\'importation !');
                    });
                });
            break;
        }
    }catch(err){
        initializeSubmit('error', button, err);
    }
});