<?php
    use App\Model\Entity\User;
?>

<h1>Liste des utilisateurs</h1>

<p>Statistiques sur les utilisateurs, <a href="/index.php?c=user&a=show-stats">cliquez ici</a></p>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>First name</th>
            <th>Last name</th>
            <th>Détails</th>
            <th>Editer</th>
            <th>Supprimer</th>
        </tr>
    </thead>
    <tbody> <?php
        foreach($data['users_list'] as $user) {
            /* @var User $user  */?>
            <tr>
                <td><?= $user->getId() ?></td>
                <td><?= $user->getFirstname() ?></td>
                <td><?= $user->getLastname() ?></td>
                <th>
                    <a href="/index.php?c=user&a=show-user&id=<?= $user->getId() ?>">Voir plus</a>
                </th>
                <td>
                    <a href="/index.php?c=user&a=edit-user&id=<?= $user->getId() ?>">Editer</a>
                </td>
                <td>
                    <a href="/index.php?c=user&a=delete-user&id=<?= $user->getId() ?>">Supprimer</a>
                </td>
            </tr> <?php
        } ?>
    </tbody>
</table>