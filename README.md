# CRM/ERP - ManageYourWork

*Reprise avec le framework Laravel*

## Présentation

Projet personnel qui a pour objectif de créer une structure permettant de gérer son entreprise :
* Lister les clients
* Une messagerie (tickets) pour le support de projets
* Liste des projets
* Génération de documents (factures/devis/reçus)
* Gestionnaire d'événements (via un agenda)
* Affichage de tous les log (tous les mouvements sur l'application répertoriés)

------------------------------------------

## Infos

* Gestion des status
* Générateurs de devis ainsi que de factures au format PDF (template de base, avec des blocs modifiables).
* Gestion des clients (création d'un utilisateur avec un rôle client, édition, suppression, statut selon situation).
* Gestion de projets (à titre indicatif affilié à chaque client).
* SoftDeletes. Avec une corbeille permettant de restaurer ou de supprimer définitivement un élément.

## Todo

* Gestion des tickets avec les clients (comme une messagerie interne, mais avec des statuts selon la situation et des étapes selon la progression).
* Affichage des logs de l'application.
* Calendrier, avec mise en place d'événements.

