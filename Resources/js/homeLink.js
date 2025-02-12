export function generateHomeLink() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.size <= 0) {
        return;
    }

    const imgDiv = document.querySelector('.logo-wrap');
    const imgDivInner = imgDiv.innerHTML;
    const imgA = document.createElement('a');
    imgA.href = '/';
    imgA.classList.add('logo-wrap');
    imgA.innerHTML = imgDivInner;
    imgDiv.parentNode.replaceChild(imgA, imgDiv);
}
