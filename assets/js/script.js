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
   * Login Form on submit
   */
  $(document).on("submit", ".login_form_on_submit", function (e) {
    e.preventDefault();
    var t = $(this);
    var register_data = t.serialize();
    var formData = new FormData(this);
    formData.append("action", "memebership_handler");
    formData.append("register_data", register_data);
    $.ajax({
      type: "POST",
      url: dataAjax.ajaxurl,
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        console.log("Success:", response);
      },
      error: function (error) {
        console.log(error);
      },
    });
  });

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
            render_youtube_video_output.append(response.data.output);
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
});
