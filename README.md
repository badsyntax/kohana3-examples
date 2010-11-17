These Kohana example files demonstrate basic Kohana 3 functionality, including:

* Template controller
* View strucutre
* Custom base controller
* Form usage
* Form validation
* Contact form
* ORM & models
* Validation in the model
* Authentication using the Auth module
* Simple user signin / signup / change profile
* HTML5 Boilerplate & jQuery

Coming soon..

* OAuth examples
* Open ID examples
* Media compression
* Mobile site
* Ajax base controller
* Example site build script

Setup:

* You will need to set up your database and create the auth tables if you want to use the auth module. 
* The required SQL can be found in 'modules/auth', or you can use the build scripts located in 'application/build'.

Purpose of these files:

* I'm hoping these files will be useful to those just starting out with Kohana3
* As a site 'boilerplate' 

View the [CHANGELOG](https://github.com/badsyntax/kohana3-examples/blob/master/CHANGELOG.md) see an overview of the changes I made to a default Kohana3 install.

If you'd like to view the front-end of these files, you can do so here: [http://kohana3.badsyntax.co/](http://kohana3.badsyntax.co/)

I've set up the modules and Kohana 3 system files as submodules from the stable branches,
when checking out the kohana3-examples repo you will need to 'git submodule init' and 'git submodule update' to download 
the submodule repositories. I'm working on a build script to automate this.

Feel free to do what you want with the example code. 

Suggestions welcome, send emails to willis.rh@gmail.com
