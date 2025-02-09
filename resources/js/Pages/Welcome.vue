<template>
    <accountComponent :accountsProps="accounts"/>
    <DealComponent :dealsProps="deals" />
</template>

<script setup>
import accountComponent from "../component/accountComponent.vue";
import DealComponent from "../component/dealComponent.vue";

const propsDeal = defineProps({
    deals: {
        type: Array,
        required: true
    },
    accounts:{
        type: Array,
        required: true
    }
})

</script>


<style>
.container {
    max-width: 100%;
    margin: auto;
}

.table th, .table td {
    text-align: center;
}

.table th {
    background-color: #007bff;
    color: #fff;
}

.table tbody tr:hover {
    background-color: #f1f1f1;
}

.badge {
    font-size: 1rem;
    padding: 8px 12px;
}

.bi {
    font-size: 1.2rem;
}


.input-custom {
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.input-custom:focus {
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

.btn-lg {
    font-size: 1.25rem;
    padding: 10px 20px;
}

.btn-success, .btn-secondary {
    font-size: 1rem;
    padding: 10px 20px;
    border-radius: 8px;
}

.btn-success {
    background-color: #28a745;
    border-color: #28a745;
}

.btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
}


.modal-dialog {
    width: 50%;
    margin: 0 auto;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1050;
}

.modal-content {
    border-radius: 8px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
}

.modal-header {
    background-color: #007bff;
    color: #fff;
}

.modal-body {
    background-color: #f8f9fa;
    padding: 20px;
}


.modal-backdrop {
    background-color: rgba(0, 0, 0, 0.8);
    z-index: 1040;
}


.table-responsive {
    margin-top: 20px;
    overflow-x: auto;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    border-radius: 8px;
}

.table {
    border-radius: 8px;
}

.table th {
    padding: 15px;
}

.table td {
    padding: 15px;
}

.btn-close {
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.btn {
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}</style>
