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
    var currentKey = $(".single-design").find("button.prev").data("key") - 1; // Initialize the current key starting from 0
    var totalCount = $(".single-design").find("button.next").data("count") - 1; // Initialize totalCount starting from (totalCount - 1)
    console.log("totalcount: " + totalCount);
    var content = $(".single-design h6 span.review-key");
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
          // Update the current key after loading content
          currentKey = response.data.key;
          var content = $(".single-design h6 span.review-key");
          if (currentKey === 0) {
            // Handle special case when currentKey is 0
            // Update the content key to start from 1, but keep currentKey as 0 for array access
            content.html(1);
          } else {
            // For other keys, display them starting from 1
            content.html(currentKey + 1);
          }

          var title = $(".single-design h4.entry-content");
          var description = $(".single-design p.description");
          var image = $(".single-design .zoom-box img");
          var segment = $(".single-design p.segment");
          var category = $(".single-design p.review-category");
          var review = $(".single-design .given-review");
          console.log("after clicking currentKey " + currentKey);

          //html inserting
          title.html(response.data.value.title);
          description.html(response.data.value.description);
          image.attr("src", response.data.value.image);
          segment.html(response.data.value.segment);
          category.html(response.data.value.category);
          review.html(response.data.value.review);
          issueLinkOpen();
          // Enable or disable Prev and Next buttons based on the currentKey
          $(".prev").prop("disabled", currentKey === 0);
          $(".next").prop("disabled", currentKey === count);
        },
        error: function (xhr, status, error) {
          // Handle errors
          console.error(error);
        },
      });
    }

    // Handle the "Next" and "Prev" button clicks
    $(".next").click(function () {
      var nextKey = currentKey + 1;
      var totalCount = parseInt($(this).data("count")) - 1;
      var category = $(this).data("category");
      if (nextKey <= totalCount) {
        // Replace with the total count of $values
        loadContent(nextKey, category, totalCount);
      }
    });

    $(".prev").click(function () {
      var prevKey = currentKey - 1;
      var category = $(this).data("category");
      var totalCount = parseInt($(this).data("count")) - 1;
      if (prevKey >= 0) {
        loadContent(prevKey, category, totalCount);
      }
    });
    content.html(currentKey + 2);
    // Initially disable the "Prev" button if currentKey is 0
    $(".prev").prop("disabled", currentKey === 1);
    $(".next").prop("disabled", currentKey === totalCount);

    //fail button
    issueLinkOpen();
    function issueLinkOpen() {
      // Get references to the buttons and the textarea
      const failButton = document.querySelector(".fail");
      const issueTextarea = document.getElementById("issue");
      if (issueTextarea) {
        issueTextarea.style.display = "none";
        issueTextarea.style.opacity = 0.5;

        failButton.addEventListener("click", function () {
          // Toggle the visibility of the textarea
          if (issueTextarea.style.display === "none") {
            issueTextarea.style.display = "block";
          } else {
            issueTextarea.style.display = "none";
          }
        });
      }
    }

    //ajax button for submit for pass or fail for reviewer
    $(".single-dashboard-submit").click(function (e) {
      e.preventDefault();

      // Get the review ID, status, and category from the user
      var review_id = $(".segment").data("id");
      var status = $('[name="status"]:checked').val();
      var category = $(".review-category").text();
      var issue = $('[name="issue"]').val();

      // If the user has checked the "Fail" radio button, join the issue value with a new line
      if (status === "Fail") {
        issue = "Fail\n" + issue;
      } else {
        issue = "Pass";
      }

      // Send an Ajax request to update the review status
      $.ajax({
        url: reviewstatus.ajaxurl,
        method: "POST",
        data: {
          action: "review_status_update",
          review_id: review_id,
          category: category,
          issue: issue,
          nonce: reviewstatus.nonce,
        },
        success: function (response) {
          if (response.success) {
            // Update the UI to show that the review status has been updated
            // ...
          }
        },
      });
    });

    //total Count
    function totalValueCount(categories) {
      var category_count = $(categories);
      var totalCategory = 0;

      category_count.each(function () {
        totalCategory += parseInt($(this).text(), 10);
      });

      // Send AJAX request
      $.ajax({
        url: totalcategory.ajaxurl,
        method: "POST",
        data: {
          action: "total_review_value",
          total: totalCategory,
          category: categories.slice(1),
          nonce: totalcategory.nonce,
        },
        success: function (response) {
          console.log(response);
        },
        error: function (xhr, status, error) {
          console.log("Error:", error);
        },
      });
    }

    totalValueCount(".categories-count");
    totalValueCount(".pass-count");
    totalValueCount(".pending-count");
    totalValueCount(".fail-count");
  });
})(jQuery);
