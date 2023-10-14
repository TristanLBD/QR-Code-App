function changeTheme() {
    const element = document.getElementById("salam");
    if (element) {
        if (element.classList.contains("dark")) {
            element.classList.replace("dark", "light");
            document.body.classList.replace("dark", "light");
            localStorage.setItem("theme", "light");
            document.getElementById("colorChanger").querySelector("i").classList.replace("fa-sun", "fa-moon");
        } else {
            element.classList.replace("light", "dark");
            document.body.classList.replace("light", "dark");
            localStorage.setItem("theme", "dark");
            document.getElementById("colorChanger").querySelector("i").classList.replace("fa-moon", "fa-sun");
        }
    }
}

const storageTheme = localStorage.getItem("theme");
if (storageTheme) {
    document.getElementById("salam").classList.add(storageTheme);
    document.body.classList.add(storageTheme);
}
