products.addEventListener("click", e =>
{
    updateProductHelper(e);
});

function updateProductHelper(e) {
    var reviewForm = document.getElementById("reviewForm");
    var fullName = document.getElementById("fullName");
    var message = document.getElementById("message");
    var ProductID = document.getElementById("ProductID");
    var reviewNode = e.target.parentNode;

    if (e.target.classList.contains("edit")) {
        fullName.value = reviewNode.querySelector(".fullName").innerText;
        message.value = reviewNode.querySelector(".message").innerText;
        reviewID.value = reviewNode.querySelector(".reviewID").value;

        Materialize.updateTextFields();
        reviewForm.action = "business/handleReview.php?action=edit";
    }
}

// Utility method to clear the form
function clearForm() {
    fullName.value = "";
    message.value = "";
    hiddenId.value = "";
}










