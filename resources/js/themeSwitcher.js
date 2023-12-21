// Whenever the user explicitly chooses to respect the OS preference
// localStorage.removeItem("theme");
const themeSwitcher = (theme) => {
    localStorage.theme = localStorage.theme === "dark" ? "light" : "dark";

    checkTheme();
};

const checkTheme = () => {
    // On page load or when changing themes, best to add inline in `head` to avoid FOUC
    if (
        localStorage.theme === "dark" ||
        (!("theme" in localStorage) &&
            window.matchMedia("(prefers-color-scheme: dark)").matches)
    ) {
        document.documentElement.classList.add("dark");
    } else {
        document.documentElement.classList.remove("dark");
    }
};

export { themeSwitcher };
