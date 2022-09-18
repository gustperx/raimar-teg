import { ref, reactive } from "vue";
import axios from "axios";

export const useBrand = (type = 1) => {

    const URL = "/brands";

    const isOpenModal = ref(false);
    const brands = ref([]);
    const brandForm = reactive({
        name: "",
        type,
    });

    const saveBrand = () => {

        if (!brandForm.name) {
            alert('Campo nombre vacío');
            return;
        }

        axios
            .post(URL, brandForm)
            .then((response) => {
                const { data } = response;
                resetForm();
                closeModal();
                loadBrands();
            })
            .catch((error) => {
                resetForm();
                closeModal();
                console.log(error);
            });
    }

    const loadBrands = () => {
        axios
            .get(`${URL}?type=${type}`)
            .then((response) => {
                const { data } = response;
                brands.value = data;
            })
            .catch((error) => console.log);
    }

    const resetForm = () => {
        brandForm.name = "";
        brandForm.type = type;
    }

    const closeModal = () => {
        isOpenModal.value = false;
    };

    const openModal = () => {
        resetForm();
        isOpenModal.value = true;
    };

    loadBrands();

    return {
        brands,
        brandForm,
        isOpenModal,
        openModal,
        closeModal,
        saveBrand,
    }
}
