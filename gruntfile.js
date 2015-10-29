'use strict'

module.exports = function(grunt){
	require('load-grunt-tasks')(grunt);
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		 concat:{
		 		dist:{
		 			src:[
		 				'pre/packages/jquery/dist/jquery.js',
		 				'pre/scripts/main.js',
		 				'pre/scripts/coffee.js'
		 			],
		 			dest: 'pre/scripts/production.js',
		 		}//DIST
		 	},//concat
		  copy: {
   	 		build: {
        	cwd: 'pre/',
        	src: ['**/*','!**/sass/**','!**/*coffee','!**/packages/**','!**/scripts/production.js','!**/scripts/main.js','!**/scripts/coffee.js'],
        	dest: 'public',
        	expand: true
      	},
    	},//copy
 			clean: {
  			build: {
    			src: [ 'public','!public/**' ]
  			},
  		scripts: {
    		src: [ 'public/scripts/*.js','!public/scripts/prod.js','!public/scripts/modernizr.custom.min.js']
  			},
			},//clean
			compass: {
				dev: {
					options: {
						config: 'config.rb',
						require: 'susy'
					}//options
				}//dev
			},//compass
			coffee: {
	  		build: {
	    		expand: true,
	    		cwd: 'pre/coffee',
	    		src: [ '*.coffee' ],
	    		dest: 'pre/scripts',
	    		ext: '.js'
	  		}
			},//COFFEE
		 sassdoc: {
				build: {
					src: 'pre/sass/*.scss',
						options: {
        			dest: 'docs/sass-docs'
      		}
				}
			},//SASS DOC
		'jsdoc-ng' : {
  		build : {
    		src: ['pre/scripts/production.js'],
    		dest: 'docs/js-docs',
    		template : 'jsdoc-ng',
  		}
		},//JS-Doc
			coffee: {
	  		build: {
	    		expand: true,
	    		cwd: 'pre/coffee',
	    		src: [ '*.coffee' ],
	    		dest: 'pre/scripts',
	    		ext: '.js'
	  		}
			},//COFFEE
			uglify: {
	  		build: {
	    		src: 'pre/scripts/production.js',
      		dest: 'public/scripts/prod.js'
	    		}
			},//UGLY
	 	watch:{
		 	options: {livereload: true},
	     	scripts: {
       		files: ['pre/scripts/*.js'],
        	tasks: ['scripts'],
         	options: {
           	spawn: false,
         	},
	     	},//scripts
	     	coffee: {
    			files: 'pre/**/*.coffee',
    			tasks: [ 'coffee' ]
  			},
	     	php: {
		 			files: ['*.php']
		 		},//html
		 		sass: {
		 			files:  ['pre/sass/*.scss','pre/sass/settings/*.scss'],
		 			tasks: ['compass:dev']
		 		},
		 		copy:{
		 	    files: ['pre/**/*', '!pre/**/*/sass', '!pre/**/*/coffee'],
		 	    tasks: [ 'copy' ]
		 		}
		 }//watch
  });//initconfig
	
grunt.registerTask('scripts','Compiles the JavaScript files.',[ 'concat', 'uglify','coffee']);
grunt.registerTask('build','Compiles all of the assets.',[ 'clean:build', 'copy', 'scripts' ]);
grunt.registerTask('document','Documents code in js and sass docs.',[ 'jsdoc-ng', 'sassdoc']);
grunt.registerTask('default','Watches the project for changes, automatically builds.',[ 'build','watch']);
};//module