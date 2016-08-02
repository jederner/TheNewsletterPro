module.exports = function(grunt) {
	// Project configuration
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		uglify: {
			options: {
				// banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
			},
			build: {
				src: 'src/js/global.js',
				dest: 'assets/js/<%= pkg.name %>.min.js'
			}
		},
		less: {
			development: {
				files: {
					"assets/css/global.css": "src/less/build.less"
				}
			}
		},
		cssmin: {
			combine: {
				files: {
					'assets/css/global-min.css': ['assets/css/global.css']
				}
			}
		},
		watch: {
			scripts: {
				files: ['src/less/*.less', 'src/js/*.js'],
				tasks: ['uglify','less','cssmin']
			},
			options: {
				livereload: true,
			}
		}
	});
	// Load the plugin that provides the "uglify" task.
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-cssmin');

	// Default task(s).
	grunt.registerTask('default', ['uglify','less','cssmin']);
};