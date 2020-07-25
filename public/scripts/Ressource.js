Dropzone.autoDiscover = false;
let myDropzone = new Dropzone("#uploadPictureRessource");



$('#add-ressource-new').on('click' ,() => {
    let urlParams = new URLSearchParams(window.location.search);

    console.log(myDropzone.files);
    data = {
        "name": $("#new-ressource-name").val(),
        "description" : $("#new-ressource-description").val(),
        "category": urlParams.get('selectCateg'),
        "imageBase64": myDropzone.files[0]
    }


    axios.post('/new-ressource',data).then((response) => {
        $("#link-ressource-added").attr("href", "/ressource/"+response.data)
        $(".message-success-new-ressource").show()
        $("#add-ressource-new").prop("disabled",true);
    }, (error) => {
        console.log(error);
    });
})
