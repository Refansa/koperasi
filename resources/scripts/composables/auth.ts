import { usePage } from '@inertiajs/inertia-vue3';
import { UserProperties } from '@/scripts/composables/model';
interface AuthProperties {
    user: UserProperties;
}

function useAuth() {
    const page = usePage();
    const auth = page.props.value.auth as AuthProperties;

    return auth;
}

export { useAuth, AuthProperties };
