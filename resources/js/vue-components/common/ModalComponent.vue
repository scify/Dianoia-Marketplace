<template>
    <transition name="modal" v-if="open" @click="cancel">
        <div v-if="show" class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable" :class="classes">
                        <div class="modal-content">
                            <div class="modal-header">
                                <slot v-if="hasSlot('header')" name="header"></slot>
                                <button v-if="allowClose" type="button" class="btn-close"
                                        @click="cancel" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body mb-5 d-flex justify-content-center">
                                <slot name="body"></slot>
                            </div>
                            <div v-if="hasSlot('footer')" class="modal-footer text-center justify-content-center mb-5 flex-column">
                                <slot name="footer"></slot>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>
<script>

export default {
	props: {
		allowClose: {
			type: Boolean,
			default: false,
		},
		open: {
			type: Boolean,
			default: false,
		},
		classes: {
			type: String,
			default: "",
		}
	},
	data: function () {
		return {
			show: false,
		};
	},
	methods: {
		cancel() {
			this.$emit("canceled");
		},
		submit() {
			this.$emit("submit");
		},
		hasSlot (name = "default") {
			return !!this.$slots[ name ] || !!this.$slots[ name ];
		}
	},
	mounted() {
		this.show = true;
	}
};
</script>
<style scoped lang="scss">

@import "resources/sass/common/variables";
@import "resources/sass/common/modal";

</style>
