# SlipperyNotes

Project made with the idea of learning Symfony and a few more things along the way. Uses some deprecated things and is not meant to be used or replicated in real use (see more down below).

# Tech Stack

 - DATABASE: PostgreSQL
 - BACK-END: [Symfony](https://symfony.com/) / PHP
 - FRONT-END: [Twig](https://twig.symfony.com/) / [Vue](https://vuejs.org/) / [Symfony UX](https://ux.symfony.com/)
 - CSS FRAMEWORK: [Bulma](https://bulma.io/)


# Project Status

At the moment I'm still working on it, so don't expect to see a fully working app. This is the complete list of features:

 - [X] Database done (Entities, controllers, etc.)
 - [X] Homepage
 - [X] Login and register formularies (With user token, password encryption, etc.)
 - [X] User page (Where he can search, create, delete notes) -> Remains styles (WIP)
 - [X] Notes creation / edit page-> Remains styles (WIP)
 - [X] Erase notes
 - [X] Archive notes
 - [X] Add tags (And allow users to set tags to notes) -> Remains styles (WIP)
 - [ ] Add reminders to the notes and notify users when it's time
 - [ ] Add pagination and search queries
 - [?] Allow to append photos to the notes
 - [?] Configure user data (Add profile picture, add name and surnames, etc.)
 - [ ] Erase account

# WARNING

The project uses FOSCKEditorBundle, which supports CKEDITOR4.
 
CKEditor4 reached its End-of-Life in 2023 and the version the app is using is the 1.16.2 one. This means a lot of security risks exists and are not taken into account because this proyect's purpose 
is for learning and it's not meant to be used in real development environment.