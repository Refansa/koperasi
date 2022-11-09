import { useMessage } from 'naive-ui';
import { useFlash } from '@/scripts/composables/flash';

function useAlert() {
    const message = useMessage();
    const { alert } = useFlash();

    if (alert.content) {
        switch (alert.type) {
        case 'error':
            message.error(alert.content);
            break;
        case 'warning':
            message.warning(alert.content);
            break;
        case 'success':
            message.success(alert.content);
            break;
        default:
            message.info(alert.content);
            break;
        }
    }
}

export { useAlert };
