import { usePage } from "@inertiajs/inertia-vue3";

interface AlertPropeties {
    content: string,
    type?: 'info' | 'success' | 'error' | 'warning',
}

interface FlashProperties {
    alert: AlertPropeties,
}

function useFlash() {
    const page = usePage();
    const flash = page.props.value.flash;

    return flash as FlashProperties;
}

export {
    useFlash,
}
