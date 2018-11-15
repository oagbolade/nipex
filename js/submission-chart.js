$(document).ready(function() {
  $('#general').easyPieChart({
    easing: 'easeOutElastic',
    delay: 3000,
    barColor: '#26B99A',
    trackColor: '#fff',
    scaleColor: false,
    lineWidth: 20,
    trackWidth: 16,
    lineCap: 'butt',
    onStep: function(from, to, percent) {
      $(this.el).find('.general-percent').text(Math.round(percent));
    }
  });
  var chart = window.chart = $('#general').data('easyPieChart');
  $('.js_update').on('click', function() {
    chart.update(Math.random() * 200 - 100);
  });


  $('#legal').easyPieChart({
    easing: 'easeOutElastic',
    delay: 3000,
    barColor: '#26B99A',
    trackColor: '#fff',
    scaleColor: false,
    lineWidth: 20,
    trackWidth: 16,
    lineCap: 'butt',
    onStep: function(from, to, percent) {
      $(this.el).find('.legal-percent').text(Math.round(percent));
    }
  });
  var chart = window.chart = $('#legal').data('easyPieChart');
  $('.js_update').on('click', function() {
    chart.update(Math.random() * 200 - 100);
  });

  $('#personnel').easyPieChart({
    easing: 'easeOutElastic',
    delay: 3000,
    barColor: '#26B99A',
    trackColor: '#fff',
    scaleColor: false,
    lineWidth: 20,
    trackWidth: 16,
    lineCap: 'butt',
    onStep: function(from, to, percent) {
      $(this.el).find('.personnel-percent').text(Math.round(percent));
    }
  });
  var chart = window.chart = $('#personnel').data('easyPieChart');
  $('.js_update').on('click', function() {
    chart.update(Math.random() * 200 - 100);
  });

  $('#finance').easyPieChart({
    easing: 'easeOutElastic',
    delay: 3000,
    barColor: '#26B99A',
    trackColor: '#fff',
    scaleColor: false,
    lineWidth: 20,
    trackWidth: 16,
    lineCap: 'butt',
    onStep: function(from, to, percent) {
      $(this.el).find('.finance-percent').text(Math.round(percent));
    }
  });
  var chart = window.chart = $('#finance').data('easyPieChart');
  $('.js_update').on('click', function() {
    chart.update(Math.random() * 200 - 100);
  });

  $('#nigerianContent').easyPieChart({
    easing: 'easeOutElastic',
    delay: 3000,
    barColor: '#26B99A',
    trackColor: '#fff',
    scaleColor: false,
    lineWidth: 20,
    trackWidth: 16,
    lineCap: 'butt',
    onStep: function(from, to, percent) {
      $(this.el).find('.nigerian-content-percent').text(Math.round(percent));
    }
  });
  var chart = window.chart = $('#nigerianContent').data('easyPieChart');
  $('.js_update').on('click', function() {
    chart.update(Math.random() * 200 - 100);
  });

  $('#qms').easyPieChart({
    easing: 'easeOutElastic',
    delay: 3000,
    barColor: '#26B99A',
    trackColor: '#fff',
    scaleColor: false,
    lineWidth: 20,
    trackWidth: 16,
    lineCap: 'butt',
    onStep: function(from, to, percent) {
      $(this.el).find('.qms-percent').text(Math.round(percent));
    }
  });
  var chart = window.chart = $('#qms').data('easyPieChart');
  $('.js_update').on('click', function() {
    chart.update(Math.random() * 200 - 100);
  });


  $('#hse').easyPieChart({
    easing: 'easeOutElastic',
    delay: 3000,
    barColor: '#26B99A',
    trackColor: '#fff',
    scaleColor: false,
    lineWidth: 20,
    trackWidth: 16,
    lineCap: 'butt',
    onStep: function(from, to, percent) {
      $(this.el).find('.hse-percent').text(Math.round(percent));
    }
  });
  var chart = window.chart = $('#hse').data('easyPieChart');
  $('.js_update').on('click', function() {
    chart.update(Math.random() * 200 - 100);
  });

  $('#declaration').easyPieChart({
    easing: 'easeOutElastic',
    delay: 3000,
    barColor: '#26B99A',
    trackColor: '#fff',
    scaleColor: false,
    lineWidth: 20,
    trackWidth: 16,
    lineCap: 'butt',
    onStep: function(from, to, percent) {
      $(this.el).find('.declaration-percent').text(Math.round(percent));
    }
  });
  var chart = window.chart = $('#declaration').data('easyPieChart');
  $('.js_update').on('click', function() {
    chart.update(Math.random() * 200 - 100);
  });

  $('#product').easyPieChart({
    easing: 'easeOutElastic',
    delay: 3000,
    barColor: '#26B99A',
    trackColor: '#fff',
    scaleColor: false,
    lineWidth: 20,
    trackWidth: 16,
    lineCap: 'butt',
    onStep: function(from, to, percent) {
      $(this.el).find('.product-percent').text(Math.round(percent));
    }
  });
  var chart = window.chart = $('#product').data('easyPieChart');
  $('.js_update').on('click', function() {
    chart.update(Math.random() * 200 - 100);
  });

  $('#total').easyPieChart({
    easing: 'easeOutElastic',
    delay: 3000,
    barColor: '#26B99A',
    trackColor: '#fff',
    scaleColor: false,
    lineWidth: 20,
    trackWidth: 16,
    lineCap: 'butt',
    onStep: function(from, to, percent) {
      $(this.el).find('.total-percent').text(Math.round(percent));
    }
  });
  var chart = window.chart = $('#total').data('easyPieChart');
  $('.js_update').on('click', function() {
    chart.update(Math.random() * 200 - 100);
  });

  //hover and retain popover when on popover content
  var originalLeave = $.fn.popover.Constructor.prototype.leave;
  $.fn.popover.Constructor.prototype.leave = function(obj) {
    var self = obj instanceof this.constructor ?
      obj : $(obj.currentTarget)[this.type](this.getDelegateOptions()).data('bs.' + this.type);
    var container, timeout;

    originalLeave.call(this, obj);

    if (obj.currentTarget) {
      container = $(obj.currentTarget).siblings('.popover');
      timeout = self.timeout;
      container.one('mouseenter', function() {
        //We entered the actual popover – call off the dogs
        clearTimeout(timeout);
        //Let's monitor popover content instead
        container.one('mouseleave', function() {
          $.fn.popover.Constructor.prototype.leave.call(self, self);
        });
      });
    }
  };

  $('body').popover({
    selector: '[data-popover]',
    trigger: 'click hover',
    delay: {
      show: 50,
      hide: 400
    }
  });
});