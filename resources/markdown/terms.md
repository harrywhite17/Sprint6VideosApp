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
- Corregir els errors del 2n sprint.
- Instal·lar el paquet spatie/laravel-permission. Documentació
- Crear una migració per afegir el camp super_admin a la taula dels usuaris.
- Model d’usuaris: afegir les funcions testedBy() i isSuperAdmin().
- Afegir el super_admin al professor a la funció create_default_professor de helpers.
- Crear la funció add_personal_team(), on separem el codi de la creació del team dels usuaris.
- Crear les funcions create_regular_user() amb valors (regular, regular@videosapp.com, 123456789), create_video_manager_user() amb valors (Video Manager, videosmanager@videosapp.com, 123456789), create_superadmin_user() amb valors (Super Admin, superadmin@videosapp.com, 123456789), define_gates() i create_permissions().
- A app/Providers/AppServiceProvider, a la funció boot, registrar les polítiques d’autorització i definir les portes d'accés.
- Posar els permisos i els usuaris superadmin, regular user i video manager per defecte al DatabaseSeeder.
- Publicar els stubs. Exemple
- Crear el test VideosManageControllerTest a la carpeta tests/Feature/Videos. Crear les funcions per comprovar la formatació del vídeo: user_with_permissions_can_manage_videos(), regular_users_cannot_manage_videos(), guest_users_cannot_manage_videos(), superadmins_can_manage_videos(), loginAsVideoManager(), loginAsSuperAdmin(), loginAsRegularUser().
- Crear el test UserTest a la carpeta tests/Unit. Crear la funció isSuperAdmin().
- Afegir a resources/markdown/terms el que heu fet al sprint.
- Comprovar en Larastan tots els fitxers que heu creat.

## Sprint 4
Durant el quart sprint, hem realitzat les següents tasques:
- Corregir els errors del 3r sprint. En cas que als testos no s’hagi comprovat que els usuaris en permisos puguin accedir a la ruta `/videosmanage`, modificar-ho.
- Crear `VideosManageController` en les funcions `testedBy`, `index`, `store`, `show`, `edit`, `update`, `delete` i `destroy`.
- Crear la funció `index` a `VideosController`.
- Revisar que tinguesseu 3 vídeos creats a `helpers` i afegits al `DatabaseSeeder`.
- Crear les vistes per al CRUD que només poden veure-ho els que tinguin els permisos adients: `resources/views/videos/manage/index.blade.php`, `resources/views/videos/manage/create.blade.php`, `resources/views/videos/manage/edit.blade.php`, `resources/views/videos/manage/delete.blade.php`.
- A la vista `index.blade.php`, afegir la taula del CRUD de vídeos.
- A la vista `create.blade.php`, afegir el formulari per posar els vídeos, s’ha d’utilitzar l’atribut `data-qa` per a que sigui més fàcil identificar per als testos.
- A la vista `edit.blade.php`, afegir la taula del CRUD de vídeos.
- A la vista `delete.blade.php`, afegir la confirmació de l’eliminació del vídeo.
- Crear la vista de `resources/views/videos/index.blade.php` on es vegin tots els vídeos tipus la pàgina principal de YouTube i al clicar que porti al detall del vídeo (el `show` del sprint anterior).
- Modificar el test `user_with_permissions_can_manage_videos()` per a que hi hagi 3 vídeos.
- A `helpers` crear els permisos de vídeos per al CRUD i assignar-los als usuaris corresponents.
- A `VideoTest` crear les funcions:
  - `user_without_permissions_can_see_default_videos_page`
  - `user_with_permissions_can_see_default_videos_page`
  - `not_logged_users_can_see_default_videos_page`
- A `VideosManageControllerTest` crear les funcions:
  - `loginAsVideoManager`
  - `loginAsSuperAdmin`
  - `loginAsRegularUser`
  - `user_with_permissions_can_see_add_videos`
  - `user_without_videos_manage_create_cannot_see_add_videos`
  - `user_with_permissions_can_store_videos`
  - `user_without_permissions_cannot_store_videos`
  - `user_with_permissions_can_destroy_videos`
  - `user_without_permissions_cannot_destroy_videos`
  - `user_with_permissions_can_see_edit_videos`
  - `user_without_permissions_cannot_see_edit_videos`
  - `user_with_permissions_can_update_videos`
  - `user_without_permissions_cannot_update_videos`
  - `user_with_permissions_can_manage_videos`
  - `regular_users_cannot_manage_videos`
  - `guest_users_cannot_manage_videos`
  - `superadmins_can_manage_videos`
