# SlipperyNotes

Project made with the idea of learning Symfony and a few more things along the way. Uses some deprecated things and is not meant to be used or replicated in real use (see more down below).

# Tech Stack

 - DATABASE: PostgreSQL
 - BACK-END: [Symfony](https://symfony.com/) / PHP
 - FRONT-END: [Twig](https://twig.symfony.com/) / [Vue](https://vuejs.org/) / [Symfony UX](https://ux.symfony.com/)
 - CSS FRAMEWORK: [Bulma](https://bulma.io/)


# Project Status

At the moment the project is done, basically because all the main features are done and most of the things I wanted to learn are fullfiled. 

Some things remain undone, like adding more styles (mostly). The list of features are:

 - [X] Database done (Entities, controllers, etc.)
 - [X] Homepage
 - [X] Login and register formularies (With user token, password encryption, etc.)
 - [X] User page (Where he can search, create, delete notes) -> Remains styles (WIP)
 - [X] Notes creation / edit page-> Remains styles (WIP)
 - [X] Erase notes
 - [X] Archive notes
 - [X] Add tags (And allow users to set tags to notes) -> Remains styles (WIP)
 - [X] Add reminders to the notes and notify users when it's time
 - [X] Add pagination and search queries

# INSTALLATION

Once you've downloaded the proyect and inside the folder, you will have to execute the following commands in a terminal:
> composer install

> npm install

> php bin/onsole doctrine:database:create

> php bin/console doctrine:migrations:migrate 'DoctrineMigrations\Version20241202115317'


Then, for starting the app:
> symfony server:start

> npm run watch

# USAGE

Once the app is up and running, you'll have to create an account and log-in. Then, you will be redirected to your dashboard / notes page.
On the navbar, you will see three sections: *Notes*, *Archived* and *Reminders*

- Notes: Where all the notes you create show. It doesn't show those that are archived.
- Archived: Where all the archived notes show.
- Reminders: Filters all the notes by reminder date.

If you wanted to delete, archive, or add a tag to more than one note, you can hold and click notes to show new options in the navbar.

# WARNING

The project uses FOSCKEditorBundle, which supports CKEDITOR4.
 
CKEditor4 reached its End-of-Life in 2023 and the version the app is using is the 1.16.2 one. This means a lot of security risks exists and are not taken into account because this proyect's purpose 
is for learning and it's not meant to be used in real development environment.