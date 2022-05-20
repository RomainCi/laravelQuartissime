<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<p>Bonjour !</p>

<p>Un nouveau riverain vient de s’inscrire à votre comité de quartier.</p>

<p>Voici ses informations :</p>

<p>Nom : {{$userRiverain[0]->nom}}</p>

<p>Prénom : {{$userRiverain[0]->prenom}}</p>

<p>Adresse Mail : {{$userRiverain[0]->email}}</p>

<p>Adresse: {{$userRiverain[0]->adresse}}</p>

<p>N’hésitez pas à lui souhaiter la bienvenue et à lui communiquer toutes les infos dont il a besoin (associations, évènements).</p>

<p> est un mail automatique, merci de ne pas répondre. Si vous avez des questions relatives à votre inscription, veuillez vous rapprocher de votre comité de quartier le plus proche.</p>

<p>Cordialement,</p>

<p>L’Equipe Quartissime </p>


   
</body>
</html>