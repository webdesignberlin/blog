module.exports = function(grunt) {

    'use strict';

    /* + Global Project Vars */
    // Usage: <%= globalConfig.var %>
    var globalConfig = {
        root: '.',
        temp: 'web/assets-temp',
        src:  'web/assets-dev',
        dest: 'web/assets'
    };
    /* = Global Project Vars */
    
    /* + Preparation */
    require('load-grunt-tasks')(grunt); // Load all grunt tasks matching the `grunt-*` pattern
    grunt.util.linefeed = '\n'; // Force use of Unix newlines
    /* = Preparation */

    /* + Project Tasks */
    
    grunt.initConfig({
        globalConfig: globalConfig, // include Global Config
        pkg: grunt.file.readJSON('package.json'), // Get npm package data

        /* + Task Config: Clean */
        clean: {
            deps: [
                ['<%= globalConfig.temp %>/']
            ]
        },
        /* = Task Config: Clean */



        /* + Task Config: Copy dependency files */
        copy: {
            // local jquery
            jquery: {
                expand: true,
                src: '<%= globalConfig.root %>/bower_components/jquery/dist/*',
                dest: '<%= globalConfig.dest %>/js/vendor/jquery/',
                flatten: true
            },
            opentype: {
                // includes files within path
                expand: true, 
                src: ['bower_components/normalize-opentype.css/normalize-opentype.scss'], 
                dest: '<%= globalConfig.src %>/css/', 
                filter: 'isFile'
            },
            // Prism and Plugins
            prismJs: {
                    expand: true, 
                    flatten: true, 
                    src: ['bower_components/prism/prism.js'], 
                    dest: '<%= globalConfig.src %>/js/modules/prism/', 
                    filter: 'isFile'  
            },
            prismJsPlugin: {
                    expand: true, 
                    flatten: true, 
                    src: ['bower_components/prism/plugins/line-numbers/prism-line-numbers.js'], 
                    dest: '<%= globalConfig.src %>/js/modules/prism/plugins/line-numbers/', 
                    filter: 'isFile'    
                },
            prismCss: {
                    expand: true, 
                    flatten: true, 
                    src: ['bower_components/prism/themes/prism.css'], 
                    dest: '<%= globalConfig.src %>/css/modules/prism/', 
                    filter: 'isFile'                    
                },
            prismCssPlugin: {
                    expand: true, 
                    flatten: true, 
                    src: ['bower_components/prism/plugins/line-numbers/prism-line-numbers.css'], 
                    dest: '<%= globalConfig.src %>/css/modules/prism/plugins/line-numbers/', 
                    filter: 'isFile'                    
                },
            prismCssTheme: {
                    expand: true, 
                    flatten: true, 
                    src: ['bower_components/prism/themes/prism-okaidia.css'], 
                    dest: '<%= globalConfig.src %>/css/modules/prism/', 
                    filter: 'isFile'    
            }
        },
        /* = Task Config: Copy dependency files */

        /* + Task config: Update json */
        update_json: {
            bower: {
                src: 'package.json',
                dest: 'bower.json',
                fields: [
                    'name',
                    'version'
                ]
            }
        },
        /* = Task config: Update json */



        /* + Task Config: Concatenation */
        concat: {
            css: {
              src: [
                '<%= globalConfig.src %>/css/modules/prism/prism.css',
                '<%= globalConfig.src %>/css/modules/prism/prism-okaidia.css',
                '<%= globalConfig.src %>/css/modules/prism/plugins/line-numbers/prism-line-numbers.css',
                '<%= globalConfig.temp %>/css/main.css'
              ],
              dest: '<%= globalConfig.temp %>/css/combine.css'
            },
    
            js: {
              options: {
                separator: ';',
              },
              src: [
                '<%= globalConfig.src %>/js/modules/prism/prism.js',
                '<%= globalConfig.src %>/js/modules/prism/plugins/line-numbers/prism-line-numbers.js',
                '<%= globalConfig.src %>/js/main.js'
              ],
              dest: '<%= globalConfig.src %>/js/combine.js'
            }
        },
        /* = Task Config: Concatenation */



        /* + Task Config: SASS */
        sass: {
            options : {
                precision: 10,
                sourcemap: true,
                trace: true,
                unixNewlines: true,
                cacheLocation: '<%= globalConfig.root %>/.sass-cache'
            },
            styles: {
                files: [{
                    src: '<%= globalConfig.src %>/css/main.scss',
                    dest: '<%= globalConfig.temp %>/css/main.css'
                }]
            }
        },
        /* = Task Config: SASS */



        /* + Task Config: Autoprefixer */
        autoprefixer: {
            options: {
                browsers: [ // @https://github.com/ai/autoprefixer#browsers
                    'last 2 versions'
                ],
                map: false // not supported by cssmin
            },
            styles: {
                no_dest: {
                    src: '<%= globalConfig.temp %>/css/main.css'
                }
            }
        },
        /* = Task Config: Autoprefixer */



        /* + Task Config: CSSMin */
        cssmin: {
            // SourceMaps maybe with 2.1: https://github.com/GoalSmashers/clean-css/issues/125
            styles: {
                files: {
                    '<%= globalConfig.dest %>/css/main.min.css': [
                        '<%= globalConfig.temp %>/css/combine.css'
                    ]
                }
            }
        },
        /* = Task Config: CSSMin */



        /* + Task Config: JSHint */
        jshint: {
            options: {
                'indent'   : 4,
                'quotmark' : 'single'
            },
            scripts: {
                src: '<%= globalConfig.src %>js/main.js'
            }
        },
        /* = Task Config: JSHint */



        /* + Task Config: Uglify */
        uglify: {
            options: {
                sourceMap: true,
                sourceMapName: '<%= globalConfig.temp %>/js/main.js.map',
                sourceMapIncludeSources: true
            },
            scripts: {
                files: {
                    '<%= globalConfig.dest %>/js/main.min.js': [
                        '<%= globalConfig.src %>/js/main.js'
                    ]
                },
            }
        },
        /* = Task Config: Uglify */



        /* + Task Config: Browser Sync */
        browserSync: {
            elena: {
                bsFiles: {
                    src : ['web/*']
                },
                options: {
                    //proxy: "frontend.mg.code.bytenetz.de",
                    //watchTask: true,
                    ghostMode: {
                        clicks: true,
                        location: true,
                        forms: true,
                        scroll: true
                    },

                    server: {
                        baseDir: "web",
                        directory: true
                    }
                }
            }
        },
        /* = Task Config: Browser Sync */



        /* + Task Config: Watch */
        watch: {
            options: {
                livereload: false
            },
            json: {
                files: [
                    'package.json'
                ],
                tasks: [
                    'build-json'
                ]
            },
            styles: {
                files: [
                    '<%= globalConfig.src %>/css/*.scss',
                    '<%= globalConfig.src %>/css/**/*.scss',
                    '<%= globalConfig.src %>/css/*.css',
                    '<%= globalConfig.src %>/css/**/*.css'
                ],
                tasks: [
                    'build-css'
                ]
            },
            scripts: {
                files: [
                    '<%= globalConfig.src %>/js/*.js',
                    '<%= globalConfig.src %>/js/**/*.js'
                ],
                tasks: [
                    'build-js'
                ]
            },
            grunt: {
                files: [
                    'Gruntfile.js'
                ],
                tasks: [
                    'jshint:grunt'
                ]
            }
        },
        /* = Task Config: Watch */



    });
    /* = Project Configuration */



    /* + Custom Tasks */

    // copy dependencies
    grunt.registerTask( 'copy-deps', [
        'clean:deps',
        'copy'
    ]);

    // process stylesheets
    grunt.registerTask( 'build-css', [
        //'clean:css',
        'sass',
        'concat:css',
        'autoprefixer',
        'cssmin'
    ]);

    // process javascripts
    grunt.registerTask( 'build-js', [
        //'clean:js',
        'concat:js',
        'jshint:scripts',
        'uglify'
    ]);

    // process everything
    grunt.registerTask( 'build', [
        'update_json:bower',
        'copy-deps',
        'build-css',
        'build-js'
    ]);

    // start sync and watch
    grunt.registerTask( 'sync', [
        'browserSync',
        'watch'
    ]);

    // build job as default
    grunt.registerTask( 'default', [
        'build'
    ]);

    /* = Custom Tasks */

 };
