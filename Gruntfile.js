module.exports = function(grunt) {
    // Global Configuration
    // use: 
    // globalConfig: globalConfig,
    // Variables: <%= globalConfig.src  %>
    var globalConfig = {
        src: 'web/assets-dev',
        dest: 'web/assets'
    };

    // Project configuration.
    grunt.initConfig({
        globalConfig: globalConfig,
        pkg: grunt.file.readJSON('package.json'),
        
        copy: {
          main: {
            files: [
              // includes files within path
              {expand: true, src: ['bower_components/normalize-opentype.css/normalize-opentype.scss'], dest: '<%= globalConfig.src %>/css/', filter: 'isFile'},
              // copy Prism and Plugins to <%= globalConfig.src %>
              {expand: true, flatten: true, src: ['bower_components/prism/prism.js'], dest: '<%= globalConfig.src %>/js/modules/prism/', filter: 'isFile'},
              {expand: true, flatten: true, src: ['bower_components/prism/plugins/line-numbers/prism-line-numbers.js'], dest: '<%= globalConfig.src %>/js/modules/prism/plugins/line-numbers/', filter: 'isFile'},
              
              {expand: true, flatten: true, src: ['bower_components/prism/themes/prism.css'], dest: '<%= globalConfig.src %>/css/modules/prism/', filter: 'isFile'},
              {expand: true, flatten: true, src: ['bower_components/prism/plugins/line-numbers/prism-line-numbers.css'], dest: '<%= globalConfig.src %>/css/modules/prism/plugins/line-numbers/', filter: 'isFile'}
        
              // includes files within path and its sub-directories
              //{expand: true, src: ['path/**'], dest: 'dest/'},
        
              // makes all src relative to cwd
              //{expand: true, cwd: 'path/', src: ['**'], dest: 'dest/'},
        
              // flattens results to a single level
              //{expand: true, flatten: true, src: ['path/**'], dest: 'dest/', filter: 'isFile'}
            ]
          }
        },
        
        sass: {
            dist: {
                options : {
                    precision : 10/*,
                    style: 'compressed'*/
                },
                files: [{
                    expand : true,
                    cwd : '<%= globalConfig.src %>/css/',
                    src : ['*.scss'],
                    dest : '<%= globalConfig.src %>/css/',
                    ext : '.temp.css'
                }]
            }
        },
        
        concat: {
            css: {
              src: [
                '<%= globalConfig.src %>/css/modules/prism/prism.css',
                '<%= globalConfig.src %>/css/modules/prism/plugins/line-numbers/prism-line-numbers.css',
                '<%= globalConfig.src %>/css/styles.temp.css'
              ],
              dest: '<%= globalConfig.src %>/css/combine.temp.css'
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
		
        cssmin: {
            minify: {
                expand : true,
                cwd : '<%= globalConfig.src %>/css/',
                //src : ['*.css'],
                src : ['combine.temp.css'],
                dest : '<%= globalConfig.dest %>/css/',
                ext : '.min.css',
                options : {
                    report : 'min'
                }
            }
        },
        uglify : {
            my_target: {
              files: [{
                  expand: true,
                  cwd: '<%= globalConfig.src %>/js',
                  //src: '**/*.js',
                  src: 'combine.js',
                  dest: '<%= globalConfig.dest %>/js',
                  ext : '.min.js'
              }]
            }
        },
        watch : {
            scripts : {
                files : [
                    '<%= globalConfig.src %>/css/*.scss',
					'<%= globalConfig.src %>/css/*.css',
                    '<%= globalConfig.src %>/js/*.js',
                    '<%= globalConfig.src %>/js/modules/*.js'
                ],
                tasks : ['copy', 'sass', 'cssmin', 'uglify']
            }
        },
        browser_sync: {
            files: {
                src : [
                    '<%= globalConfig.dest %>/css/*.css',
                    '<%= globalConfig.dest %>/js/*.js',
                    '<%= globalConfig.dest %>/js/modules/*.js',
                    '<%= globalConfig.dest %>/img/*',

                ],
            },
            options: {
                watchTask : true,
                /*host: 'initial.domain.com', // Grunt tells you the port
                server: {
                    baseDir: "web"
                },*/
				proxy: {
                    host: "web"
                },
                ghostMode: {
                    scroll: true,
                    links: true,
                    forms: true
                }
            }
        }
    });

    // Load plugins
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-browser-sync');
    grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-copy');

    // Tasks
    grunt.registerTask('default', ['copy', 'sass', 'concat', 'cssmin', 'uglify']);
    grunt.registerTask('sync', ['browser_sync', 'watch']);
};
