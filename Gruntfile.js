module.exports = function (grunt) {
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-webpack');
  grunt.loadNpmTasks('grunt-contrib-clean');
  grunt.loadNpmTasks('grunt-exec');
  grunt.loadNpmTasks('grunt-contrib-copy');


  var webpackCommon = require('./webpack.config');
  var webpackConfig = require('./webpack.dev.config');
  var webpackConfigProd = require('./webpack.production.config');

  var srcPath = './twinVectr-engine/components/vcComponents/elements/';


  grunt.initConfig({
    pkg: grunt
      .file
      .readJSON('package.json'),
    exec: {
      execWebpack: {
        cmd: function (file) {
          return 'webpack --config ' + srcPath + file;
        },
        callback: function (error, stdout, stderr) {
          grunt.task.run('copy:main');
        },
        exitCode: [0, 2],
        sync: true,
        shell: true
      }
    },
    sass: {
      dist: {
        files: [
          {
            expand: true,
            cwd: 'assets/styles',
            src: ['base.scss'],
            dest: 'dist/styles/css',
            ext: '.css'
          },
        ],
      },
    },
    webpack: {
      common: webpackCommon,
      prod: webpackConfigProd,
      dev: webpackConfig,
    },
    cssmin: {
      target: {
        files: [
          {
            expand: true,
            cwd: 'dist/styles/css',
            src: ['base.css'],
            dest: 'dist/styles/minified',
            ext: '.min.css'
          }
        ]
      }
    },
    clean: {
      stylesheets: {
        src: ['dist/styles']
      },
      scripts: {
        src: ['dist/js-chunks']
      },
    },
    watch: {
      js: {
        files: ['frontend/**/*.js'],
        tasks: ['clean:scripts', 'webpack:common'],
        options: {
          spawn: false
        }
      },
      stylesheets: {
        files: ['assets/styles/**/*.scss'],
        tasks: [
          'sass', 'cssmin'
        ],
        options: {
          spawn: false
        }
      }
    },
    copy: {
      main: {
        files: [
          // includes files within path
          {
            expand: true,
            cwd: srcPath + '<%= tag %>' + '/' + 'public/',
            src: ['**'],
            dest: '../../uploads/visualcomposer-assets/elements/<%= tag %>/public',
          },
          {
            expand: true,
            cwd: srcPath + '<%= tag %>' + '/' + '<%= tag %>' + '/public/',
            src: ['**'],
            dest: '../../uploads/visualcomposer-assets/elements/<%= tag %>/<%= tag %>/public',
          }
        ],
      },
    },
  });

  grunt.registerTask('build-prod', ['webpack:prod', 'sass', 'cssmin']);
  grunt.registerTask('build-dev', ['webpack:dev', 'sass']);

  grunt.registerTask('build-vc', 'Build All Eelements', function () {
    grunt.file.expand({ cwd: srcPath }, ["*/*.js"])
      .map(function (file) {
        if (file.indexOf('webpack.config.4x.babel') !== -1) {
          grunt.config.set('tag', file.split("/")[0]);
          grunt.task.run('exec:execWebpack:' + file);
        }
      });

  });

};