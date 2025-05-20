document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('squares-container');
    const colors = ['rgba(0, 100, 255, 0.3)', 'rgba(255, 255, 255, 1)', 'rgba(0, 100, 255, 0.2)'];
    
    for (let i = 0; i < 20; i++) {
        const square = document.createElement('div');
        square.classList.add('square');
        
        // Random size between 20px and 100px
        const size = Math.random() * 80 + 20;
        square.style.width = `${size}px`;
        square.style.height = `${size}px`;
        
        // Random position
        square.style.left = `${Math.random() * 100}%`;
        square.style.top = `${Math.random() * 100 + 100}%`;
        
        // Random animation duration between 10s and 25s
        const duration = Math.random() * 15 + 10;
        square.style.animationDuration = `${duration}s`;
        
        // Random delay
        square.style.animationDelay = `${Math.random() * 5}s`;
        
        // Random color
        square.style.borderColor = colors[Math.floor(Math.random() * colors.length)];

        
        container.appendChild(square);
    }
});