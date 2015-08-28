# Configuration for Sass

All the configuration is done in the config.rb file. Most of it should be left as is for the build system to work, but here are some configurable options:

* line_comments: Currently set to true for debuging. To turn them off set to false.
* sourcemap : Set to true. If you wish to turn this feature off, set to false. 
* output_style: Set to expanded. Before setting live would be best practice to set to compressed.

All others point to directories used in the grunt file and altering is not recomended.
After any change, exit the batch job (ctrl + c) and restart grunt.