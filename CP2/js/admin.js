const mainHead = document.querySelector('.main-head');
const showcaseToggler = document.querySelector('.showcase-toggler');

// Start collapsed by default
mainHead.classList.add('active');

// Click toggler to expand
showcaseToggler.addEventListener('click', () => {
    mainHead.classList.remove('active');
});

// Auto-shrink on mouse leave
mainHead.addEventListener('mouseleave', () => {
    mainHead.classList.add('active');
});

// Auto-expand on mouse enter
mainHead.addEventListener('mouseenter', () => {
    mainHead.classList.remove('active');
});