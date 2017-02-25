/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
'use strict';

(function ($) {
  // Site title and description.
  wp.customize('blogname', function (value) {
    value.bind(function (to) {
      $('.title a').text(to);
    });
  });
  wp.customize('blogdescription', function (value) {
    value.bind(function (to) {
      $('.description').text(to);
    });
  });

  // Header text color.
  wp.customize('header_textcolor', function (value) {
    value.bind(function (to) {
      if (to === 'blank') {
        $('.title a, .description').css({
          'clip': 'rect(1px, 1px, 1px, 1px)',
          'position': 'absolute'
        });
      } else {
        $('.title a, .description').css({
          'clip': 'auto',
          'position': 'relative'
        });
        $('.title a, .description').css({
          'color': to
        });
      }
    });
  });
})(jQuery);
