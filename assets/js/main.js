(function ($) {
  $(document).ready(function () {
    $("#submitPopup").on("submit", function (event) {
      event.preventDefault();
      var formData = new FormData(this);
      formData.append("action", "handle_submit_form");
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
          $(".modal").hide();
          window.location.reload();
        },
        error: function (errorThrown) {
          console.log(errorThrown);
          alert(
            "There has been an error on form submission. Please reload and try again"
          );
        },
      });
      wp_die();
    });

    $(".zoom-box img").jqZoom({
      selectorWidth: 30,
      selectorHeight: 30,
      viewerWidth: 400,
      viewerHeight: 300,
    });

    //Load content

    var currentKey = 0; // Initialize the current key

    // Handle the "Next" and "Prev" button clicks
    $(".next").click(function () {
      console.log(currentKey);
      var nextKey = currentKey + 1;
      var totalCount = parseInt($(this).data("count"));
      var category = $(this).data("category");
      if (nextKey < totalCount) {
        // Replace with the total count of $values
        loadContent(nextKey, category, totalCount);
      }
    });

    $(".prev").click(function () {
      var prevKey = currentKey - 1;
      var category = $(this).data("category");
      var totalCount = parseInt($(this).data("count"));
      if (prevKey >= 0) {
        loadContent(prevKey, category, totalCount);
      }
    });

    // Initially disable the "Prev" button if currentKey is 0
    $(".prev").prop("disabled", currentKey === 0);
    // Define a function to load content based on the key
    function loadContent(key, category, count) {
      const data = {
        key: key,
        action: "key_change",
        nonce: keyurl.nonce,
        category: category,
      };
      $.ajax({
        url: keyurl.ajaxurl,
        type: "POST",
        data: data,
        success: function (response) {
          console.log(response);
          // Update the current key after loading content
          currentKey = response.data.key;
          var content = $(".single-design h6 span.review-key");
          var title = $(".single-design h4.entry-content");
          var description = $(".single-design p.description");
          var image = $(".single-design .zoom-box img");
          var segment = $(".single-design p.segment");
          var category = $(".single-design p.review-category");
          console.log(image);

          //html inserting
          content.html(currentKey);
          title.html(response.data.value.title);
          description.html(response.data.value.description);
          image.attr("src", response.data.value.image);
          segment.html(response.data.value.segment);
          category.html(response.data.value.category);
          // Enable or disable Prev and Next buttons based on the currentKey
          $(".prev").prop("disabled", currentKey === 0);
          $(".next").prop("disabled", currentKey > count); // Replace with the total count of $values
        },
        error: function (xhr, status, error) {
          // Handle errors
          console.error(error);
        },
      });
    }
  });
})(jQuery);
