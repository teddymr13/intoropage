function addPictureVideoOrLinkEventListener(){
    $('input[name="picture[]"]').on('keyup', function () {
        const picture_id = $(this).attr('id');
        if(document.getElementById(picture_id).value!='') refreshPreviewPicture('preview_' + picture_id, picture_id);
        else{
            const split_picture_id = picture_id.split('_');
            refreshPreviewPicture('preview_' + picture_id, 'video_or_link_' + split_picture_id[1], true);
        }
    });
    $('input[name="video_or_link[]"]').on('keyup', function () {
        const video_or_link_id = $(this).attr('id');
        const split_video_or_link_id = video_or_link_id.split('_');
        if(document.getElementById('picture_' + split_video_or_link_id[3]).value=='') refreshPreviewPicture('preview_picture_' + split_video_or_link_id[3], video_or_link_id, true);
    });
}
function removePictureVideoOrLinkEventListener(){
    $('input[name="picture[]"]').off();
    $('input[name="video_or_link[]"]').off();
}
function addRowSlide(){
    removePictureVideoOrLinkEventListener();
    $('input[type="number"]').off();

    const lastRow = document.getElementById('table_slide').rows.length;
    const tr = document.getElementById('table_slide').insertRow(lastRow);
    const td1 = tr.insertCell(0);
    const td2 = tr.insertCell(1);
    const td3 = tr.insertCell(2);
    const td4 = tr.insertCell(3);

    let newImage, newInput;

    newImage = new Image;
    newImage.src = DEFAULT_NO_IMAGE;
    newImage.className = "img-thumbnail img-thumbnail-fix-width align-self-center";
    newImage.id = "preview_picture_" + lastRow;
    newImage.onload = function () {
        td1.appendChild(newImage);
    };
    td1.setAttribute('scope', 'row');

    newInput = document.createElement("INPUT");
    newInput.setAttribute("type", "url");
    newInput.setAttribute("name", "picture[]");
    newInput.setAttribute("maxlength", "255");
    newInput.className = "form-control";
    newInput.id = "picture_" + lastRow;
    td2.appendChild(newInput);

    newInput = document.createElement("INPUT");
    newInput.setAttribute("type", "url");
    newInput.setAttribute("name", "video_or_link[]");
    newInput.setAttribute("maxlength", "255");
    newInput.className = "form-control";
    newInput.id = "video_or_link_" + lastRow;
    td3.appendChild(newInput);

    newInput = document.createElement("INPUT");
    newInput.setAttribute("type", "number");
    newInput.setAttribute("name", "order[]");
    newInput.setAttribute("min", "0");
    newInput.setAttribute("max", "99");
    newInput.className = "form-control";
    newInput.id = "order_" + lastRow;
    td4.className = "number";
    td4.appendChild(newInput);

    addPictureVideoOrLinkEventListener();
    $('input[type="number"]').on('keydown', function (evt) {
        filterInputNumber(evt);
    });
    $(this).closest('form').data('ischange', true);
}
(function(){
    addPictureVideoOrLinkEventListener();
    if(document.getElementById('button_add_row_slide')) document.getElementById('button_add_row_slide').addEventListener('click', addRowSlide);
})();