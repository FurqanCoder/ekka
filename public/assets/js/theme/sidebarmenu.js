document.addEventListener("DOMContentLoaded", () => {
  const layout = document.documentElement.getAttribute("data-layout") || "vertical";

  if (layout === "vertical") {
    initVerticalSidebar();
  } else if (layout === "horizontal") {
    initHorizontalSidebar();
  }

  fixDashboardLink();
});

/* ---------------------------
   Vertical Sidebar Functions
---------------------------- */
function initVerticalSidebar() {
  const sidebar = document.querySelector(".side-mini-panel");
  if (!sidebar) return;

  const sideNavLinks = sidebar.querySelectorAll("#sidebarnav a");

  // Highlight active link
  const activeLink = [...sideNavLinks].find(a => a.href === window.location.href);
  if (activeLink) {
    activeLink.classList.add("active");
    expandParentMenus(activeLink);
    showParentMenu(activeLink);
  }

  // Handle nav clicks
  sideNavLinks.forEach(link => {
    link.addEventListener("click", e => {
      const parentUl = link.closest("ul");
      const submenu = link.nextElementSibling;

      // Remove active from siblings
      parentUl.querySelectorAll("a.active").forEach(l => l.classList.remove("active"));

      // Toggle active
      link.classList.toggle("active");

      // Toggle submenu
      if (submenu && submenu.tagName === "UL") {
        submenu.classList.toggle("in");
      }
    });
  });

  // Mini-nav icons click
  document.querySelectorAll(".mini-nav .mini-nav-item").forEach(item => {
    item.addEventListener("click", () => {
      const menuId = "menu-right-" + item.id;

      // Deselect all
      document.querySelectorAll(".mini-nav .mini-nav-item").forEach(i => i.classList.remove("selected"));
      document.querySelectorAll(".sidebarmenu nav").forEach(nav => nav.classList.remove("d-block"));

      // Activate selected
      item.classList.add("selected");
      document.getElementById(menuId)?.classList.add("d-block");
      document.body.setAttribute("data-sidebartype", "full");
    });
  });
}

/* ---------------------------
   Horizontal Sidebar Functions
---------------------------- */
function initHorizontalSidebar() {
  const anchors = document.querySelectorAll("#sidebarnavh ul#sidebarnav a");
  const activeLink = [...anchors].find(a => a.href === window.location.href);

  if (activeLink) {
    activeLink.classList.add("active");
    activeLink.closest("li")?.classList.add("selected");
    activeLink.closest("ul")?.parentElement?.classList.add("selected");
  }
}

/* ---------------------------
   Expand parent menus of active link
---------------------------- */
function expandParentMenus(link) {
  let parentUl = link.closest("ul");
  while (parentUl && parentUl.id !== "sidebarnav") {
    parentUl.classList.add("in");
    parentUl = parentUl.parentElement.closest("ul");
  }
}

/* ---------------------------
   Show parent menu (for mini-nav)
---------------------------- */
function showParentMenu(link) {
  const closestNav = link.closest("nav.sidebar-nav");
  if (!closestNav) return;

  const menuId = closestNav.id;
  document.getElementById(menuId)?.classList.add("d-block");

  // Match mini-nav item
  const num = menuId.split("-").pop();
  document.getElementById("mini-" + num)?.classList.add("selected");
}

/* ---------------------------
   Fix Dashboard Link (Dual file support)
---------------------------- */
function fixDashboardLink() {
  const link = document.getElementById("get-url");
  if (!link) return;

  const currentURL = (window.location !== window.parent.location) 
    ? document.referrer 
    : document.location.href;

  if (currentURL.includes("/main/index.html")) {
    link.setAttribute("href", "../main/index.html");
  } else if (currentURL.includes("/index.html")) {
    link.setAttribute("href", "./index.html");
  } else {
    link.setAttribute("href", "./");
  }
}
