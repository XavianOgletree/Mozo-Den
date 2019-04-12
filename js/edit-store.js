function initialize (mozos) {
    mozos.forEach(mozo => {
        let img = document.getElementById(`${mozo}-img`);
        let file = document.getElementById(`${mozo}-file`);
        file.onchange = (event) => {
            if (file.files[0].type === 'image/png') {
                img.src = window.URL.createObjectURL(file.files[0]);
            } else {
                img.src = `../imgs/mozos/${mozo}.png`;
            }
        }
    })
}