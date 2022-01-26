function checkSubmit(){
    let err = '';
    let flagerr = 0;

    const hid_id = document.getElementById('hid_id').value;
    if(hid_id == '' || !validateNumber(hid_id)) location.reload();

    const thumbnail_1 = document.getElementById('thumbnail_1').value;
    if(thumbnail_1 == ''){
        err = err + '- Please Enter Top Left Thumbnail!<br/>';
        flagerr = 1;
    }
    const thumbnail_2 = document.getElementById('thumbnail_2').value;
    if(thumbnail_2 == ''){
        err = err + '- Please Enter Top Right Thumbnail!<br/>';
        flagerr = 1;
    }
    const thumbnail_3 = document.getElementById('thumbnail_3').value;
    if(thumbnail_3 == ''){
        err = err + '- Please Enter Bottom Left Thumbnail!<br/>';
        flagerr = 1;
    }
    const thumbnail_4 = document.getElementById('thumbnail_4').value;
    if(thumbnail_4 == ''){
        err = err + '- Please Enter Bottom Right Thumbnail!<br/>';
        flagerr = 1;
    }

    if(flagerr === 1){
        showAlert(err, 'danger', 'Incomplete!');
        return false;
    }
    else if(flagerr === 0){
        document.getElementById('form_edit_intro_page').action = '';
        return true;
    }
}

(function() {
    watchFormChange('form_edit_intro_page');
    addFormSubmitListener('form_edit_intro_page');

    document.getElementById('thumbnail_1').addEventListener('keyup', function(){
        refreshPreviewPicture("preview_thumbnail_1", "thumbnail_1");
    });
    document.getElementById('thumbnail_2').addEventListener('keyup', function(){
        refreshPreviewPicture("preview_thumbnail_2", "thumbnail_2");
    });
    document.getElementById('thumbnail_3').addEventListener('keyup', function(){
        refreshPreviewPicture("preview_thumbnail_3", "thumbnail_3");
    });
    document.getElementById('thumbnail_4').addEventListener('keyup', function(){
        refreshPreviewPicture("preview_thumbnail_4", "thumbnail_4");
    });
})();