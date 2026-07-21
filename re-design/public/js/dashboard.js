console.log("Dashboard JS loaded");

// Dashboard functionality
// Since a_dashboard.php only used Bootstrap with no custom JS,
// this file provides a foundation for future enhancements

// Mobile navigation handling
const mobileNavButtons = document.querySelectorAll('nav button');
mobileNavButtons.forEach(button => {
    button.addEventListener('click', function() {
        // Remove active state from all buttons
        mobileNavButtons.forEach(btn => {
            btn.classList.remove('bg-secondary-container', 'text-on-secondary-container');
            btn.classList.add('text-on-surface-variant');
        });
        
        // Add active state to clicked button
        this.classList.add('bg-secondary-container', 'text-on-secondary-container');
        this.classList.remove('text-on-surface-variant');
    });
});

// Table row hover effect enhancement
const tableRows = document.querySelectorAll('tbody tr');
tableRows.forEach(row => {
    row.addEventListener('click', function() {
        // Future: Add transaction detail view functionality
        console.log('Transaction clicked:', this.querySelector('td').textContent);
    });
});

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});
