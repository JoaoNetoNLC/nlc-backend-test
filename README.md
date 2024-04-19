
# Backend test

If you are reading this file, congratulations, you are in the NLC technical exam phase, at this stage you will be responsible for solving some bugs in this project, as well as making new implementations. But first of all, let's install and understand a little more about the project.

## Instalation

The backend project is made in Laravel and you can install the project using Docker through [Sail](https://laravel.com/docs/11.x/sail). So make sure Docker is running on your machine and run the command below

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```

With the dependencies installed, let's now upload the containers, run the command below

```bash
./vendor/bin/sail up -d
```

## To do 

Let's divide the challenge into two parts, in the first part you have to maintain existing code while in the second part you will have to build the logic from scratch, if you have difficulty solving one part or another of the challenge, as you you solve the challenges, mark the checkboxes with an.

### first part: fixing bugs

The project in question is based on the architecture of our real project, when looking at the code you will notice that it is a resource called User and it is a Restfull application (or at least it should). The system is incomplete by nature so you have the opportunity to prove your knowledge by fixing errors. I will leave below some implementations that you need to do, but I will leave some errors without comments so that you can correct them without having to say what the error is. A priori what you need to do is:

- [ ]  The user's delete method is not working, you need to identify the reason and fix it;
- [ ]  The method that lists only one user is not working and needs to identify the bug and fix;
- [ ]  When creating the user, the system is allowing a name field with maximum of 10 characters when in reality it should be 255;
- [ ]  In the user list, the created_at field is not appearing;

### second part: creating a new resource

You now need to create a new resource. The field is address, this table has a one-to-many relationship with the users table (that is, a user can have one or more addresses). The address table must have fields such as: City, State, Country, Code and Complement. Given the structure you need to do:

- [ ]  Create the database structure using migrations;
- [ ]  Populate the data using seeders and factories;
- [ ]  Create the modal with the appropriate relationships, both the Model Address needs to have the relationship with the User and vice versa;
- [ ]  Create service layer to maintain the system's business rules;
- [ ]  Create the controller layer;
- [ ]  Create endpoints;
- [ ]  Create data validation layer;
- [ ]  Create data display layer;
