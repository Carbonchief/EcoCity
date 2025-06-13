$(function () {
    $("#footer-placeholder").load("footer.html?v=1");
});

$(function () {
    $("#header-placeholder").load("header.html?v=1");
});

// window.onload = (event) => {
//     var path = window.location.pathname;
//     var page = path.split("/").pop().trim();
//     $('ul#mainNav a[href="' + page + '"]').addClass('active');
// };


function submitForm() {
    // Get form elements
    var name = document.getElementById("name").value;
    var email = document.getElementById("email").value;
    var message = document.getElementById("message").value;

    // Send data via AJAX
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("response").innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "submit-form.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("name=" + name + "&email=" + email + "&message=" + message);
}
