'use strict'

function moveCopywrite() {
    const copywrite = document.getElementById('copywrite');
    const firstAside = document.getElementById('first-aside');
    const secondAside = document.getElementById('second-aside');

    if (window.innerWidth < 768) {
        secondAside.appendChild(copywrite);
    } else {
        firstAside.appendChild(copywrite);
    }
}

window.addEventListener('resize', moveCopywrite);
window.addEventListener('load', moveCopywrite);
