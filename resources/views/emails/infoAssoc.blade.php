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

<p>Une nouvelle association vient de s’inscrire à votre comité de quartier.</p>

<p>Voici ses informations :</p>

<p>Nom association : {{$userAssoc[0]->nom}}</p>

<p>Adresse Mail : {{$userAssoc[0]->email}}</p>

<p>Adresse: {{$userAssoc[0]->adresse}}</p>

<p>Status Adresse : {{$userAssoc[0]->status}}</p>

<p>Description :  {{$userAssoc[0]->description}}</p>

<p>Telephone : {{$userAssoc[0]->telephone}}</p>




<p>N’hésitez pas à lui souhaiter la bienvenue et à lui communiquer toutes les infos dont il a besoin (associations, évènements).</p>

<p> est un mail automatique, merci de ne pas répondre. Si vous avez des questions relatives à votre inscription, veuillez vous rapprocher de votre comité de quartier le plus proche.</p>

<p>Cordialement,</p>

<p>L’Equipe Quartissime </p>
</body>
</html>