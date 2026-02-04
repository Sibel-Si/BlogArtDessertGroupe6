<?php
include '../../../header.php'; // contains the header and call to config.php

//Load all mot cle
$motscles = sql_select("MOTCLE", "*");
?>

<!-- Bootstrap default layout to display all keyword in foreach -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Mots-clé</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Mots clés</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($motscles as $motcle){ ?>
                        <tr>
                            <td><?php echo($motcle['numMotCle']); ?></td>
                            <td><?php echo($motcle['libMotCle']); ?></td>
                            <td>
                                <a href="edit.php?numMotCle=<?php echo($motcle['numMotCle']); ?>" class="btn btn-moyen">Edit</a>
                                <a href="delete.php?numMotCle=<?php echo($motcle['numMotCle']); ?>" class="btn btn-fonce">Delete</a>
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