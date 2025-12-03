<h2>Commentaires en attente de validation</h2>

<?php if (empty($commentaires)): ?>
    <div class="alert alert-info">
        <i class="bi bi-info-circle"></i> Aucun commentaire en attente de validation.
    </div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pseudo</th>
                    <th>Recette</th>
                    <th>Commentaire</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($commentaires as $comment): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($comment['id']); ?></td>
                        <td><?php echo htmlspecialchars($comment['pseudo']); ?></td>
                        <td>
                            <a href="?c=Recette&a=detail&id=<?php echo $comment['recette_id']; ?>">
                                <?php echo htmlspecialchars($comment['recette_titre']); ?>
                            </a>
                        </td>
                        <td><?php echo htmlspecialchars(substr($comment['commentaire'], 0, 100)) . (strlen($comment['commentaire']) > 100 ? '...' : ''); ?></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($comment['create_time'])); ?></td>
                        <td>
                            <a href="?c=Commentaire&a=approveComment&id=<?php echo $comment['id']; ?>"
                               class="btn btn-sm btn-success"
                               onclick="return confirm('Approuver ce commentaire ?');"
                               title="Approuver">
                                <i class="bi bi-check-circle"></i> Approuver
                            </a>
                            <a href="?c=Commentaire&a=supprimer&id=<?php echo $comment['id']; ?>"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Supprimer ce commentaire ?');"
                               title="Supprimer">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<div class="mt-4">
    <a href="?c=Commentaire&a=liste" class="btn btn-secondary">Voir tous les commentaires</a>
</div>

