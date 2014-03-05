module.exports = function(grunt){

    grunt.initConfig({
  
        uglify: {
		    my_target: {
		      files: [{
			       	expand: true,     // Enable dynamic expansion.
			        cwd: 'views/',      // Src matches are relative to this path.
			        src: ['**/*.js'], // Actual pattern(s) to match.
			        dest: 'build/',   // Destination path prefix.
			        ext: '.min.js',   // Dest filepaths will have this extension.
			        },
			  ],
		    }
		},

		concat: {
    		le_task: {
    			files: [{
    				src: ['build/**/*.js'],
    				dest: 'backend.min.js'
    			}]
    		}
    	}
    });

    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-concat');

    grunt.registerTask('default', ['uglify','concat']);
};