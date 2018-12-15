module.exports = function (grunt) {
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-clean');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-webpack');

  var webpackCommon = require('./webpack.config.4x.babel');

  var distPath = '../../../../../../../uploads/visualcomposer-assets/elements/';


  var elementRegex = new RegExp('.*\/(.*)', 'g');
  var componentName = elementRegex.exec(__dirname)[1];


  grunt.initConfig({
    pkg: grunt
      .file
      .readJSON('package.json'),

    sass: {
      dist: {
        files: [
          {
            expand: true,
            cwd: '.' + componentName + '/styles',
            src: ['base.scss'],
            dest: 'public/styles/css',
            ext: '.css'
          },
        ],
      },
    },
    webpack: {
      common: webpackCommon,
    },
    cssmin: {
      target: {
        files: [
          {
            expand: true,
            cwd: 'public/styles/css',
            src: ['base.css'],
            dest: 'public/styles/minified',
            ext: '.min.css'
          }
        ]
      }
    },
    clean: {
      stylesheets: {
        src: ['public/styles']
      },
      scripts: {
        src: ['public/dist']
      },
      vcElements: {
        src: [distPath + componentName],
        options: {
          force: true
        },
      },
    },

    copy: {
      main: {
        files: [
          // includes files within path
          {
            expand: true,
            cwd: 'public',
            src: ['**'],
            dest: distPath + componentName + '/public',
          },
          {
            expand: true,
            cwd: componentName + '/public/',
            src: ['*.jpg', '*.png'],
            dest: distPath + componentName + '/' + componentName + '/public',
          }
        ],
      },
    },
  });

  grunt.registerTask('build-dev', ['clean', 'webpack:common', 'sass', 'cssmin', 'copy:main']);

};