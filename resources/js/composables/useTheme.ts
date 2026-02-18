import { ref } from 'vue';

const STORAGE_KEY = 'tagwall:theme';
const AVAILABLE_THEMES = ['copper'] as const;
type Theme = typeof AVAILABLE_THEMES[number];
const DEFAULT_THEME_LIGHT: Theme = 'copper'
const DEFAULT_THEME_DARK: Theme = 'copper'

const getSavedTheme = (): Theme | null => {
    if (typeof window === 'undefined') {
        return null;
    }

    try {
        const theme = window.localStorage.getItem(STORAGE_KEY);
        if (theme && AVAILABLE_THEMES.includes(theme as Theme)) {
            return theme as Theme;
        } else {
            return null;
        }
    } catch {
        return null;
    }
};

const getInitialTheme = (): Theme => {
    const stored = getSavedTheme();

    if (stored) {
        return stored;
    }

    if (typeof window !== 'undefined' && window.matchMedia) {
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        if (prefersDark) {
            return DEFAULT_THEME_DARK;
        }
    }

    return DEFAULT_THEME_LIGHT;
};

export const useTheme = () => {

    const theme = ref<Theme>(DEFAULT_THEME_LIGHT);

    const setTheme = (nextTheme: Theme) => {
        theme.value = nextTheme;
        if (typeof document !== 'undefined') {
            document.documentElement.setAttribute(STORAGE_KEY, nextTheme);
        }

        if (typeof window !== 'undefined') {
            try {
                window.localStorage.setItem(STORAGE_KEY, nextTheme);
            } catch {
                console.warn('Could not store theme in localStorage.');
            }
        }
    };

    const initTheme = () => {
        setTheme(getInitialTheme());
    };

    return {
        theme,
        setTheme,
        initTheme,
    };
};

