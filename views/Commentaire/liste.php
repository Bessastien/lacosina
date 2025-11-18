<h2>Liste des commentaires</h2>

<?php if (empty($commentaires)): ?>
    <p>Aucun commentaire pour le moment.</p>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Recette</th>
                    <th>Pseudo</th>
                    <th>Commentaire</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                global $pdo;
                $recetteModel = new Recette($pdo);
                foreach ($commentaires as $comment):
                    $recette = $recetteModel->getById($comment['recette_id']);
                ?>
                    <tr>
                        <td><?php echo $comment['id']; ?></td>
                        <td>
                            <a href="?c=Recette&a=detail&id=<?php echo $comment['recette_id']; ?>">
                                <?php echo htmlspecialchars($recette['titre']); ?>
                            </a>
                        </td>
                        <td><?php echo htmlspecialchars($comment['pseudo']); ?></td>
                        <td><?php echo htmlspecialchars(substr($comment['commentaire'], 0, 100)) . (strlen($comment['commentaire']) > 100 ? '...' : ''); ?></td>
                        <td><?php echo $comment['create_time']; ?></td>
                        <td>
                            <a href="?c=Commentaire&a=supprimer&id=<?php echo $comment['id']; ?>"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?');">
                                <i class="bi bi-trash"></i> Supprimer
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

