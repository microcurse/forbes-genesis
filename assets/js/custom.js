// // Add text to Zipper Bag option
// // "Minimum order quantity of 10 for Zipper Style Bags"
// const variations =  document.querySelector('.variations');
// const makeSpan = document.createElement('span');
// const zipperOpt = document.getElementById('pa_zipper-style');
// makeSpan.style.color = "red";
// makeSpan.style.fontStyle = "italic";
// makeSpan.style.fontSize = "12px";

// function zipperTip () {
// 	if(zipperOpt) {
// 		variations.appendChild(makeSpan);
// 		makeSpan.textContent = ("Minimum order quantity of 10 for Zipper Style Bags");
// 	}
// }
// zipperTip();

/** Accordion functions for Mixology Benefits section */
function accordion() {
    const accPanels = document.querySelectorAll('.acc-panel');

    function openPanel(e) {
    const accBody = e.currentTarget.querySelector('.acc-body');
        accBody.classList.toggle('show');
    }

    function attachListener(panels) {
        panels.addEventListener('click', openPanel);
    }

    accPanels.forEach(attachListener);
}

accordion();