let toastBox = document.getElementById("toastBox");

function showToast(type, toastMessage) {
    let toast = document.createElement("div");
    var symbol = '<i class="fa-solid fa-circle-check"></i>';
    if (type.toLowerCase() === "error") {
        toast.classList.add("error");
        symbol = '<i class="fa-solid fa-circle-xmark"></i>';
    } else if (type.toLowerCase() === "invalid" || type.toLowerCase() === "warning") {
        toast.classList.add("invalid");
        symbol = '<i class="fa-solid fa-circle-exclamation"></i>';
    }

    toast.classList.add("toasty");
    toast.innerHTML = symbol + toastMessage;

    toastBox.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 6000);
}
