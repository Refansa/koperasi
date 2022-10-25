import { Ref, ref } from "vue";
import {
    darkTheme,
    lightTheme,
    useOsTheme
} from "naive-ui";

const useTheme = () => {
    const theme = localStorage.getItem("theme") ?? useOsTheme();
    return ref(theme === "light" ? lightTheme : darkTheme);
};

const setTheme = (theme: Ref) => {
    if (theme.value.name === 'light') {
        theme.value = darkTheme;
        localStorage.setItem('theme', 'dark');
    } else {
        theme.value = lightTheme;
        localStorage.setItem('theme', 'light');
    }
}

export {
    useTheme,
    setTheme
};
