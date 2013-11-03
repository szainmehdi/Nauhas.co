$(function() {
    $("body").on("click", ".play", function(e) {
        e.preventDefault();
        $(this).addClass("pause").removeClass("play").parent().parent().find("audio")[0].play();
    });
    $("body").on("click", ".pause", function(e) {
        e.preventDefault();
        $(this).addClass("play").removeClass("pause").parent().parent().find("audio")[0].pause();
    });
    $("body").on("click", ".ff", function(e) {
        e.preventDefault();
        var audio = $(this).parent().parent().find("audio")[0];
        audio.currentTime = audio.currentTime+15;
    });
    $("body").on("click", ".rr", function(e) {
        e.preventDefault();
        var audio = $(this).parent().parent().find("audio")[0];
        audio.currentTime = audio.currentTime-15;
    });
});