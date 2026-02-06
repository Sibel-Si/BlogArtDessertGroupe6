<div class="col-md-12">
    <form action="<?php echo ROOT_URL . '/api/articles/delete.php' ?>" method="post">
        
        <input type="hidden" name="numArt" value="<?php echo $article['numArt']; ?>" />
        
        <div class="form-group">
            <label>Titre de l'article</label>
            <input class="form-control" type="text" value="<?php echo htmlspecialchars($article['libTitrArt']); ?>" readonly disabled />
        </div>
        <br />
        <div class="form-group">
            <label>Thématique</label>
            <select class="form-control" disabled>
                <?php foreach($themes as $theme): ?>
                    <option <?php echo ($theme['numThem'] == $article['numThem']) ? 'selected' : ''; ?>>
                        <?php echo $theme['libThem']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <br />
        <div class="form-group mt-2">
            <a href="list.php" class="btn btn-moyen">Retour</a>

            <?php if($commentCount == 0): ?>
                <button type="submit" class="btn btn-fonce" onclick="return confirm('Confirmer la suppression définitive de cet article ?');">
                    Confirmer Suppression
                </button>
            <?php else: ?>
                <button type="button" class="btn btn-fonce" disabled>Suppression impossible</button>
            <?php endif; ?>
        </div>
    </form>
</div>