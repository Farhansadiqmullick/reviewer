(function ($) {
  $(document).ready(function () {
    $("#submitPopup").on("submit", function (event) {
      event.preventDefault();
      var formData = new FormData(this);
      formData.append("action", 'handle_submit_form');
      formData.append("nonce", formurl.nonce);
      $.ajax({
          url: formurl.ajaxurl,
          type: "POST",
          data: formData,
          contentType: false,
          processData: false,
          success: function (response) {
              console.log(response);
              alert("Thanks for submitting the design, we will contact you later");
              $('.modal').hide();
              window.location.reload();
          },
          error: function (errorThrown) {
              console.log(errorThrown);
              alert('There has been an error on form submission. Please reload and try again');
          },
      });
  });
  
  });
})(jQuery);
