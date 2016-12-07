/**
 * Automated task management
 */

module.exports = function (grunt) {
    grunt.initConfig({
        sass: {
            compile: {
                src: 'resources/assets/sass/app.scss',
                dest: 'public/assets/css/styles.css'
            }
        },
        cssmin: {
            options: {
                relativeTo: 'public/assets/css/',
                banner: '/*! Grabb The Deal --- v1.0 | Copyright 2016 | Chanx Singha <chanx.singha@grabbthedeal.in> */'
            },
            target: {
                files: {
                    'public/assets/css/styles.min.css': 'public/assets/css/styles.css'
                }
            }
        },
        ts: {
            options: {
                sourceMap: true,
                fast: 'watch'
            },
            compileFile : {
                files: [{
                    src: ['resources/assets/js/src/lib.ts','resources/assets/js/src/exec.ts'],
                    dest: 'resources/assets/js/build/'
                }]
            }
        },
        uglify: {
            minify: {
                options: {
                    sourceMap: true,
                    soureMapUrl: "../../../../resources/assets/js/build/"
                },
                files: {
                    'public/assets/js/build/app.min.js': ['resources/assets/js/build/app.js']
                }
            }
        },
        concat: {
            options: {
                separator: ";\n"
            },
            dist: {
                //expand: true,
                //cwd: 'resources/assets/js/build',
                src: ['resources/assets/js/build/lib.js', 'resources/assets/js/build/exec.js'],
                dest: 'resources/assets/js/build/app.js'
            }
        },
        modernizr: {
            dist: {
                "crawl": false,
                "customTests": [],
                "dest": "public/assets/js/modernizr-output.js",
                "tests": [
                    "cssanimations"
                ],
                "options": [
                    "setClasses"
                ],
                "uglify": true
            }
        },
        copy: {
            img: {
                expand: true,
                cwd: 'resources/assets/img/',
                src: ['*/*','*'],
                dest: 'public/assets/img/'
            },
            css: {
                src: 'resources/assets/js/src/bower_components/perfect-scrollbar/css/perfect-scrollbar.min.css',
                dest: 'public/assets/css/perfect-scrollbar.min.css'
            },
            font: {
                expand: true,
                cwd: 'resources/assets/fonts/',
                src: ['*/*','*'],
                dest: 'public/assets/fonts/'
            },
            js: {
                expand: true,
                cwd: 'resources/assets/js/src/bower_components/',
                src: ['**/*'],
                dest: 'public/assets/js/bower_components/'
            }
        },
        watch: {
            css: {
                files: 'resources/assets/sass/*.scss',
                tasks: ['sass']
            },
            ts: {
                files: 'resources/assets/js/src/*.ts',
                tasks: ['ts']
            },
            js: {
                files: 'resources/assets/js/build/app.js',
                tasks: ['uglify']
            },
            minify: {
                files: 'public/assets/css/styles.css',
                tasks: ['cssmin']
            }
        }
    });

    grunt.loadNpmTasks("grunt-contrib-sass");
    grunt.loadNpmTasks("grunt-contrib-copy");
    grunt.loadNpmTasks("grunt-ts");
    grunt.loadNpmTasks("grunt-contrib-uglify");
    grunt.loadNpmTasks("grunt-contrib-concat");
    grunt.loadNpmTasks("grunt-contrib-cssmin");
    grunt.loadNpmTasks("grunt-contrib-watch");
    grunt.loadNpmTasks("grunt-modernizr");

    grunt.registerTask('default',['sass','uglify','copy','ts:compileFile'])
};
