
<?php include "db/config.php"; ?>

<!-- Fetch type, status, assignee dropdown -->
<?php include "db/fetch_dropdown_data.php"; ?>

<?php include "views/layouts/header.php"; ?>

<div class="container my-5">
    
    <!-- Table HTML -->
    <?php include "views/log_view.php"; ?>

    <!-- Add/Edit Ticket Modal -->
    <?php include "views/modal/log_modal.php"; ?>

</div>

<!-- table list, add, edit, delete all datatable js -->
<script type="text/javascript" src="./js/log.js"></script>

<?php include "views/layouts/footer.php"; ?>
