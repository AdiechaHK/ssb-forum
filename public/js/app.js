$(document).ready(function() {
  $(".ssb-popup-backdrop").click(function() {
    var self = this;
    $(self).addClass('fadeOut animated');
    $(".ssb-popup", self).addClass('zoomOut animated');
  });
});