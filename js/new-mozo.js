console.log("DONE");
let mozo_premium = document.getElementById("mozo-premium");
let premium_information = document.getElementById("premium-info");
mozo_premium.onchange = () => {
    premium_information.disabled = !premium_information.disabled;
};