/*!
 * Cloud Skin Beauty — theme toggle
 * Drop this near the end of <body>, after tokens.css/theme.css are linked.
 * Add any element with [data-theme-toggle] to flip themes, e.g.:
 *   <button data-theme-toggle aria-label="Toggle dark mode">🌙</button>
 */
(function () {
  var STORAGE_KEY = "csb-theme";
  var root = document.documentElement;

  function applyTheme(theme) {
    if (theme === "dark") {
      root.setAttribute("data-theme", "dark");
    } else {
      root.removeAttribute("data-theme");
    }
  }

  function getStoredTheme() {
    try {
      return window.localStorage.getItem(STORAGE_KEY);
    } catch (e) {
      return null;
    }
  }

  function storeTheme(theme) {
    try {
      window.localStorage.setItem(STORAGE_KEY, theme);
    } catch (e) {
      /* private mode / storage disabled — ignore */
    }
  }

  // 1. Apply saved preference, or fall back to OS preference, on load.
  var saved = getStoredTheme();
  if (saved) {
    applyTheme(saved);
  } else if (window.matchMedia && window.matchMedia("(prefers-color-scheme: dark)").matches) {
    applyTheme("dark");
  }

  // 2. Wire up any toggle buttons on the page.
  document.addEventListener("DOMContentLoaded", function () {
    var toggles = document.querySelectorAll("[data-theme-toggle]");
    toggles.forEach(function (btn) {
      btn.addEventListener("click", function () {
        var isDark = root.getAttribute("data-theme") === "dark";
        var next = isDark ? "light" : "dark";
        applyTheme(next);
        storeTheme(next);
      });
    });
  });
})();