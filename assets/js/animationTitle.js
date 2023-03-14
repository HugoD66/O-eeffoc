if (location.href.endsWith('/')) {

    const rotateDegrees = 360;
    const rotateInterval = 5000;
    const rotateDuration = 2000;

    function rotateFirstLetter() {
        const title = document.querySelector('.titrePrincipal');
        const firstLetter = title.innerText.charAt(0);
        const rotatedLetter = `<span class="rotated-letter">${firstLetter}</span>`;
        const newTitle = title.innerHTML.replace(firstLetter, rotatedLetter);
        title.innerHTML = newTitle;
        const rotatedLetterElement = document.querySelector('.rotated-letter');
        rotatedLetterElement.classList.add('rotate');
        setTimeout(() => {
            rotatedLetterElement.classList.remove('rotate');
        }, rotateDuration);
    }

    setInterval(rotateFirstLetter, rotateInterval);
}