- Crear les rutes de `videos/manage` per al CRUD de vídeos amb el seu middleware corresponent i la ruta del `index` de vídeos. Les rutes del CRUD han d'aparèixer només quan estàs logejat i la d’índex tant si estàs logejat com si no.
- Afegir navbar i footer a la plantilla `resources/layouts/videosapp`. S’ha de poder navegar entre pàgines.
- Afegir a `resources/markdown/terms` el que heu fet al sprint.
- Comprovar en Larastan tots els fitxers que heu creat.

## Sprint 5
Durant el cinquè sprint, hem realitzat les següents tasques:
- Corregir els errors del 4t sprint.
- Afegir el camp `user_id` a la taula de vídeos. Per a que al crear un vídeo es guardi l’usuari que l’ha afegit. Per tant, s’haurà de modificar el controller, model, helpers...
- En cas que al modificar el codi falla algun test d’un sprint anterior, s’han d’arreglar.
- Crear `UsersManageController` en les funcions `testedBy`, `index`, `store`, `edit`, `update`, `delete` i `destroy`.
- Crear la funció `index` i `show` a `UsersController`.
- Crear les vistes per al CRUD que només poden veure-ho els que tinguin els permisos adients: `resources/views/users/manage/index.blade.php`, `resources/views/users/manage/create.blade.php`, `resources/views/users/manage/edit.blade.php`, `resources/views/users/manage/delete.blade.php`.
- A la vista `index.blade.php`, afegir la taula del CRUD d’usuaris.
- A la vista `create.blade.php`, afegir el formulari per posar els usuaris, s’ha d’utilitzar l’atribut `data-qa` per a que sigui més fàcil identificar per als testos.
- A la vista `edit.blade.php`, afegir la taula del CRUD d’usuaris.
- A la vista `delete.blade.php`, afegir la confirmació de l’eliminació de l’usuari.
- Crear la vista de `resources/views/users/index.blade.php` on es vegin tots els usuaris i es puguin buscar i al clicar a l’usuari que porti al detall de l’usuari i els seus vídeos.
- A `helpers` crear els permisos de gestió dels usuaris per al CRUD i assignar-los als usuaris superadmin.
- A `UserTest` crear les funcions:
  - `user_without_permissions_can_see_default_users_page`
  - `user_with_permissions_can_see_default_users_page`
  - `not_logged_users_cannot_see_default_users_page`
  - `user_without_permissions_can_see_user_show_page`
  - `user_with_permissions_can_see_user_show_page`
  - `not_logged_users_cannot_see_user_show_page`
- A `UsersManageControllerTest` crear les funcions:
  - `loginAsVideoManager`
  - `loginAsSuperAdmin`
  - `loginAsRegularUser`
  - `user_with_permissions_can_see_add_users`
  - `user_without_users_manage_create_cannot_see_add_users`
  - `user_with_permissions_can_store_users`
  - `user_without_permissions_cannot_store_users`
  - `user_with_permissions_can_destroy_users`
  - `user_without_permissions_cannot_destroy_users`
  - `user_with_permissions_can_see_edit_users`
  - `user_without_permissions_cannot_see_edit_users`
  - `user_with_permissions_can_update_users`
  - `user_without_permissions_cannot_update_users`
  - `user_with_permissions_can_manage_users`
  - `regular_users_cannot_manage_users`
  - `guest_users_cannot_manage_users`
  - `superadmins_can_manage_users`
- Crear les rutes de `users/manage` per al CRUD d’usuaris amb el seu middleware corresponent i la ruta de l'índex i el `show` d’usuaris. Les rutes del CRUD i les de l'índex i `show` han d'aparèixer només quan estàs logejat.
- S’ha de poder navegar entre pàgines.
- Afegir a `resources/markdown/terms` el que heu fet al sprint.
- Comprovar en Larastan tots els fitxers que heu creat.