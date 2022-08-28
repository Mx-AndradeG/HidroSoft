<template>
    <div class="overlay">
        <div class="overlay__inner">
            <div class="overlay__content d-flex flex-column justify-content-center">
                <h2 class="align-self-center font-weight-bolder text-light">{{ title }}</h2>
                <h4 class="align-self-center font-weight-bold text-light">{{ message }}</h4>
                <span class="align-self-center spinner"></span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['title', 'message'],
    name: "OverlayLoader"
}
</script>

<style scoped>

.overlay {
    background-image: url('../../../../public/images/overlay-background.svg');
    background-size: cover;
    opacity: .95;
    left: 0;
    top: 0;
    z-index: 999999999;
    width: 100%;
    height: 100%;
    position: fixed;
}

.overlay__inner {
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    position: absolute;
}

.overlay__content {
    left: 50%;
    position: absolute;
    top: 50%;
    transform: translate(-50%, -50%);
}

.spinner {
    width: 75px;
    height: 75px;
    display: inline-block;
    border-width: 2px;
    border-color: rgba(255, 255, 255, 0.05);
    border-top-color: #fff;
    animation: spin 1s infinite linear;
    border-radius: 100%;
    border-style: solid;
}

@keyframes spin {
    100% {
        transform: rotate(360deg);
    }
}
</style>
