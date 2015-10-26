# README #

This is a WordPress Plugin and it can record log in attempts on the website.

It creates a custom post type named "loginrecord" and for each log in attempt where the user types in an username and a password a new post will be created.
If WordPress detects the username and password as being valid it will save the user ID, time and the user's IP address.
When incorrect log in details are used these are saved in the database excepting the password when it matches a user's password.
If that is the case, only the (attempted) username is saved and a flag "_detected_existing_password" is saved in the database.

Features to be added:
1.  in case of failed log in, check if the username is in the database (similar to the password) and save the user id instead of the username
2.  display the country based on the saved ip address



### What is this repository for? ###

WordPress Login Record - an WordPress plugin
* version 0.5
* [Learn Markdown](https://bitbucket.org/tutorials/markdowndemo)

### How do I get set up? ###

* Summary of set up
* Configuration
* Dependencies
* Database configuration
* How to run tests
* Deployment instructions

### Contribution guidelines ###

* Writing tests
* Code review
* Other guidelines

### Who do I talk to? ###

* Repo owner or admin
* Other community or team contact