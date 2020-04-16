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
* Gestion des tickets avec les clients (comme une messagerie interne, mais avec des statuts selon la situation et des étapes selon la progression).
* Générateurs de devis ainsi que de factures au format PDF (template de base, avec des blocs modifiables).
* Gestion des clients (création d'un utilisateur avec un rôle client, édition, suppression, stockage de mot de passe en texte, statut selon situation).
* Gestion de projets (à titre indicatif affilié à chaque client).
* SoftDeletes. Avec une corbeille permettant de restaurer ou de supprimer définitivement un élément.
* Affichage des logs de l'application.
* Calendrier, avec mise en place d'événements.

## Todo

- [ ] Settings colors
- [ ] Tickets
- [ ] Logs
- [ ] Table filters (lines number, by status or price)
- [ ] Table orders (alphabet)
- [ ] Multiple selection in table to do an action - [google search](https://www.google.com/search?client=firefox-b-e&sxsrf=ALeKk022PrRiKw5He8EohHca_CY5FJ7ogw%3A1586789296767&ei=sHuUXvDALqmajLsPk5-98AY&q=laravel+checkbox+table&oq=laravel+checkbox+table&gs_lcp=CgZwc3ktYWIQAzIGCAAQFhAeOgQIABBHOgQIIxAnOgYIIxAnEBM6BQgAEIMBOgQIABBDOgIIADoHCAAQFBCHAjoFCAAQywFKKwgXEicwZzkxZzIwNGcxMDNnOTNnOThnODdnODFnODRnOTBnOTNnOTFnNTlKHQgYEhkwZzFnMWcxZzFnMWcxZzFnMWcxZzVnNWc1UNrGAViv4AFg4uQBaABwAngAgAHCAYgBnQ-SAQQyMC4ymAEAoAEBqgEHZ3dzLXdpeg&sclient=psy-ab&ved=0ahUKEwjw2Pfi0uXoAhUpDWMBHZNPD24Q4dUDCAs&uact=5)
