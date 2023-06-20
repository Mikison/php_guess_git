

function showConfirmationDialog() {
    var overlay = document.getElementById("overlay");
    var confirmationDialog = document.getElementById("confirmation-dialog");

    overlay.style.display = "block";
    confirmationDialog.style.display = "block";
}

function hideConfirmationDialog() {
    var overlay = document.getElementById("overlay");
    var confirmationDialog = document.getElementById("confirmation-dialog");

    overlay.style.display = "none";
    confirmationDialog.style.display = "none";
}

function deleteAccount() {
    window.location.href = "delete_account.php";
}

function logout() {
    return window.location.href = "logout.php";
}
function edit() {
    return window.location.href = "../edit_account.php";
}
