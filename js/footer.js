// Please see documentation at https://docs.microsoft.com/aspnet/core/client-side/bundling-and-minification
// for details on configuring this project to bundle and minify static web assets.

// Write your JavaScript code.

$('a.SAclass').click(function (e) {
    // Special stuff to do when this link is clicked...
    $("#liRivonia").toggleClass("d-none");
    $("#liMidrand").toggleClass("d-none");
    $("#liLonehill").toggleClass("d-none");
    $("#liBryanston").toggleClass("d-none");

    $("#liRivonia1").addClass("d-none");
    $("#liMidrand1").addClass("d-none");
    $("#liLonehill1").addClass("d-none");
    $("#liBryanston1").addClass("d-none");
    $("html, body").animate({ scrollTop: $(document).height() }, 1000);
    // Cancel the default action
    e.preventDefault();
});

$('a.someclass').click(function (e) {
    // Special stuff to do when this link is clicked...
    $("#liRivonia1").toggleClass("d-none");
    $("html, body").animate({ scrollTop: $(document).height() }, 1000);
    // Cancel the default action
    e.preventDefault();
});


$('a.someclass2').click(function (e) {
    // Special stuff to do when this link is clicked...
    $("#liMidrand1").toggleClass("d-none");
    $("html, body").animate({ scrollTop: $(document).height() }, 1000);
    // Cancel the default action
    e.preventDefault();
});

$('a.someclass4').click(function (e) {
    // Special stuff to do when this link is clicked...
    $("#liLonehill1").toggleClass("d-none");
    $("html, body").animate({ scrollTop: $(document).height() }, 1000);
    // Cancel the default action
    e.preventDefault();
});


$('a.someclass5').click(function (e) {
    // Special stuff to do when this link is clicked...
    $("#liBryanston1").toggleClass("d-none");
    $("html, body").animate({ scrollTop: $(document).height() }, 1000);
    // Cancel the default action
    e.preventDefault();
});

$('a.Botclass').click(function (e) {
    // Special stuff to do when this link is clicked...
    $("#liGaborone").toggleClass("d-none");
    $("#liGaborone1").addClass("d-none");
    $("#liGaborone2").addClass("d-none");
    $("html, body").animate({ scrollTop: $(document).height() }, 1000);
    // Cancel the default action
    e.preventDefault();
});

$('a.someclass3').click(function (e) {
    // Special stuff to do when this link is clicked...
    $("#liGaborone1").toggleClass("d-none");
    $("#liGaborone2").toggleClass("d-none");
    $("html, body").animate({ scrollTop: $(document).height() }, 1000);
    // Cancel the default action
    e.preventDefault();
});
