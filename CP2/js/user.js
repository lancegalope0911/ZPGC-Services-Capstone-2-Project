const mainHead = document.querySelector('.main-head');
const showcaseToggler = document.querySelector('.showcase-toggler');
const sidebarToggler = document.querySelector('.sidebar-toggler');

// Expand → Collapse (from showcase toggler)
showcaseToggler.addEventListener('click', () => {
    mainHead.classList.add('active');
});

// Collapse → Expand (from sidebar toggler inside logo)
sidebarToggler.addEventListener('click', () => {
    mainHead.classList.remove('active');
});