function removeclassesModal() {
    setTimeout(() => {
        $('.modal-backdrop').remove();
    }, 300);
}

function escButtonEvent() {
    const escEvent = new KeyboardEvent("keydown", {
        key: "Escape",
        code: "Escape",
        keyCode: 27,
        which: 27,
        bubbles: true
    });
    document.dispatchEvent(escEvent);
}