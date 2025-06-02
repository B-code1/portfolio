const sideMenu = document.querySelector('#side-menu');

function openMenu() {
  sideMenu.style.transform = 'translateX(-16rem)';
}

function closeMenu() {
  sideMenu.style.transform = 'translateX(16rem)';
}
window.addEventListener('scroll', () => {
  if (window.scrollY > 0) {
    sideMenu.style.transform = 'translateX(16rem)';
  }
  if (window.scrollY === 0) {
    sideMenu.style.transform = 'translateX(16rem)';
  }
  

