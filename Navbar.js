// Navbar Starting
document.addEventListener('DOMContentLoaded', () => {
    const profileContainer = document.querySelector('.profile-container');
    const profileToggle = document.querySelector('.profile-toggle');
    
    profileToggle.addEventListener('click', () => {
        profileContainer.classList.toggle('active');
    });
    
    document.addEventListener('click', (event) => {
        if (!profileContainer.contains(event.target)) {
            profileContainer.classList.remove('active');
        }
    });
});
  document.querySelector('.menu-toggle').addEventListener('click', function() {
            document.querySelector('.nav-links').classList.toggle('active');
        });
// Navbar Ending








document.addEventListener('mousemove', function(e) {
    const cursor = document.querySelector('.cursor');
    cursor.style.left = e.pageX + 'px';
    cursor.style.top = e.pageY + 'px';
});

function createTrail(e) {
    const trail = document.createElement('div');
    trail.classList.add('trail');
    document.body.appendChild(trail);
    trail.style.left = e.pageX + 'px';
    trail.style.top = e.pageY + 'px';

    requestAnimationFrame(() => {
        trail.style.opacity = '1';
        requestAnimationFrame(() => {
            setTimeout(() => {
                trail.style.opacity = '0';
                trail.style.transform = 'scale(0)'; 
                requestAnimationFrame(() => {
                    setTimeout(() => {
                        document.body.removeChild(trail);
                    }, 500); 
                });
            }, 100); 
        });
    });
}

document.addEventListener('mousemove', function(e) {
    createTrail(e);
});

document.querySelectorAll('a, button').forEach(el => {
    el.addEventListener('mouseover', function() {
        document.querySelector('.cursor').classList.add('hovered');
    });

    el.addEventListener('mouseout', function() {
        document.querySelector('.cursor').classList.remove('hovered');
    });
});




