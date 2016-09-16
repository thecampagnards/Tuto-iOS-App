# TUTO NOTIFICATION

Se connecter à https://developer.apple.com/account/ios/certificate avec ses identifiants Apple et acceder à cette page. Trouver dans la liste le bundle identifier que l'on veut modifier.  Cliquer dessus pour faire dérouler les informations, puis cliquer sur le bouton `Edit`.

![alt text](captures/cap1.png "Capture liste identifiers")

Activer les notifications push.

![alt text](captures/cap2.png "Capture config notification")

Maintenant aller dans le gestionnaire de `Trousseaux d'accès`.

![alt text](captures/cap3.png "Capture trousseaux d'accès")

Dans le menu de la fenètre aller dans `Trousseaux d'accès -> Assistant de certification -> Demander un certificat à une autorité de certificat...`.

![alt text](captures/cap4.png "Capture accès génération")

Renseigner ses données, surtout cocher la case `Enregistrée sur disque`. Enregistrer le fichier.

![alt text](captures/cap5.png "Capture accès génération")

Retour sur le site Apple Developer, cliquer sur `Create Certificate` dans la section `Production SSL Certificate` pour avoir un certificat de production.

![alt text](captures/cap2-2.png "Capture config notification")

Suiver les instructions.

![alt text](captures/notification/cap6.png "Capture instruction certificat")

Choisir le certificat crée précédement avec l'aide du `Trousseaux d'accès`.

![alt text](captures/notification/cap7.png "Capture upload certificat")

Cliquer sur `Continue`.

![alt text](captures/notification/cap8.png "Capture upload certificat")

Télécharger le certificat en cliquant sur `Download`.

![alt text](captures/notification/cap9.png "Capture téléchargement certificat")

Aller dans le `Finder` à l'endroit du téléchargement du fichier et double cliquer sur le fichier téléchargé.

![alt text](captures/notification/cap10.png "Capture finder certificat")

La fenetre du `Trousseaux d'accès` devrait s'ouvrir avec votre certificat `Push Services`.

![alt text](captures/notification/cap11.png "Capture trousseaux certificat")

Dérouler le afin de voir la clé privée.

![alt text](captures/notification/cap12.png "Capture trousseaux certificat détails")

Faites un clique droit sur la clé privée et cliquer sur `Exporter "..."`.

![alt text](captures/notification/cap13.png "Capture trousseaux certificat détails clique")

Renseigner les champs de cette façon puis cliquer sur `Enregistrer`.

![alt text](captures/notification/cap14.png "Capture trousseaux certificat enregistrer")

Un mot de passe vous sera demandé, garder le vous en aurez besoin. Cliquer sur `Ok`.

![alt text](captures/notification/cap15.png "Capture trousseaux certificat mot de passe")

C'est bon votre certificat de notification de production iOS est généré. Vous pouvez effectuer les mêmes étapes pour le certificat de developpement si vous voulez tester les notifications en mode dev.
