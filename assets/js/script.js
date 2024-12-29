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
});
