function addPhotoName(idPhoto)
{
    const validator = /^[a-z0-9 A-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-z0-9 A-ZÀ-ÿ\u00f1\u00d1]*)*[a-z-9 A-ZÀ-ÿ\u00f1\u00d1]+$/g;
    const inputSelector = '#photoName-'+idPhoto;
    const val = $(inputSelector).val();
    if(validator.test(val))
    {
        const formData = new FormData();
        formData.append('photo', idPhoto);
        formData.append('name', val);
        try {
            $.ajax({
                url: window.location.pathname+'/addPhotoName',
                type: 'post',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if(response === 'ok')
                    {
                        window.location = window.location.href;
                    }
                }
            });
        } catch (error) {
            alert('error subiendo la imagen');
        }
    } else {
        Swal.fire({
                title: "¡Error!",
                text: "Solo están permitidos letras y números.",
                type: "error",
                icon: "error",
                confirmButtonText: "Cerrar",
                closeOnConfirm: true
            });
        $(inputSelector).val('');
    }
}