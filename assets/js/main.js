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
    var currentJuryKey = $(".single-design").find("button.prev-jury").data("key") - 1; // Initialize the current key starting from 0
    var totalCount = $(".single-design").find("button.next").data("count") - 1; // Initialize totalCount starting from (totalCount - 1)
    var totalJuryCount = $(".single-design").find("button.next-jury").data("count") - 1; // Initialize totalCount starting from (totalCount - 1)
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
          console.log(response);
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
          var id = $(".single-design p.entry-id");
          var description = $(".single-design p.description");
          var image = $(".single-design .zoom-box img");
          var segment = $(".single-design p.segment");
          var category = $(".single-design p.review-category");
          var review = $(".single-design .given-review");
          console.log("after clicking currentKey " + currentKey);
          //html inserting
          title.html(response.data.value.title);
          id.html(response.data.value.id);
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
    // Handle the "Next" for Jury
    $(".next-jury").click(function () {
      var nextKey = currentJuryKey + 1;
      var totalCount = parseInt($(this).data("count")) - 1;
      var category = $(this).data("category");
      var review = 'pass';//as we Need only pass review
      if (nextKey <= totalCount) {
        // Replace with the total count of $values
        loadContent(nextKey, category, totalCount, review);
      }
    });

    $(".prev").click(function () {
      var prevKey = currentKey - 1;
      var category = $(this).data("category");
      var totalCount = parseInt($(this).data("count")) - 1;
      if (prevKey >= 0) {
        loadJuryContent(prevKey, category, totalCount);
      }
    });

    $(".prev-jury").click(function () {
      var prevKey = currentJuryKey - 1;
      var category = $(this).data("category");
      var totalJuryCount = parseInt($(this).data("count")) - 1;
      var review = 'pass';//as we Need only pass review
      if (prevKey >= 0) {
        loadJuryContent(prevKey, category, totalJuryCount, review);
      }
    });

    content.html(currentKey + 2);
    content.html(currentJuryKey + 2);
    // Initially disable the "Prev" button if currentKey is 0
    $(".prev").prop("disabled", currentKey === 1);
    $(".prev-jury").prop("disabled", currentJuryKey === 1);
    $(".next").prop("disabled", currentKey === totalCount);
    $(".next-jury").prop("disabled", currentJuryKey === totalJuryCount);


    function loadJuryContent(key, category, totalJuryCount, reviewType) {
      const data = {
        key: key,
        action: "key_jury_change",
        nonce: keyjuryurl.nonce,
        category: category,
        reviewType: reviewType, // Add a parameter for review type
      };
    
      $.ajax({
        url: keyjuryurl.ajaxurl,
        type: "POST",
        data: data,
        success: function (response) {
          // Update the current key after loading content
          currentJuryKey = response.data.key;
          var content = $(".single-design h6 span.review-key");
    
          if (currentJuryKey === 0) {
            content.html(1);
          } else {
            // For other keys, display them starting from 1
            content.html(currentJuryKey + 1);
          }
    
          // Update other content as needed
          var title = $(".single-design h4.entry-content");
          var id = $(".single-design p.entry-id");
          var description = $(".single-design p.description");
          var image = $(".single-design .zoom-box img");
          var segment = $(".single-design p.segment");
          var category = $(".single-design p.review-category");
          var review = $(".single-design .given-review");
          var juryMark = $(".single-design span.jury-total-marks");
          var juryName = $(".single-design h6 span.jury-total-marks").attr("data-name");
    
          title.html(response.data.value.title);
          id.html(response.data.value.id);
          description.html(response.data.value.description);
          image.attr("src", response.data.value.image);
          segment.html(response.data.value.segment);
          category.html(response.data.value.category);
          review.html(response.data.value.review);
          if (juryName in response.data.value) {
            juryMark.html(response.data.value[juryName]);
            if (juryMark.text().length > 0) {
              $(".jury-average, .jury-marking, .single-jury-submit").hide();
            } else {
              $(".jury-average, .jury-marking, .single-jury-submit").show();
            }
          }
    
          issueLinkOpen();
    
          // Enable or disable Prev and Next buttons based on the currentKey
          $(".prev").prop("disabled", currentJuryKey === 0);
          $(".next").prop("disabled", currentJuryKey === totalJuryCount);
    
          // Handle pagination for different queries (e.g., 'pass' vs. 'fail')
          $(".prev").data("review-type", reviewType);
          $(".next").data("review-type", reviewType);
        },
        error: function (xhr, status, error) {
          // Handle errors
          console.error(error);
        },
      });
    }
    
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

    //select catergories on single dashboard
    var selectElement = document.getElementById("single_page_category");

    if (selectElement) {
      selectElement.addEventListener("change", function () {
        var selectedOption = selectElement.options[selectElement.selectedIndex];
        var redirectURL = selectedOption.value;

        if (redirectURL !== "0") {
          window.location.href = redirectURL;
        }
      });
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
            alert("Review has been submitted successfully");
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

    function setupMarksCounter(iconClassName, spanClassName) {
      $(document).on("mouseover", iconClassName, function () {
        // Change icons to pink in an ascending way on hover
        $(this)
          .addClass("icon-rectangle-pink")
          .prevAll(iconClassName)
          .addClass("icon-rectangle-pink");
      });

      $(document).on("mouseout", iconClassName, function () {
        // Change icons to pink in an ascending way on hover
        $(this)
          .removeClass("icon-rectangle-pink")
          .prevAll(".icon-rectangle-pink")
          .addClass("icon-rectangle");
      });

      $(document).on("click", iconClassName, function () {
        let pinkIconCount = 0;
        // Count the pink icons only for the respective icons
        pinkIconCount = $(this)
          .siblings(".icon-rectangle-pink")
          .addBack().length;

        // Update the relevant <span> element with the count
        $(spanClassName + ">span" + spanClassName).text(pinkIconCount);
      });
    }
    setupMarksCounter(".relevant-design .icon-rectangle", ".relevant-design");
    setupMarksCounter(".wearability .icon-rectangle", ".wearability");
    setupMarksCounter(".aesthatics .icon-rectangle", ".aesthatics");

    function getTotalMarks() {
      const relevantDesign =
        parseInt($("div.relevant-design span").text()) || 0;
      const wearability = parseInt($("div.wearability span").text()) || 0;
      const aesthatics = parseInt($("div.aesthatics span").text()) || 0;
      if (relevantDesign && wearability && aesthatics) {
        const getTotal = (relevantDesign + wearability + aesthatics) / 3;
        $(".jury-average-marks").html(getTotal.toFixed(2));
      }
    }
    $(document).on("click", $(".aesthatics .icon-rectangle"), function () {
      getTotalMarks();
    });

    //function for jury assign roles

    $("#save-options").click(function (e) {
      e.preventDefault();
      // Collect selected options
      var options = {};
      $('select[name^="jury"]').each(function () {
        var name = $(this).attr("name");
        var value = $(this).val();
        options[name] = value;
      });

      // Send the selected options to the server using AJAX
      $.ajax({
        type: "POST",
        url: juryassign.ajaxurl, // Replace with the actual URL
        data: {
          action: "save_jury_options",
          options: options,
          nonce: juryassign.nonce,
        },
        success: function (response) {
          console.log(response);
          console.log("Options saved successfully");
          // You can display a success message or update the page as needed
        },
        error: function (error) {
          console.error("Error saving options: " + error);
        },
      });
    });

    //jury marks on single page
    function juryMarks(){

      var juryMark = $(".single-design span.jury-total-marks");
        if (juryMark.text().length > 0) {
          $(".jury-average, .jury-marking, .single-jury-submit").hide();
        } else {
          $(".jury-average, .jury-marking, .single-jury-submit").show();
        }
    }
    juryMarks();

    //Jury Submitted Marks
    $(".single-jury-submit").click(function (e) {
      e.preventDefault();

      // Get data from the HTML elements
      var juryUserId = $(".segment").data("juryuserid");
      var dataId = $(".segment").data("id");
      var averageMarks = $(".jury-average-marks").text();

      // Prepare the data to send via AJAX
      var dataToSend = {
        action: "submit_jury_marks",
        juryUserId: juryUserId,
        dataId: dataId,
        averageMarks: averageMarks,
        nonce: jurymarks.nonce,
      };

      // Send the data to the server using AJAX
      $.ajax({
        type: "POST",
        url: jurymarks.ajaxurl, // Replace with the actual URL
        data: dataToSend,
        success: function (response) {
          console.log(response);
          alert("Marks has been counted successfully");
        },
        error: function (error) {
          console.error("Error submitting data: " + error);
        },
      });
    });

    //dataTable

    var table = $("#admin-table");
    table.DataTable({
      dom: "Bfrtip",
      fixedHeader: {
        header: true,
      },
      pagingType: "numbers",
      buttons: ["copy", "csv", "excel", "pdf"],
    });

    //custom logout

    $(".dropdown-item").on("click", function (e) {
      e.preventDefault();

      $.ajax({
        type: "POST",
        url: logout.ajaxurl, // This variable should be defined in your template or plugin
        data: {
          action: "custom_logout",
          nonce: logout.nonce,
        },
        success: function (response) {
          console.log(response);
          window.location.href = "";
        },
      });
    });
  });
})(jQuery);
