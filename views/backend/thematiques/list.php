<?php
session_start();
require_once ROOT_URL . '/functions/security.php';

// Define the required level (e.g., 1 for Admin, 2 for Moderator)
$required_level = 1; 

if (!check_access($required_level)) {
    // Redirect unauthorized users to login or an error page
    header("Location: login.php?error=unauthorized");
    exit(); // Always exit after a header redirect
}

include '../../../header.php'; // contains the header and call to config.php

//Load all thematiques
$thematiques = sql_select("THEMATIQUE", "*");
?>

<!-- Bootstrap default layout to display all thematiques in foreach -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Thématiques</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nom de la thématique</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($thematiques as $thematique){ ?>
                        <tr>
                            <td><?php echo($thematique['numThem']); ?></td>
                            <td><?php echo($thematique['libThem']); ?></td>
                            <td>
                                <a href="edit.php?numThem=<?php echo($thematique['numThem']); ?>" class="btn btn-moyen">Edit</a>
                                <a href="delete.php?numThem=<?php echo($thematique['numThem']); ?>" class="btn btn-fonce">Delete</a>  
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <a href="create.php" class="btn btn-clair">Create</a>
        </div>
    </div>
</div>
<?php
include '../../../footer.php'; // contains the footer



