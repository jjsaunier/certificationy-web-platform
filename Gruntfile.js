module.exports = function(grunt) {
    require('load-grunt-tasks')(grunt);

    grunt.initConfig({
        cssmin: {
            combine: {
                options:{
                    report: 'gzip',
                    keepSpecialComments: 0
                },
                files: {
                    'web/css/devicons.css': 'app/Resources/assets/devicons/css/devicons.css',
                    'web/css/report.css': 'web/css/report.css',
                    'web/css/user.css': 'web/css/user.css',
                    'web/css/ie7.css': 'src/Certificationy/Bundle/WebBundle/Resources/public/ie7/ie7.css',
                    'web/css/main.css' : [
                        'web/css/bootstrap.css',
                        'web/css/font-awesome.css',
                        'web/css/bootstrap-theme.css'
                    ]
                }
            }
        },
        less: {
            development: {
                options: {
                    compress: true,
                    yuicompress: true,
                    optimization: 2
                },
                files: {
                    'web/css/report.css': 'app/Resources/CertificationyCertyBundle/private/less/report.less',
                    'web/css/user.css': 'src/Certificationy/Bundle/UserBundle/Resources/private/less/user.less',
                    'web/css/bootstrap.css': 'app/Resources/bootstrap-custom/bootstrap.less',
                    'web/css/font-awesome.css': 'app/Resources/assets/font-awesome/less/font-awesome.less',
                    'web/css/bootstrap-theme.css': [
                        'app/Resources/assets/open-sans-fontface/open-sans.less',
                        'src/Certificationy/Bundle/WebBundle/Resources/private/less/global.less',
                        'src/Certificationy/Bundle/WebBundle/Resources/private/less/bootstrap-theme.less'
                    ]
                }
            }
        },
        //watch: {
        //    styles: {
        //        files: ['less/**/*.less'], // which files to watch
        //        tasks: ['less'],
        //        options: {
        //            nospawn: true
        //        }
        //    }
        //},
        uglify: {
            options: {
                mangle: false,
                sourceMap: true,
                sourceMapName: 'web/js/app.map'
            },
            dist: {
                files: {
                    'web/js/app.min.js': [
                        'app/Resources/assets/jquery/jquery.js',
                        'app/Resources/assets/bootstrap/dist/js/bootstrap.js'
                    ],
                    'web/js/scroll.min.js': 'src/Certificationy/Bundle/WebBundle/Resources/public/js/scroll.js',
                    'web/css/ie7.css': 'src/Certificationy/Bundle/WebBundle/Resources/public/ie7/ie7.js'
                }
            }
        },
        copy: {
            dist: {
                files: [
                    { expand: true, cwd: 'app/Resources/assets/font-awesome/fonts', dest: 'web/fonts', src: ['**'] },
                    { expand: true, cwd: 'app/Resources/assets/bootstrap/dist/fonts', dest: 'web/fonts', src: ['**'] },
                    { expand: true, cwd: 'app/Resources/assets/open-sans-fontface/fonts', dest: 'web/fonts', src: ['**'] }
                ]
            }
        }
    });

    grunt.registerTask('css', ['less','cssmin']);
    grunt.registerTask('js', ['uglify']);
    grunt.registerTask('cp', ['copy']);
};