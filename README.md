
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

The project in question is based on the architecture of our real project, when looking at the code you will notice that it is a resource called User and it is a Restfull application (or at least it should). The system is incomplete by nature so you have the opportunity to prove your knowledge by fixing errors. I will leave below some implementations that you need to do, but I will leave some errors without comments so that you can correct them without having to say what the error is. A priori what you need to do is:

- The user's delete method is not working, you need to identify the reason and fix it;
- The method that lists only one user is not working and needs to identify the bug and fix;
- When creating the user, the system is allowing a name field with maximum of 10 characters when in reality it should be 255;
- In the user list, the created_at field is not appearing;

[] asd
() asd2
( ) asd3
[ ] asd4
