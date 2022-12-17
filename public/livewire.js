document.querySelectorAll("[wire\\:snapshot]").forEach((el) => {
    el.__livewire = JSON.parse(el.getAttribute("wire:snapshot"));
    initLivewire(el);
    initWireModel(el);
});

function initLivewire(el) {
    el.addEventListener("click", (e) => {
        if (!e.target.hasAttribute("wire:click")) return;

        let method = e.target.getAttribute("wire:click");

        sendRequest(el, { callMethod: method });
    });
}

function initWireModel(el) {
    updateWireModelInputs(el);

    el.addEventListener("input", (e) => {
        if (!e.target.hasAttribute("wire:model")) return;

        let property = e.target.getAttribute("wire:model");
        let value = e.target.value;

        sendRequest(el, { updateProperty: [property, value] });
    });
}

function updateWireModelInputs(el) {
    let data = el.__livewire.data;

    el.querySelectorAll("[wire\\:model]").forEach((i) => {
        let property = i.getAttribute("wire:model");
        i.value = data[property];
        data.property;
    });
}

function sendRequest(el, addToPayload) {
    snapshot = el.__livewire;

    fetch("/livewire", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ snapshot, ...addToPayload }),
    })
        .then((i) => i.json())
        .then((response) => {
            let { snapshot, html } = response;
            el.__livewire = snapshot;
            Alpine.morph(el.firstElementChild, html);
            updateWireModelInputs(el);
        });
}
