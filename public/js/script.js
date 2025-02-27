
function showDropdown() {
    const dropDownMenu = document.querySelector('.dropdown-menu');
    if (dropDownMenu.style.display === "none" || dropDownMenu.style.display === "") {
        dropDownMenu.style.display = "block";
    } else {
        dropDownMenu.style.display = "none";
    }
}

function abort() {
    let alertBox = document.getElementById('alertBox');
    if (alertBox) {
        alertBox.remove();
    }
}

function remove(targetUrl) {
    let alertBox = document.getElementById('alertBox');
    if (alertBox) {
        alertBox.remove();
    }
    // Redirect to the target URL
    window.location.href = targetUrl;
}
