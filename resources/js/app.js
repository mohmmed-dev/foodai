import { Livewire , Alpine } from "../../vendor/livewire/livewire/dist/livewire.esm";

import intersect from '@alpinejs/intersect'


Alpine.plugin(intersect)
Livewire.start();

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import './echo';
