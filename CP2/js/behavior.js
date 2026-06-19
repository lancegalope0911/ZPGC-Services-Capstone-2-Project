/*
 * FILE: behavior.js
 * PURPOSE: Collapsible sidebar on dashboard pages (user, admin, techn).
 * LOGIC:   JS toggles the "active" class; CSS animates width 250px ↔ 60px.
 */

// SYNTAX: const — variable that cannot be reassigned after declaration.
// SYNTAX: document.querySelector('.class') returns the first matching DOM element.
const mainHead        = document.querySelector('.main-head');        // LOGIC: Sidebar container.
const showcaseToggler = document.querySelector('.showcase-toggler'); // LOGIC: Hamburger button.

// LOGIC: Start collapsed on page load (60px wide, icons only).
mainHead.classList.add('active');

// SYNTAX: addEventListener('event', callback) — runs callback when event fires on element.
// LOGIC:  Clicking the hamburger expands the sidebar.
showcaseToggler.addEventListener('click', () => {
    mainHead.classList.remove('active');  // LOGIC: Remove "active" → width becomes 250px.
});

// LOGIC: Mouse leaving the sidebar collapses it again.
mainHead.addEventListener('mouseleave', () => {
    mainHead.classList.add('active');
});

// LOGIC: Hovering over the sidebar expands it.
mainHead.addEventListener('mouseenter', () => {
    mainHead.classList.remove('active');
});
