// script.js — premium interactivity

// Dropdown
function toggleDropdown() {
  const dropdown = document.getElementById("dropdown-content");
  const btn = document.querySelector(".dropbtn");
  const isOpen = dropdown.style.display === "block";
  dropdown.style.display = isOpen ? "none" : "block";
  btn.setAttribute("aria-expanded", String(!isOpen));
}

// Click outside to close dropdown
window.addEventListener("click", (e) => {
  const btn = document.querySelector(".dropbtn");
  const dropdown = document.getElementById("dropdown-content");
  if (!dropdown) return;
  if (btn && (btn === e.target || btn.contains(e.target))) return;
  if (dropdown.style.display === "block") {
    dropdown.style.display = "none";
    btn && btn.setAttribute("aria-expanded", "false");
  }
});

function setToggle(btn) {
  document
    .querySelectorAll(".toggle-btns button")
    .forEach((b) => b.classList.remove("active"));
  btn.classList.add("active");
}

// Booking Function
function bookNow() {
  const movie = document.getElementById("movie").value;
  const date = document.getElementById("date").value;
  const cinema = document.getElementById("cinema").value;
  const time = document.getElementById("time").value;

  if (
    movie.includes("Select") ||
    date.includes("Select") ||
    cinema.includes("Select") ||
    time.includes("Select")
  ) {
    alert("Please select all fields before booking!");
  } else {
    alert(
      `Booking Confirmed!\nMovie: ${movie}\nDate: ${date}\nCinema: ${cinema}\nTime: ${time}`
    );
  }
}

document.addEventListener("DOMContentLoaded", () => {
  // Swiper
  const swiper = new Swiper(".mySwiper", {
    loop: true,
    autoplay: { delay: 3000, disableOnInteraction: false },
    pagination: { el: ".swiper-pagination", clickable: true },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    effect: "fade",
    speed: 700,
  });

  // Pause on press/hold for both desktop and touch
  const posterImgs = document.querySelectorAll(".movie-poster img");
  const hero = document.querySelector(".mySwiper");
  const pressStart = () => swiper.autoplay.stop();
  const pressEnd = () => swiper.autoplay.start();

  posterImgs.forEach((img) => {
    img.addEventListener("mousedown", pressStart);
    img.addEventListener("touchstart", pressStart, { passive: true });
    img.addEventListener("mouseup", pressEnd);
    img.addEventListener("touchend", pressEnd);
    img.addEventListener("mouseleave", pressEnd);
  });
  // Also pause when user hovers over the hero area (desktop nicety)
  hero?.addEventListener("mouseenter", () => swiper.autoplay.stop());
  hero?.addEventListener("mouseleave", () => swiper.autoplay.start());

  // Sticky header shadow
  const nav = document.querySelector(".navbar");
  const onScroll = () => {
    if (window.scrollY > 10) {
      nav.style.boxShadow = "0 6px 24px rgba(0,0,0,.25)";
    } else {
      nav.style.boxShadow = "none";
    }
  };
  window.addEventListener("scroll", onScroll);
  onScroll();

  // Login modal
  const modal = document.getElementById("loginModal");
  const open = document.getElementById("loginOpen");
  const close = document.getElementById("loginClose");
  open?.addEventListener("click", () => {
    modal.style.display = "grid";
    modal.setAttribute("aria-hidden", "false");
  });
  close?.addEventListener("click", () => {
    modal.style.display = "none";
    modal.setAttribute("aria-hidden", "true");
  });
  modal?.addEventListener("click", (e) => {
    if (e.target === modal) {
      close?.click();
    }
  });
});


