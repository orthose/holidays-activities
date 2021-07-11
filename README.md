# Introduction
Site web répertoriant des idées d'activités pour les vacances.
Principalement écrit en PHP, il se compose d'une page d'accueil,
et de fichiers JSON de liens URL, convertis par PHP en pages
HTML. Le site intègre également une feature de commentaires
liés à chacune des activités listées. L'envoi des commentaires
est fait en pur PHP à l'aide d'un formulaire en POST.
Le Javascript est uniquement utilisé pour déplier et plier le menu
d'envoi de commentaire.

# Mise en production
* Cloner le site sur un serveur pouvant exécuter PHP.
`cd /var/www/html; git clone https://github.com/orthose/holidays-activities`
* Vérifier que chaque fichier .json est accessible en lecture et écriture à PHP.
`chmod o+rw *.json`
* Pour mettre à jour le site si des changements ont été effectués sur le dépôt
`git pull`

# Ajouter des pages
Une page est un fichier .json suivant une syntaxe précise. En cas d'erreur de
syntaxe dans le JSON, une erreur sera renvoyée à l'utilisateur.
De plus, pour être accessible la page doit être ajoutée dans la liste de liens de
index.html, avec l'URL suivante : `requests.php?page=chemin-fichier`.
Attention : n'indiquez pas l'extension .json sinon cela ne fonctionnera pas.

La syntaxe d'une page JSON est une liste d'objets représentant des balises HTML.
Trois objets sont implémentés, et doivent être imbriqués correctement.
Voici une exemple de fichier accepté.
```
[
  {"h1": "Titre Principal"},
  {"h2": "Titre Secondaire"},
  {"ul": [
    {"activity": "Programmer en PHP", "link": "https://www.php.net/", "comments": []},
    {"activity": "Programmer en Javascript", "link": "https://developer.mozilla.org/fr/docs/Learn/JavaScript/First_steps/What_is_JavaScript", "comments": []}
  ]}
]
```
Notez que le champ "activity" est une clé unique, donc pour éviter tout problème,
il faut respecter cette unicité, et éviter qu'elle ne soit trop longue.