/* Set the width of the side navigation to 0 and the left margin of the page content to 0 */


function nav() {
    
    var nav = document.getElementById("mySidenav");
    if (nav.style.width == '300px') {
    nav.style.width = '0';
    nav.style.opacity = 0;
    } else {
    nav.style.width = "300px";
    nav.style.opacity = 1;
    }
}