
# Technical Assessment

If you are reading this file, congratulations! You are in the NLC technical assessment phase. At this stage, you will be responsible for solving some bugs in this project, as well as making new implementations. But first, let's install and understand a little more about the project.

## Installation

The backend project is built using Laravel, and you can install the project using Docker through Sail. Make sure Docker is running on your machine and run the command below:


```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```

With the dependencies installed, let's now upload the containers. Run the command below:

```bash
./vendor/bin/sail up -d
```

## To Do 

Description: Let's divide the challenge into two parts. In the first part, you have to maintain existing code, while in the second part, you will build the logic from scratch. If you encounter difficulty solving one part or another of the challenge, mark the checkboxes as you solve the challenges.

### First Part: Fixing Bugs

The project in question is based on the architecture of our real project. When reviewing the code, you will notice that there is a resource called "User" and it is a RESTful application (or at least it should be). The system is incomplete by nature, so you have the opportunity to demonstrate your knowledge by fixing errors. Below are some implementations you need to do. I will leave some errors unmentioned so that you can correct them without specific guidance. Initially, what you need to do is:


- [ ]  The user's delete method is not working; identify the reason and fix it.
- [ ]  The method that lists only one user is not functioning and needs the bug identified and corrected.
- [ ]  When creating a user, the system is allowing a name field with a maximum of 10 characters, when it should actually allow up to 255 characters.
- [ ]  In the user list, the 'created_at' field is not appearing.

### Second Part: Creating a New Resource

Description: You now need to create a new resource. The field is "Address". This table has a one-to-many relationship with the users' table (that is, a user can have one or more addresses). The address table must have fields such as City, State, Country, Postal Code, and Complement. Given the structure, you need to do the following:

- [ ]  Create the database structure using migrations.
- [ ]  Populate the data using seeders and factories.
- [ ]  Create the model with the appropriate relationships; both the "Address" model needs to have the relationship with the "User" and vice versa.
- [ ]  Create a service layer to maintain the system's business rules.
- [ ]  Create the controller layer.
- [ ]  Create endpoints.
- [ ]  Create a data validation layer.
- [ ]  Create a data display layer.
