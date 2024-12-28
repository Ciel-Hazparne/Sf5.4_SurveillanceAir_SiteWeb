# Projet 2023 Surveillance de la qualité de l’air dans une salle de classe
**Pierre chargé du développement du site Web avec Symfony 5.4 et Axel chargé du développement de l'API REST avec API Platform**
# Présentation générale
Le système vise à surveiller la qualité de l'air dans une salle de classe pour encourager la ventilation des locaux, prévenir les contaminations de Covid et garantir que la concentration de CO2 n'affecte pas l'apprentissage. Le système utilise deux types de capteurs différents pour déterminer la meilleure solution, et ses principales fonctionnalités sont les suivantes :
- Mesures de la température, de l'humidité et du CO2 dans la salle, avec allumage d'un voyant d'alarme en cas de concentration de CO2 trop élevée (utilisation d'Arduino et de capteurs associés).
- Mesures de la températu dans une base de données (utilisation de MariaDB sur un serveur Linux).
- Affichage des mesures en temps réel sur le PC du professeur, ainsi que des courbes de mesure historiques sur un site web hébergé sur un serveur Linux.
re, de l'humidité, du CO2 et des COV (composés organiques volatils) à l'aide d'un capteur EnOcean onnecté au PC du professeur de la salle de classe.
- Enregistrement des mesures dans une base de données (utilisation de MariaDB sur un serveur Linux).
- Affichage des mesures en temps réel sur le PC du professeur, ainsi que des courbes de mesure historiques sur un site web hébergé sur un serveur Linux.
Le travail à réaliser est de récupérer toutes les données du capteur E4000 et du capteur SCD30 pour afficher les valeurs de la température, du Co2, du COV et de l’humidité. Après avoir effectué les tâches ci-dessus, il faudra envoyer les données au serveur web pour les afficher dans la bdd et historiser les données à l’aide d’un code effectué sur QT/MQtt.
