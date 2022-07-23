const dropArea = $('.drop-area');
const button = $('.drop-area button');
const inputFile = $('.drop-area input[type="file"]');
const text = $('.drop-area h2');
let files;

button.click(function(){
    inputFile.click();
});

$(document).on('change', '.drop-area input[type="file"]', function(e){
    files = this.files;
    dropArea.addClass('active');
    showFiles(files);
    dropArea.removeClass('active');
})

function showFiles(files)
{
    if(files.length === undefined)
    {
        processFile(files);
    } else {
        for(const file of files)
        {
            processFile(file);
        }
    }
}

document.querySelector('.drop-area').addEventListener('dragover',(e) => {
    e.preventDefault();
    $(dropArea).addClass('active');
    $(text).text('Suelta para subir los archivos');
});
document.querySelector('.drop-area').addEventListener('dragleave',(e) => {
    e.preventDefault();
    $(dropArea).removeClass('active');
    $(text).text('Arrastra y suelta tus archivos');
});
document.querySelector('.drop-area').addEventListener('drop',(e) => {
    e.preventDefault();
    files = e.dataTransfer.files;
    showFiles(files);
    $(dropArea).removeClass('active');
    $(text).text('Arrastra y suelta tus archivos');
});

function processFile(file)
{
    const fileType = file.type;
    const validExtension = ["image/jpeg", "image/jpg", "image/png", "image/webp", "image/gif"];
    if(validExtension.includes(fileType))
    {
        //is valid
        const fileReader = new FileReader();
        const id = `file-${Math.random().toString(32).substring(7)}`;
        fileReader.addEventListener('load', e => {
            const fileUrl = fileReader.result;
            const image = `
            <div id="${id}" class="file-container">
                <img src="${fileUrl}" alt="${file.name}" width="50">
                <div class="status">
                    <span>${file.name}</span>
                    <span class="status-text">
                    Loading...
                    </span>
                </div>
            </div>
            `;
            const html = document.querySelector('#preview-files').innerHTML;
            document.querySelector('#preview-files').innerHTML = image + html;
        })
        upLoadFile(file, id);
        fileReader.readAsDataURL(file);
    } else {
        //is not valid
        alert('No es una imagen válida');
    }
}

async function upLoadFile(file, id)
{
    const formData = new FormData();
    formData.append('file', file);
    formData.append('name', id);
    try {
        await $.ajax({
            url: window.location.pathname+'/morePhotos',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response);
                if(response === 'ok')
                {
                    console.log($('#'+id+' .status-text'));
                    $('#'+id+' .status-text').addClass('uploaded');
                    $('#'+id+' .status-text').text('Subido');
                }
            }
        });
    } catch (error) {
        alert('error subiendo la imagen');
    }
}