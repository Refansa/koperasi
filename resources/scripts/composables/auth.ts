import { usePage } from "@inertiajs/inertia-vue3";

interface UserProperties {
    id: string | number,
    name: string,
    email: string,
    role: string,
}

interface AuthProperties {
    user: UserProperties,
}

function useAuth() {
    const page = usePage();
    const auth = page.props.value.auth;

    return auth as AuthProperties;
}

export {
    useAuth,
}
