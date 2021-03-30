<?php

require_once '_connect.php';

$pdo = new \PDO(DSN, USER, PASS);

$query = "SELECT * FROM friend";
$statement = $pdo->query($query);
$friends = $statement->fetchAll();

// var_dump($friends);

echo 'Liste des "friends" :' . "<br>";
foreach ($friends as $amis) {
    echo $amis['firstname'] . ' ' . $amis['lastname'] . "<br>";
}
echo '<br> . <br>';

if (!empty($_GET) && isset($_GET['submit'])) {


    $data = array_map('trim', $_GET);
 
    // Déclaration des variables
    $name = $data['lastname'];
    $firstname = $data['firstname'];

    if (empty($name)) {
        $errors[] = 'Le nom est manquant';
    }
    
    if (empty($firstname)) {
        $errors[] = 'Le prénom est manquant';
    }
    
    if (strlen($name)>45){
        $errors[]= "Le Nom est trop long";
    }

    if (strlen($name)>45){
        $errors[]= "Le Prenom est trop long";
    }
    
    if (empty($errors)) {
        // Requete pour ajouter les valeur

        $query = "INSERT INTO friend (`lastname`, `firstname`) VALUES (:lastname,:firstname)";

        $statement = $pdo->prepare($query);
        $statement->bindValue(":lastname", $name);
        $statement->bindValue(":firstname", $firstname);

        $statement->execute();

        header('Location:index.php');
    } else {
        for($i=0;$i< count($errors);$i++) {
            echo $errors[$i]. "<br>";
          }
    }  
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout Friends</title>
</head>

<body>
    <form>
        <div>
            <label class="textLabel" for="name">Nom :</label>
            <br>
            <input type="text" id="name" name="lastname" maxlength="45" placeholder="DUPONT" required/>
        </div>
        <div>
            <label class="textLabel" for="firstname">Prénom :</label>
            <br>
            <input type="text" id="firstname" name="firstname" maxlength="45" placeholder="Pierre" required/>
        </div>
        <div>
            <input type="submit" value="Ajouter" name="submit" />
        </div>
    </form>
</body>

</html>