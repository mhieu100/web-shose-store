// Enhanced Product Tabs JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Get all tab buttons and tab panes
    const tabButtons = document.querySelectorAll('.product-tab-nav .nav-link');
    const tabPanes = document.querySelectorAll('.product-tab-content .tab-pane');

    // Add click event listeners to tab buttons
    tabButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            tabButtons.forEach(btn => {
                btn.classList.remove('active');
                btn.setAttribute('aria-selected', 'false');
            });

            // Add active class to clicked button
            this.classList.add('active');
            this.setAttribute('aria-selected', 'true');

            // Hide all tab panes with animation
            tabPanes.forEach(pane => {
                pane.classList.remove('show', 'active');
                pane.style.opacity = '0';
                pane.style.transform = 'translateY(20px)';
            });

            // Show target tab pane with animation
            const targetId = this.getAttribute('data-bs-target');
            const targetPane = document.querySelector(targetId);

            if (targetPane) {
                setTimeout(() => {
                    targetPane.classList.add('show', 'active');
                    targetPane.style.opacity = '1';
                    targetPane.style.transform = 'translateY(0)';
                }, 100);
            }
        });
    });

    // Add hover effects
    tabButtons.forEach(function(button) {
        button.addEventListener('mouseenter', function() {
            if (!this.classList.contains('active')) {
                this.style.transform = 'translateY(-2px) scale(1.02)';
            }
        });

        button.addEventListener('mouseleave', function() {
            if (!this.classList.contains('active')) {
                this.style.transform = 'translateY(0) scale(1)';
            }
        });
    });

    // Smooth scroll to tabs when clicked
    const productTabMenu = document.querySelector('.product-tab-menu');
    if (productTabMenu) {
        tabButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                productTabMenu.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest'
                });
            });
        });
    }

    // Add loading animation for tab content
    function showTabLoading(tabPane) {
        tabPane.innerHTML = '<div class="tab-loading">Đang tải sản phẩm...</div>';
    }

    // Animate tab badges on hover
    const badges = document.querySelectorAll('.product-tab-nav .badge');
    badges.forEach(function(badge) {
        const button = badge.closest('.nav-link');

        button.addEventListener('mouseenter', function() {
            badge.style.transform = 'scale(1.1)';
            badge.style.transition = 'transform 0.2s ease';
        });

        button.addEventListener('mouseleave', function() {
            badge.style.transform = 'scale(1)';
        });
    });

    // Auto-adjust tab menu on resize
    function adjustTabMenu() {
        const tabMenu = document.querySelector('.product-tab-nav');
        const windowWidth = window.innerWidth;

        // Check if tabMenu exists before accessing its style
        if (!tabMenu) return;

        if (windowWidth <= 768) {
            tabMenu.style.flexDirection = 'column';
            tabButtons.forEach(btn => {
                if (btn && btn.style) {
                    btn.style.width = '100%';
                    btn.style.maxWidth = '280px';
                }
            });
        } else {
            tabMenu.style.flexDirection = 'row';
            tabButtons.forEach(btn => {
                if (btn && btn.style) {
                    btn.style.width = 'auto';
                    btn.style.maxWidth = 'none';
                }
            });
        }
    }

    // Initial adjustment and on window resize
    adjustTabMenu();
    window.addEventListener('resize', adjustTabMenu);

    // Add ripple effect on tab click
    tabButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;

            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');

            this.appendChild(ripple);

            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
});

// CSS for ripple effect
const rippleStyle = document.createElement('style');
rippleStyle.textContent = `
.nav-link {
    position: relative;
    overflow: hidden;
}

.ripple {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transform: scale(0);
    animation: ripple-animation 0.6s linear;
    pointer-events: none;
}

@keyframes ripple-animation {
    to {
        transform: scale(4);
        opacity: 0;
    }
}
`;
document.head.appendChild(rippleStyle);
