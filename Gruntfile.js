
module.exports = function(grunt) {

    grunt.initConfig({

        pkg: grunt.file.readJSON('package.json'),

        //minify js and output 2 .min.js files
        uglify: {
            options: {
                banner: '/*RedCodeBlueCode*/'
            },
            dist: {
                files: {
                    'assets/js/min/core.min.js': ['assets/js/*.js'],
                    'public/assets/js/core.min.js': ['public/assets/js/*.js']
                }
            }
        },

        //compile sass
        sass: {
            dist: {
                options: {
                    style: 'expanded'
                },
                files: {
                    'assets/css/core.css': 'assets/css/core.scss',
                    'public/assets/css/core.css': 'public/assets/css/core.scss',
                }
            }
        },

        //minify css
        cssmin: {
            dist: {
                options: {
                    banner: 'RedCodeBlueCode'
                },
                files: {
                    'assets/css/min/core.min.css': ['assets/css/*.css'],
                    'public/assets/css/min/core.min.css': ['public/assets/css/*.css']
                }
            }
        },

        //run tasks again on changes in js and css files
        watch: {
            files: [
                'Gruntfile.js', 
                
                'assets/js/*.js',
                'assets/css/*.css', 
                'assets/css/*.scss', 
                'assets/css/sass/*.scss',
                
                'public/assets/js/*.js',
                'public/assets/css/*.css', 
                'public/assets/css/*.scss', 
                'public/assets/css/sass/*.scss'
            ],
            tasks: [
                'uglify', 'sass', 'cssmin'
            ]
        },

        //check php, manually executed
        phpcs: {
            application: {
                dir: '/includes/model/*.php'
            },
            options: {
                bin: '/usr/bin/phpcs'
            }
        },
    });

    grunt.loadNpmTasks('grunt-phpcs');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.registerTask('default', ['uglify', 'sass', 'cssmin','watch']);

};
