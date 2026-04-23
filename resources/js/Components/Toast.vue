<template>
    <div class="toast">
        <div class="toast-header">
            <h3 class="toast-title">Toast</h3>
            <button class="toast-close" @click="closeToast">
                <span class="toast-close-icon">×</span>
            </button>
        </div>
    </div>
</template>
<script setup>
const closeToast = () => {
    this.$toast.hide();
};
</script>
<style scoped>
.toast {
    position: fixed;
    top: 10px;
    right: 10px;
    z-index: 1000;
}
</style>