"use strict";
module.exports = function(grunt){
	var SOURCE_DIR = 'pre/',
			SCRIPT_DIR = SOURCE_DIR + 'scripts/',
			BUILD_DIR = 'public/',
			DOC_DIR = 'docs/',
			SASS_FILES = ['pre/sass/*.scss','pre/sass/settings/*.scss','pre/sass/components/*.scss'],
			PHP_FILES =['*.php','library/*.php'];

//LOADS ALL TASKS FROM PACKAGE FILE
	require('load-grunt-tasks')(grunt);

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		coffee: {
  		build: {
    		expand: true,
    		cwd: SOURCE_DIR + 'coffee',
    		src: [ '*.coffee' ],
    		dest: SOURCE_DIR + 'scripts',
    		ext: '.js'
  		}
		},
		concat: {
			options: {
				seperator: ';',
				banner: '/*! <%= pkg.name %> <%= pkg.version %> filename.js <%= grunt.template.today("yyyy-mm-dd h:MM:ss TT") %> */\n'
			},
			dist: {
				src: 	[SCRIPT_DIR + 'main.js',
 							SCRIPT_DIR + 'coffee.js'],
		 		dest: SCRIPT_DIR + 'production.js'
			}
		},//END CONCAT
		uglify: {
			dev: {
				options: {
	        banner: '/*! <%= pkg.name %> <%= pkg.version %> filename.min.js <%= grunt.template.today("yyyy-mm-dd h:MM:ss TT") %> */\n'
        },
        files: {
        	[BUILD_DIR +'scripts/prod.min.js']:['<%= concat.dist.dest %>']
        }
			}
		},//END UGLIFY
		compass: {
			dev: {
				options: {
					config: 'config.rb',
					require: 'susy'
				}
			}
		},//END COMPASS
		jshint: {
			files:['<%= concat.dist.dest %>'],
			options: {
				globals: {
					jQuery: true,
					console: true,
				 	indent: false,
					module: true
				}
			}
		},//ENDS JSHINT
		'jsdoc-ng' : {
  		build : {
    		src: ['<%= concat.dist.dest %>'],
    		dest: 'docs/js-docs',
    		template : 'jsdoc-ng',
  		}
		},//ENDS JS_DOCS
		sassdoc: {
			build: {
				src: SASS_FILES,
					options: {
      			dest: 'docs/sass-docs'
    		}
			}
		},//END SASS DOCS
		watch: {
			options: {livereload: true},
			scripts: {
				files: [SCRIPT_DIR + '*.js'],
				tasks: ['scripts'],
				options: {
					spawn: false
				}
			},//END SCRIPTS
			coffee: {
  			files: SOURCE_DIR + '**/*.coffee',
  			tasks: [ 'coffee' ]
			},//END COFFEE
			php: {
	 			files: [PHP_FILES]
	 		},//END PHP
	 		sass: {
	 			files:  [SASS_FILES],
	 			tasks: ['compass:dev']
	 		}
		}

	});//END INITCONFIG
grunt.registerTask('scripts','Compiles the JavaScript files.',[ 'concat', 'uglify','coffee']);
grunt.registerTask('build','Compiles all of the assets.',['scripts' ]);
grunt.registerTask('test','Tests MVC',['jshint']);
grunt.registerTask('doc','Documents code in js and sass docs.',[ 'jsdoc-ng', 'sassdoc']);
grunt.registerTask('default','Watches the project for changes, automatically builds.',[ 'build','watch']);

};//END EXPORTS

