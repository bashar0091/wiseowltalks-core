jQuery(document).ready(function ($) {
  const initialVideoUrl = $(".video-con.active-con").data("video");
  if (initialVideoUrl) {
    $("#display-frame").attr("src", initialVideoUrl);
  }
  $(".video-con").on("click", function () {
    const videoUrl = $(this).data("video");
    $("#display-frame").attr("src", videoUrl);
    $(".video-con").removeClass("active-con");
    $(this).addClass("active-con");
  });

  /**
   * Generic Form Submission Handler
   */
  function handleFormSubmit(formClass, actionType) {
    $(document).on("submit", formClass, function (e) {
      e.preventDefault();
      var t = $(this);
      var register_data = t.serialize();
      var formData = new FormData(this);
      formData.append("action", actionType);
      formData.append("register_data", register_data);

      t.find(".form_processing").addClass("is_process");
      t.find(".loader_img").show();
      t.find(".error_text").empty();

      $.ajax({
        type: "POST",
        url: dataAjax.ajaxurl,
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          if (response.success) {
            if (actionType === "membership_handler") {
              t.find(".form_processing").html(
                '<p style="text-align: center; color: #000;"> <b>A verify email is sent to your provided email, <br />Please Verify...</b></p>'
              );
            } else if (actionType === "membership_password_handler") {
              t.find(".error_text").html(
                `<p style="color:green;margin-bottom:10px;">${response.data.message}</p>`
              );
              if (response.data.redirect_url) {
                window.location.href = response.data.redirect_url;
              }
            } else if (actionType === "login_submission_handler") {
              t.find(".error_text").html(
                `<p style="color:green;margin-bottom:10px;">${response.data.message}</p>`
              );
              if (response.data.redirect_url) {
                window.location.href = response.data.redirect_url;
              }
            }
          } else {
            t.find(".error_text").html(
              `<p style="color:red;margin-bottom:10px;">${response.data.message}</p>`
            );
          }

          t.find(".form_processing").removeClass("is_process");
          t.find(".loader_img").hide();
        },
        error: function (error) {
          console.log(error);
        },
      });
    });
  }

  // Use the generic function for both forms
  handleFormSubmit(".login_form_on_submit", "membership_handler");
  handleFormSubmit(".password_form_on_submit", "membership_password_handler");
  handleFormSubmit(".login_submission_on_submit", "login_submission_handler");

  /**
   * search_filter_on_input
   */
  function debounce(func, delay) {
    let timer;
    return function (...args) {
      const context = this;
      clearTimeout(timer);
      timer = setTimeout(() => func.apply(context, args), delay);
    };
  }

  $(document).on(
    "input",
    ".search_filter_on_input,.tag_filter_on_input",
    debounce(function (e) {
      e.preventDefault();
      var t = $(this);
      var field = t.data("field");
      var get_val = t.val();
      var render_youtube_video_output = $(".render_youtube_video_output");
      var video_itemse = $(".video_itemse");
      var ajax_loader_opacity = $(".ajax_loader_opacity");
      var ajax_loader_image = $(".ajax_loader_image");

      $(".tag_list_pc label").removeClass("active");
      t.closest("label").addClass("active");

      ajax_loader_opacity.addClass("show");
      ajax_loader_image.show();

      // Adjusting data structure
      var ajaxData = {
        action: "search_filter_handler",
      };

      if (field === "search") {
        ajaxData.get_val = get_val;
      } else if (field === "tag") {
        ajaxData.tag = get_val;
      }

      $.ajax({
        type: "POST",
        url: dataAjax.ajaxurl,
        data: ajaxData,
        success: function (response) {
          if (response.success) {
            video_itemse.remove();
            render_youtube_video_output.html(response.data.output);
            ajax_loader_opacity.removeClass("show");
            ajax_loader_image.hide();
          }
        },
        error: function (error) {
          console.error("Error:", error);
        },
      });
    }, 300)
  );

  /**
   *
   * Member Form Tab
   *
   */
  $(document).on("click", "#member_otp_tab", function () {
    $(".tabs .tab").removeClass("active");
    $(this).closest(".tab").addClass("active");
    $(".member_form").removeClass("active");
    $(".member_otp_form").addClass("active");
  });
  $(document).on("click", "#member_login_tab", function () {
    $(".tabs .tab").removeClass("active");
    $(this).closest(".tab").addClass("active");
    $(".member_form").removeClass("active");
    $(".member_login_form").addClass("active");
  });

  /**
   *
   * currency_switch_click
   *
   */
  $(document).on("click", ".currency_switch_click", function () {
    var t = $(this);
    var flag = t.data("flag");
    var countrycode = t.data("countrycode");
    var slug = t.data("slug");
    var symbol = t.data("symbol");
    $.ajax({
      type: "POST",
      url: dataAjax.ajaxurl,
      data: {
        action: "currency_switch_handler",
        flag: flag,
        countrycode: countrycode,
        slug: slug,
        symbol: symbol,
      },
      success: function (response) {
        if (response.success) {
          location.reload();
        }
      },
      error: function (error) {
        console.error("Error:", error);
      },
    });
  });
});
