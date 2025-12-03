<h2>Recettes en attente de validation</h2>

<?php if (empty($recettes)): ?>
    <div class="alert alert-info">
        <i class="bi bi-info-circle"></i> Aucune recette en attente de validation.
    </div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Titre</th>
                    <th>Type</th>
                    <th>Auteur</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recettes as $recette): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($recette['id']); ?></td>
                        <td>
                            <img src="<?php echo htmlspecialchars($recette['image'] ?? 'images/no_image.png'); ?>"
                                 alt="<?php echo htmlspecialchars($recette['titre']); ?>"
                                 style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                        </td>
                        <td><?php echo htmlspecialchars($recette['titre']); ?></td>
                        <td><span class="badge bg-secondary"><?php echo htmlspecialchars($recette['type_plat']); ?></span></td>
                        <td><?php echo htmlspecialchars($recette['auteur']); ?></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($recette['date_creation'])); ?></td>
                        <td>
                            <a href="?c=Recette&a=detail&id=<?php echo $recette['id']; ?>"
                               class="btn btn-sm btn-info" title="Voir">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="?c=Recette&a=approveRecette&id=<?php echo $recette['id']; ?>"
                               class="btn btn-sm btn-success"
                               onclick="return confirm('Approuver cette recette ?');"
                               title="Approuver">
                                <i class="bi bi-check-circle"></i> Approuver
                            </a>
                            <a href="?c=Recette&a=supprimer&id=<?php echo $recette['id']; ?>"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Supprimer cette recette ?');"
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

