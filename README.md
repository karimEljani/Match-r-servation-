# MatchTicket — PHP/MySQL

## Installation avec XAMPP

1. Décompresser `match_reservation.zip` dans :
   `C:\xampp\htdocs\`
2. Démarrer Apache et MySQL dans XAMPP.
3. Ouvrir phpMyAdmin :
   `http://localhost/phpmyadmin`
4. Importer le fichier `database.sql`.
5. Ouvrir :
   `http://localhost/match_reservation/`

## Compte administrateur

Email :
`admin@matchticket.local`

Mot de passe :
`admin123`

Si le mot de passe administrateur de démonstration ne fonctionne pas avec votre environnement, créez un hash PHP avec `password_hash('admin123', PASSWORD_DEFAULT)` et remplacez la valeur dans la table `admins`.

## Fonctionnalités

- Inscription et connexion
- Authentification User/Admin
- Liste des matchs
- Réservation de plusieurs places
- Vérification du nombre de places disponibles
- Historique des réservations
- Profil utilisateur
- Dashboard administrateur
- CRUD des matchs
- Gestion des utilisateurs
- Consultation des réservations
- PDO + requêtes préparées
- Design responsive

## Configuration MySQL

Par défaut :
host = localhost
database = match_reservation
user = root
password = vide

Modifier `config/database.php` si nécessaire.
