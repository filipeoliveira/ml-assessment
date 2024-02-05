export function debounce<F extends (...args: never[]) => void>(func: F, delay: number) {
    let timeoutId: number | null = null;

    return (...args: Parameters<F>) => {
        if (timeoutId) {
            clearTimeout(timeoutId);
        }

        timeoutId = setTimeout(() => func(...args), delay);
    };
}
