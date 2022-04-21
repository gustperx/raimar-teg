import { watch } from "vue";
import { debounce } from "vue-debounce";

export const useSearch = (form, url) => {
    const resetSearch = () => {
        if (!form.search) return;
        form.search = "";
    };

    const handleSearch = () => {
        form.get(url, form, {
            preserveState: true,
        });
    };

    const searchBouncer = debounce(handleSearch, "600ms");

    watch(form, searchBouncer);

    return {
        resetSearch,
    };
};
