This project is from the Udemy course 'Object Oriented PHP and MVC' by Brad Traversy.  It is an MVC (Model View Controller) framework which can be built upon to make a web-app.

** config file contains parameters to access the database, as well as app-root, url-root site name and version.  Update these as needed.

** public/.htaccess contains path pointing to the app-root (for the RewriteBase directive) - updates as required.

Framework is setup so that all URL's will get routed through public/index.php.  htaccess files (apache directives) are set up to do this.  So when any http request is made, regardless of url, the public/index.php script is run.  The only role of index.php is to load in bootstrap.php, which itself just loads in (i.e. includes) the config.php script and all the library scripts.  Index.php then just instantiates the Core library class.  The role of the Core class is to parse the url.  The url is formated as http://URLROOT/controller/method/arg1/arg2/..  e.g. http://URLROOT/users/create/23.  The Core class determines from the url, the controller class, the method and args.  It then loads (includes) the corresponding controller file, instantiates the controller class, then calls the method with args as per the url.  The controller classes (named as plurals - e.g. Users) act as intermediatery between the corresponding models classes (names singular - e.g. User) and the View pages. Each controller class should inherit from libraries/Controller.  Model classes interact with dB.  View files (they are not classes, but php scripts that generate html) display the UI.  Controller Class mediates between them.  The constructor of the controller class will create an instance of the corresponding model class to access the dB.  Controller class passes data from the dB to the approproate view for diplay.  Some default models, views, controllers are included () for demo purposes - modify as required.




There are 3 .htaccess files used.
- The .htaccess in /MVC will cause a redirect straight to the public folder from the url /MVC. Without this directive the URL /MVC will display the index listing the public and app.
- The .htaccess in /MVC/app makes the /MVC/app URL inaccessible to the user - Attempting to nav to /MVC/app from the browser will give a 'forbidden' error with this directive.
- The .htaccess in /MVC/public will cause all URL points to a file - if so then that file is loaded.  If not then it redirects to /MVC/public/index.php.  It also appends a query string - ?url=$1.  

The 'home' page of the framework is /MVC/public/index.php.  All URL's will get routed through this file. It first loads all php MVC/app/library files and /MVC/app/helper files via /MVC/app/bootstrap.php.  Then it instantiates the 'core' class. The Core constructor parses the URL and splits it into a controller, method and (optionally) parameters.  It then calls controller->method(parameters).
e.g. the url /MVC/test/about/1 will call controller => Test, method => about, param => 1.

Controllers
The Base controller class is in MVC/app/libraries/Controller.php.  All controllers must extend this.  It contains 2 methods used to load a model and load a view. Parameters to these methods must match the file name of the view / model to be loaded.  Controllers must be located in /MVC/app/controllers and the controller class name needs to match the file name (first letter uppercase).  e.g. controller with class Pages needs to be have file name called Pages.php.  Controllers are used to pass data between the models (which typically access database) and views (which render views with HTML code etc).

Config
/MVC/app/config/config.php contains all constants used throughout the app (and may change on deployment etc) - in particular, values for dB access, application root path, URL root path.

