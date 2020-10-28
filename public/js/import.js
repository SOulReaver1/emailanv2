// DOC :
// Vous devez absolument avoir dans le file un index path pour désigner le nom du dossier
var emails = [];

function checkIfFilesExists([name, size, extension], callback){
    // Je vérifie si mon fichier que je veux importer existe déjà dans mon storage path. Pour cela j'ai pris la taille exacte du fichier + le nom. (Peut-être une meilleure méthode pour vérifier cela existe) Je vérifie si le fichier existe pour gagner du temps et éviter de store un fichier déjà existant.
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: 'POST',
        url: '/storeFile/check',
        data: {name: name, size: size, extension: extension},
        success: (res) => {
            return callback(res);
        }
    })
}

function storeFile(file, callback){
    // Cette fonction permet de store un fichier en envoyant le fichier (formData), via ajax à PHP.
    $('#myButton').attr('disabled', true);
    $('#alert').css({'display': 'none'});
    $('#loader').css({'display': 'block'});
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        enctype: "multipart/form-data",
        method: 'POST',
        cache: false,
        url: '/storeFile',
        data: file,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: (filename) => {
            return callback(filename);
        }
    })
}
function sendToServer(nbrElements, [elements, val = undefined, val2 = undefined], url, callback, progress = 10000){
    // Je coupe mon tableau d'élement en part de 10.000 pour éviter d'avoir trop de data à traité d'un seul coup. Donc pour gagné du temps. J'utilise la méthode de la récursivité.
    $('#myButton').attr('disabled', true);
    $('#loader').css({'display': 'block'});
    const sendNbr = 10000;
    var array = elements.slice(0, sendNbr);
    array = array.filter(function(value){return value !== undefined;});
    var result = progress*100/nbrElements;
    $('#progress-bar').css({'width': result+'%'});
    if(array.length > 0){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            enctype: "multipart/form-data",
            method: 'POST',
            url: url,
            data: {elements: JSON.stringify(array), value: val, value2: val2},
            success: (res) => {
                if(val2) emails.push(res);
                sendToServer(nbrElements, [elements.slice(sendNbr, elements.length), val, val2], url, callback, progress+array.length);
            }
        })
    }else{
        $('#alert').css({'display': 'block'});
        $('#loader').css({'display': 'none'});
        $('#myButton').removeAttr('disabled');
        callback(emails);
        emails = [];
    }
}
