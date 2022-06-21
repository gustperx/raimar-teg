import { ref, watch, computed } from "vue";
import axios from "axios";

export const useComboUser = (props) => {
    const URL = "/ajax/get-users-by-deparment";

    const c_department_id = computed(() => props.form.current_department_id);
    const c_users = computed(() => props.users);

    const final_users = ref(c_users.value);

    const changeDepartmentHandle = (id) => {
        axios
            .post(URL, { department_id: id })
            .then((response) => {
                const { data } = response;
                final_users.value = data;
                props.form.user_responsible_id = null;
                props.form.user_assigned_id = null;
            })
            .catch((error) => console.log);
    };

    watch(c_department_id, (newValue, oldValue) => {
        if (newValue) {
            changeDepartmentHandle(newValue.id);
        }
    });

    return {
        final_users,
    };
};
