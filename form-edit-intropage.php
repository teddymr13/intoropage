<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <form id="form_edit_intro_page" method="post">
                    <?php require_once 'views/includes/slider-main-table.php'; ?>
                    <h5>Thumbnail</h5>
                    <?php
                    ViewHelper::introPageThumbnailInput($data_edit, 0, 'Picture (Top Left)');
                    ViewHelper::introPageThumbnailInput($data_edit, 1, 'Picture (Top Right)');
                    ViewHelper::introPageThumbnailInput($data_edit, 2, 'Picture (Bottom Left)');
                    ViewHelper::introPageThumbnailInput($data_edit, 3, 'Picture (Bottom Right)');
                    $typeCancel = true;
                    require_once 'views/includes/form-submit-buttons.php';
                    ?>
                </form>
            </div>
        </div>
    </div>
</div>