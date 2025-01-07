<?php
require_once("constante.php");

get_session_verification_admin();

get_head();
get_header_dashbord();

// Déterminer le filtre
$filter = $_GET['filter'] ?? 'active'; // Par défaut, on affiche les actifs
$isArchived = $filter === 'archived' ? 1 : 0;

// Récupération des employés avec le nom du métier
$stmt = $pdo->prepare("
    SELECT 
        employe.*, 
        metier.Nom_metier 
    FROM 
        employe 
    LEFT JOIN 
        metier 
    ON 
        employe.ID_metier = metier.ID_metier
    WHERE
        employe.archive = :archived
");
$stmt->execute([':archived' => $isArchived]);
$employes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<body>
    <div class='p-3 dashboardcontent'>
        <h1>Administration des Employés</h1>
        <form method="GET" action="admin.php">
            <label for="filter">Afficher :</label>
            <select name="filter" id="filter">
                <option value="active" <?= ($_GET['filter'] ?? 'active') === 'active' ? 'selected' : '' ?>>Actifs</option>
                <option value="archived" <?= ($_GET['filter'] ?? '') === 'archived' ? 'selected' : '' ?>>Archivés</option>
            </select>
            <button type="submit">Filtrer</button>
        </form>
        <form action="validationconges.php">
            <button type="submit">Validation des congés</button>
        </form>
        <br><br>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Téléphone</th>
                    <th>Email</th>
                    <th>Location</th>
                    <th>Métier</th>
                    <th>Login</th>
                    <th>Salaire</th>
                    <th>Date d'embauche</th>
                    <th>Nb. Congés Restants</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($employes)): ?>
                    <tr>
                        <td colspan="12">Aucun employé trouvé.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($employes as $employe): ?>
                        <tr class="<?= $isArchived ? 'archived' : '' ?>">
                            <td><?= htmlspecialchars($employe['ID_employe']) ?></td>
                            <td><?= htmlspecialchars($employe['Nom_employe']) ?></td>
                            <td><?= htmlspecialchars($employe['Prenom_employe']) ?></td>
                            <td><?= htmlspecialchars($employe['Telephone_employe']) ?></td>
                            <td><?= htmlspecialchars($employe['Email_employe']) ?></td>
                            <td><?= htmlspecialchars($employe['Location_employe']) ?></td>
                            <td><?= htmlspecialchars($employe['Nom_metier']) ?></td>
                            <td><?= htmlspecialchars($employe['Login_employe']) ?></td>
                            <td><?= htmlspecialchars($employe['Salaire_employe']) ?></td>
                            <td><?= htmlspecialchars($employe['Date_embauche_employe']) ?></td>
                            <td><?= $employe['Nb_conges_restant'] ?></td>
                            <td>
                                <?php if ($isArchived): ?>
                                    <a href="restauration_employe.php?id=<?= $employe['ID_employe'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir restaurer cet employé ?');">Restaurer</a>
                                <?php else: ?>
                                    <a href="modification_employe.php?id=<?= $employe['ID_employe'] ?>">Modifier</a> |
                                    <a href="archivage_employe.php?id=<?= $employe['ID_employe'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir archiver cet employé ?');">Archiver</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <br>
        <a href="ajouter_employe.php">Ajouter un nouvel employé</a>
    </div>

    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .archived {
            background-color: #f8d7da; /* Rouge clair */
            color: #721c24; /* Rouge foncé */
        }
    </style>
</body>