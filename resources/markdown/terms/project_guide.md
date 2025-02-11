# Project Guide

## Overview
Aquest projecte és una aplicació web per gestionar vídeos. Permet als usuaris crear, editar, veure i eliminar vídeos. També inclou funcionalitats per gestionar usuaris i equips.

## Sprint 1
Durant el primer sprint, hem realitzat les següents tasques:
- Configuració inicial del projecte.
- Creació de models per a `User`, `Team` i `Video`.
- Implementació de les funcionalitats bàsiques de creació i visualització de vídeos.
- Creació de proves unitàries per a la creació d'usuaris i vídeos per defecte.
- Crear el Test de Helpers.
- Al test s’ha de comprovar que es pugui crear l’usuari per defecte i el professor per defecte. Els camps han de ser el name, email i password. La password s’ha d’encriptar. Els usuaris s’han d’associar a un team.
- Crear helpers a la carpeta `app`.
- Crear a `config` les credencials dels usuaris i per defecte que agafi el fitxer `.env`.

## Sprint 2
Durant el segon sprint, hem realitzat les següents tasques:
- Corregir els errors del 1r sprint.
- Al fitxer `phpunit.xml`, descomentar les línies de `db_connection` i `db_database` per tal de que els testos utilitzi una base de dades temporal i no afecti a la base de dades real.
- Crear la migració amb els camps (id, title, description, url, published_at, previous, next, series_id).
- Controlador de vídeos, `VideosController` amb les funcions `testedBy` i `show`.
- Model de vídeos, el camp `published_at` ha de ser una data. Ha de tindre les següents funcions per a retornar la data en diferents formats que siguin llegibles per a l’usuari: `getFormattedPublishedAtAttribute` (retorna una data tipus "13 de gener de 2025"), `getFormattedForHumansPublishedAtAttribute` (retorna una data tipus "fa 2 hores") i `getPublishedAtTimestampAttribute` (retorna el valor Unix timestamp de `published_at`). S’ha d’utilitzar la llibreria Carbon per a manipular les dates i hores.
- Crear un helper de vídeos per defecte.
- Posar els usuaris i vídeos per defecte al `DatabaseSeeder`.
- Crear un layout que es digui `VideosAppLayout`, ha d’estar tant a `app/View/components` com a `resources/views/layouts`.
- Crear la ruta del `show` de vídeos.
- Crear la vista del `show` de vídeos.
- Posar el test `HelpersTest` a la carpeta `tests/Unit`.
- Afegir el test de la creació dels vídeos per defecte al fitxer `HelpersTest`.
- Crear el test `VideosTest` a la carpeta `tests/Unit`. Crear les funcions per comprovar la formatació del vídeo: `can_get_formatted_published_at_date()` i `can_get_formatted_published_at_date_when_not_published()`.
- Crear el test `VideosTest` a la carpeta `tests/Feature/Videos`. S’han de crear les funcions `users_can_view_videos()` i `users_cannot_view_not_existing_videos()`.
- Afegir a `resources/markdown/terms` una petita guia sobre que tracta el projecte i que hem fet als dos sprints.
- S’ha d’instal·lar i configurar el paquet Larastan, que és una eina per analitzar i detectar el codi en busca d’errors. Una vegada configurat, s’ha d’analitzar el codi en busca d’errors i corregir-los.

## Sprint 3
Durant el tercer sprint, hem realitzat les següents tasques:
-Corregir els errors del 2n sprint.
-Instal·lar el paquet spatie/laravel-permission. Documentació
-Crear una migració per afegir el camp super_admin a la taula dels usuaris.
-Model d’usuaris: afegir les funcions testedBy() i isSuperAdmin().
-Afegir el super_admin al professor a la funció create_default_professor de helpers.
-Crear la funció add_personal_team(), on separem el codi de la creació del team dels usuaris.
-Crear les funcions create_regular_user() amb valors (regular, regular@videosapp.com, 123456789), create_video_manager_user() amb valors (Video Manager, videosmanager@videosapp.com, 123456789), create_superadmin_user() amb valors (Super Admin, superadmin@videosapp.com, 123456789), define_gates() i create_permissions().
-A app/Providers/AppServiceProvider, a la funció boot, registrar les polítiques d’autorització i definir les portes d'accés.
-Posar els permisos i els usuaris superadmin, regular user i video manager per defecte al DatabaseSeeder.
-Publicar els stubs. Exemple
-Crear el test VideosManageControllerTest a la carpeta tests/Feature/Videos. Crear les funcions per comprovar la formatació del vídeo: user_with_permissions_can_manage_videos(), regular_users_cannot_manage_videos(), guest_users_cannot_manage_videos(), superadmins_can_manage_videos(), loginAsVideoManager(), loginAsSuperAdmin(), loginAsRegularUser().
-Crear el test UserTest a la carpeta tests/Unit. Crear la funció isSuperAdmin().
-Afegir a resources/markdown/terms el que heu fet al sprint.
-Comprovar en Larastan tots els fitxers que heu creat.