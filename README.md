
# ToDOZone 
## Version 1.0

ToDoZone Application is a web portal for gym coaches who have different trainers. Each coach have the access to his/her trainers so he/she can add, manage and follow up the events which need to be done from the trainers side.

## Appendix

The ToDoZone app has three different user roles:

1. Member/trainer, receives events from coach and changes the event’s status.
2. Coach, add, edit, and delete events for each trainer.
3. Admin, manage, delete coaches profiles


## Tech Stack

**Client:** PHP, HTML, CSS

**Server:** Apache, MySQL


## Roadmap


/* App */ 
* Is the main folder for the frontend files, each forntend.
- Admin: Is frontend for the admin role.
- Assets: Contains all assets like CSS, JS, images, etc.
- Templates: Contains all HTML parts that have been called in different frontends.
- Todo: Contains trainers and coaches frontend file, plus the login, register, and profile file.

/* Auth */
* The main folder for the signin, signup, and signout validation for trainers and coaches.
- signin: 
-- Trainer: Check user then password, set the session variables and the forword to right path.
-- Coach: Check status and user, then password, set the session variables and the forword to right path.
- signup:
-- Coach: POST all variables from the signup form then check Coach username or email is used in the system, check the password is confirmed, then add the user to database.
-- Trainer: POST all variables from the signup form then check Coach status and check Trainer username or email is used in the system, check the password is confirmed, then add the user to database.
- Signout: unset all session variables then destroy the session and forword to login page.

/* Modules*/
* All CRUD are under modules.
- createEvent: let coach add events for trainer from the member page under coach dashboard.
- modifyCoach: let admin change the coach status by POST method.
- modifyEvents: let coach modify, edit, change status, delete the trainers' event by POST method.
- modifyMember: let coach modify, edit, change status, delete the trainer by POST method.
- modifyProfile: let coach/trainer delete and change mobile number or password by POST method
- validateErrors: validate the error by the role of the user.
- validateLogin: validate the session by type, role and forward to right path.

/* root */
- config: Contains the connection to the database.
- 404: Not found page.
- 403: Access forbidden.
- index: Forword to right path by changing the session.
- gitignore: Ignore file while pushing to database.


- Additional browser support
Google Chrome, FireFox

- Add more integrations

- Add more API
TimeAPI, https://timeapi.io
This API used to get the current time for each trainers, so the coach know the crrent time in the trainer's city. 


## Features

- Count the age for users by their birthday date.
- Show the current time for trainers by their timezone. 

- Cross platform


## Authors

- [@AbdulRahmanSai](https://github.com/AbdulRahmanSai)
- [@tike19zt] (https://github.com/tike19zt)

