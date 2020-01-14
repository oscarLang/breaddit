/**
 * To show off JS works and can be integrated.
 */
(function() {
    "use strict";

    console.info("main.js ready and loaded.");
    function showReplyComment() {
        var x = document.getElementById("reply");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
}
})();
