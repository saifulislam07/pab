import "./bootstrap";

import Alpine from "alpinejs";
import intersect from "@alpinejs/intersect";

Alpine.plugin(intersect);

Alpine.store('search', {
    query: ''
});

window.Alpine = Alpine;

Alpine.start();
