import { usePage } from '@inertiajs/inertia-vue3';

interface AlertProperties {
    content: string;
    type?: 'info' | 'success' | 'error' | 'warning';
}

interface FlashProperties {
    alert: AlertProperties;
}

function useFlash() {
    const page = usePage();
    const flash = page.props.value.flash;

    return flash as FlashProperties;
}

export { useFlash, AlertProperties, FlashProperties };
