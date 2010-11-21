These Kohana example files demonstrate basic Kohana 3 functionality, including:

* Custom base template controller
* View strucutre
* Form usage
* Form validation
* Messages
* Contact form using SwiftMailer
* ORM & models
* Validation in the model
* Authentication using the Auth module
* Simple user signin / signup / change profile
* HTML5 Boilerplate & jQuery

Coming soon..

* OAuth
* Open ID
* Media compression
* Mobile
* Ajax base controller

Installation:

I suggest using the [ko3_boilerplate.sh](https://gist.github.com/707402) script to clone the repository and setup the database, otherwise follow these instructions:

* git clone git://github.com/badsyntax/kohana3-examples.git kohana3-project
* cd kohana3-project
* git submodule update --init
* mkdir application/cache && mkdir application/logs && sudo chmod 777 application/cache application/logs
* Setup your database, the SQL can be found in 'modules/auth' (or you can use the build scripts located in 'application/build')
* Ensure your database details are set correctly in the config

Purpose of these files:

* I'm hoping these files will be useful to those just starting out with Kohana3
* As a site 'boilerplate' 

Demo:

* [http://kohana3.badsyntax.co/](http://kohana3.badsyntax.co/)

Feel free to do what you want with the example code.

Suggestions welcome, send emails to willis.rh@gmail.com
