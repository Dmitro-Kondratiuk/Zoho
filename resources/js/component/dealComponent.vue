<template>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-primary">Угоди (Deals)</h2>
            <button @click="showAddDealModal = true" class="btn btn-success btn-lg">
                <i class="bi bi-plus-circle"></i> Додати нову угоду
            </button>
        </div>

        <div v-if="showAddDealModal" class="modal fade show" id="addDealModal" tabindex="-1"
             aria-labelledby="addDealModalLabel" aria-hidden="true" style="display: block;">
            <div class="modal-dialog" style="width: 50%; margin: 0 auto;">
                <div class="modal-content shadow-lg">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title text-center" id="addDealModalLabel">Додати нову угоду</h5>
                        <button type="button" class="btn-close" @click="showAddDealModal = false"
                                aria-label="Закрити"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="addDeal">
                            <div class="mb-3">
                                <label for="dealName" class="form-label">Назва угоди</label>
                                <input
                                    type="text"
                                    v-model="newDeal.Deal_Name"
                                    class="form-control input-custom m-4"
                                    :class="{'is-invalid': errors.Deal_Name}"
                                    id="dealName"
                                    placeholder="Назва угоди"
                                    required
                                />
                                <div v-if="errors.Deal_Name" class="invalid-feedback">
                                    {{ errors.Deal_Name }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="dealStage" class="form-label">Стадія угоди</label>
                                <select
                                    v-model="newDeal.Stage"
                                    class="form-select input-custom m-4"
                                    :class="{'is-invalid': errors.Stage}"
                                    id="dealStage"
                                    required
                                >
                                    <option v-for="(stage, index) in stages" :key="index" :value="stage">
                                        {{ stage }}
                                    </option>
                                </select>
                                <div v-if="errors.Stage" class="invalid-feedback">
                                    {{ errors.Stage }}
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success">Зберегти</button>
                            <button type="button" class="btn btn-secondary ms-3" @click="showAddDealModal = false">
                                Закрити
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="showAddDealModal" class="modal-backdrop fade show"></div>
        <div v-if="deals.length" class="table-responsive mt-5">
            <table class="table table-bordered table-hover" style="width: 100%;">
                <thead class="table-dark">
                <tr>
                    <th>Назва угоди</th>
                    <th>Стадія угоди</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="deal in deals" :key="deal.id">
                    <td>{{ deal.Deal_Name }}</td>
                    <td>
                            <span class="badge">
                                {{ deal.Stage }}
                            </span>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <p v-else class="text-center text-muted">Угоди не знайдено.</p>
    </div>
</template>

<script lang="ts" setup>
import { defineProps, ref } from 'vue';
import { Stages, Deal } from "../object/Deals";
import axios from 'axios';

const props = defineProps<{
    dealsProps: Deal[];

}>();


const showAddDealModal = ref(false);
const newDeal = ref({
    Deal_Name: '',
    Stage: 'Prospecting',
});

const stages = Stages;
const deals = ref(props.dealsProps);
const errors = ref<{ [key: string]: string }>({});

const addDeal = async () => {
    errors.value = {};

    if (!newDeal.value.Deal_Name) {
        errors.value.Deal_Name = 'Назва угоди є обов\'язковою';
    }

    if (!newDeal.value.Stage) {
        errors.value.Stage = 'Стадія угоди є обов\'язковою';
    }


    if (Object.keys(errors.value).length > 0) {
        return;
    }

    try {
        const response = await axios.post('/api/createDeal', newDeal.value);
        if (response.status === 201) {
            const getResponse = await axios.get('/api/getAccount')
            deals.value = getResponse.data
            alert(response.data.message);

        } else {
            alert(response.data.message);
        }
    } catch (error) {
        alert(error);
    }
    showAddDealModal.value = false;

};
</script>

<style scoped>
.invalid-feedback {
    display: block;
    color: #dc3545;
}

.is-invalid {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
}
</style>
