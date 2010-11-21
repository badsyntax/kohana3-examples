These Kohana example files demonstrate basic Kohana 3 functionality, including:

* Base template controller
* View strucutre
* Form usage & validation validation
* Email using SwiftMailer
* Messages
* ORM & models
* Validation in the model
* Authentication (signin, signup, change profile, lost password)
* OAuth (twitter)
* Media compression & caching
* HTML5 Boilerplate & jQuery

*Installation:*

* Use the [ko3_boilerplate.sh](https://gist.github.com/707402) script to clone the repository, update the submodules and setup the database

Alternatively:

* git clone git://github.com/badsyntax/kohana3-examples.git kohana3-project
* cd kohana3-project
* git submodule update --init
* mkdir application/cache && mkdir application/logs && sudo chmod 777 application/cache application/logs
* Setup your database, the SQL can be found in 'application/sql' (or you can use the build scripts located in 'application/build')
* Ensure your database details are set correctly in the config

*Purpose of these files:*

* I'm hoping these files will be useful to those just starting out with Kohana3
* As a site 'boilerplate' 

*Disclaimer:*

I can't take credit for all this code, I've mostly just collated example code from the resouces listed in the [DOCS](https://github.com/badsyntax/kohana3-examples/blob/master/DOCS.md).

Demo:

* Production: [http://kohana3.badsyntax.co/](http://kohana3.badsyntax.co/)
* Development: [http://dev.kohana3.badsyntax.co/](http://dev.kohana3.badsyntax.co/)

Suggestions welcome, send emails to willis.rh@gmail.com
