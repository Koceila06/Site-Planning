
# Site de gestion des plannings


## Présentation du Site
<p> <strong> Le site permet de gérer les plannings dans une formation : </strong></p>
<ul>
<li>Les étudiants : ils peuvent s’inscrire pour des cours de leur formation et voir leur planning personnalisé.
</li>
<li>Les enseignants : Ils sont responsables du cours et peuvent déplacer ou créer des séances (entrées) dans le planning. Il
peuvent également voir leur planning personnalisé.</li>
 <li>L’administrateur : Il fait les tâches de gestion – création/modification des cours, formations, enseignants et étudiants. Il
peut également faire toutes les tâches des étudiants et des enseignants, ainsi que voir le planning pour tout le monde.</li>
 </ul>
 
## Fonctionnalités
<ol>
    <li>
       <strong>les étudiants : </strong></li>
    
<ul>
 <li> Voir la liste des cours de la formation (dans laquelle l’étudiant est inscrit).
   
 </li>
   
 <li>Gestion des inscriptions :
    <ul> 
      <li>Inscription dans un cours</li>
      <li>Désinscription d’un cours</li>
      <li>Liste des cours auxquels l’étudiant est inscrit</li>
      <li>Rechercher un cours dans la liste des cours de la formation</li> 

   </ul> 
   
   
 </li>

 <li> Affichage du planning personnalisé (uniquement les séances des cours auxquels cet étudiant est inscrit) :

  <ul> 
      <li>Intégral</li>
      <li>Par cours</li>
      <li>Par semaine</li>


   </ul>  
   </li>
      
 </ul>
 
 </br>
 <li><strong> Les enseignants : </strong></li>
 <ul>
    <li>Voir la liste des cours dont on est responsable</li>
 <li> Voir le planning personnalisé (les séances dont on est responsable) :

  <ul> 
      <li>Intégral</li>
      <li>Par cours</li>
      <li>Par semaine</li>


   </ul>  
 </li> 
 <li> Gestion du planning :

   <ul> 
      <li>Création d’une nouvelle séance de cours</li>
      <li>Mise à jour d’une séance de cours.</li>
      <li>Suppression d’une séance de cours</li>
      <li>Utilisation 2 vues différentes pour les opérations ci-dessus (par cours et par semaine)</li>


   </ul>  
 </li> 
  <li><strong> Pour l’utilisateur (étudiant ou enseignant) : </strong></li>
      <ul> 
      <li>Création du compte</li>
      <li>Changement de son mot de passe</li>
      <li>Modification du nom/prénom</li>


   </ul> 

    </ul>
    </br>
 <li><strong> Utilisateurs : </strong></li>
 <ul>
 
 <li> Gestion du compte :
    <ul> 
      <li>Création du compte</li>
      <li>Changement de son mot de passe</li>
      
   </ul>    
 </li>
 
 <li> Commande pizza :
    <ul> 
      <li>Liste des pizzas (avec pagination)</li>
      <li>Ajout de pizza dans le panier</li>
      <li>Modification de la quantité des pizzas dans le panier</li>
      <li>Suppression des pizzas du panier</li>
      <li>Affichage du prix total et passage de la commande</li>    
   </ul>   
    
 </li>
 
  <li> Gestion des commandes :
    <ul> 
      <li>Voir la liste des commandes passées triées par date (avec pagination))</li>
      <li>Voir le détail de la commande (pizzas et prix total)r</li>
      <li>Voir les commandes non-récupérées(statuts envoyé,  en traitement, prête)</li> 
   </ul>   
    
 </li>



</ul>
 
 
 </ol>
 </br>
 
## Base de données :
<ul>
    <li>users (id,nom,prenom,login,mdp,type)</li> 
    <li>pizzas(id,nom,description,prix,created_at,updated_at,deleted_at)</li>
    <li>commandes(id,user_id,statut,created_at,updated_at)</li>
    <li>commande_pizza(commande_id,pizza_id,qte)</li>
 </ul>

<br/>

## Comment tester l'application ? :
<ul>
    <li>Créer une base de données sqlite en respectant les noms et champs indiqués ci-dessus </li> 
    <li>Copier le fichier <strong>.env.exemple</strong> dans <strong> .env </strong> et y rajouter les paramètres </li>
    <li>Exécuter <strong>composer update </strong></li>
    <li>Lancer l'application avec <strong> php artisan serve </strong></li>
 </ul>

<br/>

## Outils Utilisés :

Framework Laravel, PHP, Base de Données Sqlite, HTML, CSS. 


## Auteur
Koceila Kemiche
