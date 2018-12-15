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
    //new visual composer build each component
    exec: {
      execWebpack: {
        cwd: srcPath + '<%= grunt.option("tag") %>',
        stdout: false,
        cmd: function () {
          return 'grunt build-dev';
        },
      }
    },
    // legacy fontend - build sass
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
    // legacy fontend - webpack build
    webpack: {
      common: webpackCommon,
      prod: webpackConfigProd,
      dev: webpackConfig,
    },
    // legacy fontend - css minified
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
    // legacy fontend - lazy loading clean
    clean: {
      stylesheets: {
        src: ['dist/styles']
      },
      scripts: {
        src: ['dist/js-chunks']
      }
    },
    // legacy fontend - lazy loading watch
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
  });

  // legacy fontend - lazy loading
  grunt.registerTask('build-prod', ['webpack:prod', 'sass', 'cssmin']);
  grunt.registerTask('build-dev', ['webpack:dev', 'sass']);


  // new visual composer build
  grunt.registerTask('compile-vc', function () {
    grunt.option('tag', this.args[0]);
    grunt.task.run(['exec:execWebpack']);
  });

  // run grunt build-vc to build all the visual composer components
  grunt.registerTask('build-vc', 'Build All Eelements', function () {
    var tasks = [];
    grunt.file.expand({ cwd: srcPath }, ["*/*.js"])
      .forEach(function (file) {
        if (file.indexOf('webpack.config.4x.babel') !== -1) {
          var tag = file.split("/")[0];
          tasks.push('compile-vc:' + tag);
        }
      });

    tasks.forEach(function (task) {
      grunt.task.run(task);
    });

  });

};