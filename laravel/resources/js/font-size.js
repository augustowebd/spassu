document.addEventListener("DOMContentLoaded", () => {
    const body = document.body;
    const classes = [
        "font-small",
        "font-medium",
        "font-large",
        "font-xlarge"
    ];

    let current = 1;

    document.getElementById("decrease-font").addEventListener("click", () => {
        if (current > 0) {
            body.classList.remove(classes[current]);
            current--;
            body.classList.add(classes[current]);
        }
    });

    document.getElementById("increase-font").addEventListener("click", () => {
        if (current < classes.length - 1) {
            body.classList.remove(classes[current]);
            current++;
            body.classList.add(classes[current]);
        }
    });
});
