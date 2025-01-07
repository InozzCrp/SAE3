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
                <?php if (empty($conges)): ?>
                    <tr>
                        <td colspan="12">Aucun congé à valider.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($conges as $conge): ?>
                        <tr>
                            <td><?= htmlspecialchars($conge['ID_conges']) ?></td>
                            <td><?= htmlspecialchars($conge['Nom_employe']) ?></td>
                            <td><?= htmlspecialchars($conge['Prenom_employe']) ?></td>
                            <td><?= htmlspecialchars($conge['Date_conge']) ?></td>
                            <td><?= htmlspecialchars($conge['Partie_journee']) ?></td>
                        <td>
                            <form method="post" action="validationconges.php?status=accept">
                                <button class="btn btn-success border border-dark" type="submit">Accepter</button>
                                <input type="hidden" name="idconge" value=<?php echo $conge['ID_conges'];?>></input>
                            </form>
                            <form method="post" action="validationconges.php?status=deny">
                                <button class="btn btn-danger border border-dark" type="submit">Refuser</button>
                                <input type="hidden" name="idconge" value=<?php echo $conge['ID_conges'];?>></input>
                            </form>
                    </td>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
    </table>
</body>

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