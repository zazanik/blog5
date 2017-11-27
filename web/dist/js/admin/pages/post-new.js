(function ($) {
  $(document).ready(function () {
    $('.js-datepicker').bootstrapMaterialDatePicker({
      format : 'DD/MM/YYYY HH:mm',
      lang : 'en',
      weekStart : 1,
      cancelText : 'Cancel'
    });
  });
})(jQuery);
