# KnowledgeCity test app

## Summary

The application does not use any frameworks.
All the code is written in a hurry, but in the flow of creativity.
I tried to make the app as flexible as possible. But there are still many places where not the best solutions are applied.

## Installation

1. Clone the app
2. Make ```composer install```. Note that there are no dependencies in the application. I just use composer autoload.
3. The Apache rootdir must be **/public**
4. Import the database dump.
5. All the application settings files are located in the **/config** directory.
6. All the application routes are located in the **/routes** directory.
7. To log in to the app, you can use one of the following accounts
   1. username: **root**, password: **sudopassword**;
   2. username: **splinter**, password: **kavabanga**;
   3. username: **batman**, password: **iambatman**;

## Information

The application uses a single entry point.

The session duration without "Remember me" attribute is 15 minutes.

At the frontend user [Zepto.js](https://zeptojs.com), [Handlebars.js](https://handlebarsjs.com) & [Axios.js](https://axios-http.com).
