$(".form_validation").validate({
  errorElement: 'span', //default input error message container
  errorClass: 'help-block help-block-error', // default input error message class

  rules: validation_rules,

  invalidHandler: function (event, validator) { //display error alert on form submit
      $('.alert-success').hide();
      $('.alert-danger').show();
      App.scrollTo($('.alert-danger'), -200);
  },

  highlight: function (element) { // hightlight error inputs
     $(element)
          .closest('.form-group').addClass('has-error'); // set error class to the control group
  },

  unhighlight: function (element) { // revert the change done by hightlight
      $(element)
          .closest('.form-group').removeClass('has-error'); // set error class to the control group
  },

  success: function (label) {
      label
          .closest('.form-group').removeClass('has-error'); // set success class to the control group
  },

  submitHandler: function (form) {
      $('.alert-success').show();
      $('.alert-danger').hide();
      form[0].submit(); // submit the form
  }
});