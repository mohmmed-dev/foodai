import { Livewire, Alpine } from "../../vendor/livewire/livewire/dist/livewire.esm";

// تأكد من أن Alpine غير محمل مسبقاً
if (!window.Alpine) {
    window.Alpine = Alpine;
}

// تأخير تحميل plugins حتى يتأكد اكتمال تحميل Alpine
setTimeout(() => {
    if (window.Alpine && !window.Alpine.$intersect) {
        import('@alpinejs/intersect').then(module => {
            window.Alpine.plugin(module.default);
        });
    }

    if (window.Alpine && !window.Alpine.$persist) {
        import('@alpinejs/persist').then(module => {
            window.Alpine.plugin(module.default);
        });
    }
}, 0);

Livewire.start();

import './echo';
console.log('sdd');
