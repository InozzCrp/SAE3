<?php
require_once("constante.php");

get_session_verification_admin();

get_head();
get_header_dashbord();
$conges = recupererCongesAttente($pdo);
?>
<body>
    <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Date</th>
                    <th>Période</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($congess)): ?>
                    <tr>
                        <td colspan="12">Aucun congé à valider.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($conge as $conges): ?>
                        <tr>
                            <td><?= htmlspecialchars($conge['ID_conges']) ?></td>
                            <td><?= htmlspecialchars($conge['Nom_employe']) ?></td>
                            <td><?= htmlspecialchars($conge['Prenom_employe']) ?></td>
                            <td><?= htmlspecialchars($conge['Date_conges']) ?></td>
                            <td><?= htmlspecialchars($conge['Partie_journee']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
    </table>
</body>