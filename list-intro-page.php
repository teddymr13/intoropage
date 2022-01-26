<?php
$isCanAdd = false;
$isCanRemove = false;
$cardTitle = 'Country List';

require_once 'views/includes/list-top-part.php';

if($is_valid_data) {
    if ($count_row > 1) {
        ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <?php require_once 'views/includes/list-table-caption.php'; ?>
                <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col"><?php ViewHelper::thLink($main_url, $hlm, $orderby, $order, 1, 'Country Name'); ?></th>
                    <th scope="col"><?php ViewHelper::thLink($main_url, $hlm, $orderby, $order, 2, 'ISO'); ?></th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($data_list as $item) {
                    ?>
                    <tr>
                        <td scope="row">
                            <img src="https://lipis.github.io/flag-icon-css/flags/4x3/<?php echo strtolower($item['iso']); ?>.svg" class="flag" />
                        </td>
                        <td><?php echo $item['nicename']; ?></td>
                        <td><?php echo $item['iso']; ?></td>
                        <td class="td_button_action">
                            <a role="button" class="btn btn-outline-warning btn-sm"
                               href="<?php echo $edit_url; ?>-<?php echo $item['id']; ?>/"
                               data-toggle="tooltip" title="Edit">
                                <i class="far fa-fw fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>

        <?php
        require_once 'views/includes/list-pager.php';
    }
    else echo "No Data Found.";
}
else echo "Invalid array data.";

require_once 'views/includes/list-bottom-part.php';
?>