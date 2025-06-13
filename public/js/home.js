function toggleForm(display) {
    if(display == "close") {
        document.getElementById('formBoard').style.display = "none";
        return;
    }
    document.getElementById('formBoard').style.display = "block";
}
