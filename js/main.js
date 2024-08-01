const $ = (selector) => document.querySelector(selector);

const navItems = $(".nav__items");
const openNavBtn = $("#open__nav-btn");
const closeNavBtn = $("#close__nav-btn");

const openNav = () => {
  navItems.style.display = "flex";
  openNavBtn.style.display = "none";
  closeNavBtn.style.display = "inline-block";
};

const closeNav = () => {
  navItems.style.display = "none";
  openNavBtn.style.display = "inline-block";
  closeNavBtn.style.display = "none";
};

openNavBtn.addEventListener("click", openNav);
closeNavBtn.addEventListener("click", closeNav);

const sidebar = $("aside");
const showSidebarBtn = $("#show__sidebar-btn");
const hideSidebarBtn = $("#hide__sidebar-btn");

const openSidebar = () => {
  sidebar.style.left = "0";
  showSidebarBtn.style.display = "none";
  hideSidebarBtn.style.display = "inline-block";
};

const closeSidebar = () => {
  sidebar.style.left = "-100%";
  showSidebarBtn.style.display = "inline-block";
  hideSidebarBtn.style.display = "none";
};

showSidebarBtn.addEventListener("click", openSidebar);
hideSidebarBtn.addEventListener("click", closeSidebar);
