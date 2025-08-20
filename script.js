// script.js
function toggleDropdown() {
  const dropdown = document.getElementById("dropdown-content");
  dropdown.style.display = (dropdown.style.display === "block") ? "none" : "block";
}

// Hide dropdown if clicked outside
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    const dropdown = document.getElementById("dropdown-content");
    if (dropdown && dropdown.style.display === "block") {
      dropdown.style.display = "none";
    }
  }
}
