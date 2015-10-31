# WHATS NEW
Reconfigure of Grunt file for much faster builds.
Added feature for documentation - Use Command grunt doc.
	* jsdoc: [http://usejsdoc.org/](http://usejsdoc.org/)
	* sassdoc : [http://sassdoc.com/](http://sassdoc.com/)
Added test feature - npm test or grunt test. Testing feature will be updated in next patch.

# Set Up Directions.

This build is dependent on Ruby, Sass, Grunt, Compass and Node.js

## Dependency Links

* Ruby(for windows): [http://rubyinstaller.org/](http://rubyinstaller.org/)
* Node.js : [http://nodejs.org/](http://nodejs.org/)
* GRUNT : [http://gruntjs.com/](http://gruntjs.com/)


## Sass Set Up

Once Ruby is installed (already installed on MAC), run the following from the command prompt "Command Prompt With Ruby And Rails" (as this understands Linux commands):

	gem install sass

If you get an error, you will have to use 'sudo':

	sudo gem install sass

Next to install Compass: 
	
	gem install compass

Again the 'sudo' might be needed.

This build is configured to use [Sass 3.4.9 Selective Steve](http://sass.logdown.com/) and [Susy 2.1.3](http://susydocs.oddbird.net/en/latest/). If you already had Ruby, Sass and Compass installed, please check your version and update if needed.

## Build Set Up

First install grunt CLI in the global scope:

	npm install -g grunt-cli

After this has been installed, change to the boilerplate directory and run

	npm install

To start the build process simply run:

	grunt

## Build Features

All the work you will do will be in the folder marked pre which has the following sub directories:

* coffee: default folder and file for coffee script.
* packages: directory for bower installed script files.
* sass: directory for all sass files
* scripts: directory and file for plain JavaScript files and build files before concat and uglification.

When you save a file, the build system will do the following. 

* Process any Coffee Script files and place in scripts folder.
* Concatenate Coffee, any packages, and plain javascript to a file called production js.
* Uglify the production.js file and place it in public/scripts as prod.js
* Process Sass files and Add to public/css along with a source map.
* Cleaning of public folder of any extra generated files.
* Automatic screen refresh.

To create documentation for your project, stop the Grunt watch (Ctrl + c), and run grunt document.
For instructions on code markup you can go to these sites:

* [Sass Docs](http://sassdoc.com/)
* [js Docs](http://usejsdoc.org/index.html)

## Further Documentation

* [How to set and configure Sass](COMPASS.md)
* More to come!!!!!










